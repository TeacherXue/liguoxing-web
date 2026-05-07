(function () {
  /**
   * 每位数字独立竖直滚轴：偶数位从上往下「卷入」，奇数位从下往上「卷入」（交替）。
   */
  function createDigitRoller(targetDigit, digitCol, spinBase, durationMs, delayMs) {
    var repeats = 8;
    var wrap = document.createElement("span");
    wrap.className = "digit-roller";
    var track = document.createElement("span");
    track.className = "digit-roller-track";

    for (var r = 0; r < repeats; r++) {
      for (var d = 0; d <= 9; d++) {
        var cell = document.createElement("span");
        cell.className = "digit-roller-cell";
        cell.textContent = String(d);
        track.appendChild(cell);
      }
    }
    wrap.appendChild(track);

    var cycleLen = 10;
    var prefixLoops = 5;
    var finalIdx = prefixLoops * cycleLen + targetDigit;
    var spinCells = spinBase + digitCol * 3;
    var fromTop = digitCol % 2 === 0;

    wrap.dataset.finalIndex = String(finalIdx);
    wrap.dataset.spinCells = String(spinCells);
    wrap.dataset.fromTop = fromTop ? "1" : "0";
    wrap.dataset.delayMs = String(delayMs);
    wrap.dataset.durationMs = String(durationMs);
    return wrap;
  }

  function runDigitRoll(valEl, finalStr, rowDelay) {
    valEl.innerHTML = "";
    valEl.classList.add("metric-value--roll");

    var spinBase = 24;
    var durationMs = 1000;
    var digitCol = 0;
    var frag = document.createDocumentFragment();

    for (var i = 0; i < finalStr.length; i++) {
      var ch = finalStr.charAt(i);
      if (ch === "-") {
        var sep = document.createElement("span");
        sep.className = "metric-roll-sep";
        sep.textContent = "-";
        frag.appendChild(sep);
      } else if (ch >= "0" && ch <= "9") {
        var d = parseInt(ch, 10);
        frag.appendChild(createDigitRoller(d, digitCol, spinBase, durationMs, rowDelay + digitCol * 76));
        digitCol += 1;
      }
    }
    valEl.appendChild(frag);

    requestAnimationFrame(function () {
      var sample = valEl.querySelector(".digit-roller-cell");
      var h = sample ? sample.getBoundingClientRect().height : 0;
      if (!h) return;

      var rollers = valEl.querySelectorAll(".digit-roller");
      rollers.forEach(function (roller) {
        var track = roller.querySelector(".digit-roller-track");
        if (!track) return;

        var finalIdx = parseInt(roller.dataset.finalIndex, 10);
        var spinCells = parseInt(roller.dataset.spinCells, 10);
        var fromTop = roller.dataset.fromTop === "1";
        var delayMs = parseInt(roller.dataset.delayMs, 10) || 0;
        var dur = parseInt(roller.dataset.durationMs, 10) || 1000;

        var startIdx;
        var endIdx = finalIdx;
        if (fromTop) {
          startIdx = finalIdx + spinCells;
        } else {
          startIdx = Math.max(0, finalIdx - spinCells);
        }

        var startPx = -startIdx * h;
        var endPx = -endIdx * h;

        track.style.transform = "translateY(" + startPx + "px)";
        track.style.transition = "none";

        requestAnimationFrame(function () {
          requestAnimationFrame(function () {
            track.style.transition =
              "transform " + dur + "ms cubic-bezier(0.22, 1, 0.36, 1)";
            track.style.transitionDelay = delayMs + "ms";
            track.style.transform = "translateY(" + endPx + "px)";
          });
        });
      });
    });
  }

  function finalStringForRow(row) {
    var kind = row.getAttribute("data-metric-type");
    if (kind === "range") {
      var mn = row.getAttribute("data-min");
      var mx = row.getAttribute("data-max");
      if (mn != null && mx != null) return mn + "-" + mx;
    }
    var v = row.getAttribute("data-value");
    return v != null ? String(v) : "";
  }

  function initMetricStrip(strip) {
    var reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (reduced || !("IntersectionObserver" in window)) {
      return;
    }

    var rows = strip.querySelectorAll(".metric");
    if (!rows.length) return;

    var played = false;

    function play() {
      if (played) return;
      played = true;
      strip.classList.add("metric-strip--inview");

      rows.forEach(function (row, index) {
        var icon = row.querySelector(".metric-icon");
        var valEl = row.querySelector(".metric-value");
        if (!valEl) return;

        var rowDelay = index * 100;

        window.setTimeout(function () {
          if (icon) icon.classList.add("metric-icon--lit");
        }, rowDelay);

        window.setTimeout(function () {
          var text = finalStringForRow(row);
          if (!text) return;
          runDigitRoll(valEl, text, 0);
        }, rowDelay + 48);
      });
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            play();
            observer.disconnect();
          }
        });
      },
      { threshold: 0.28, rootMargin: "0px 0px -5% 0px" }
    );

    observer.observe(strip);
  }

  function boot() {
    var strip = document.querySelector("[data-metric-strip]");
    if (strip) initMetricStrip(strip);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();
