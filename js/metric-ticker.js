(function () {
  function randomDigit() {
    return String(Math.floor(Math.random() * 10));
  }

  /**
   * 加载时数字快速随机切换，间隔逐渐拉长，约 1s 后停在目标值。
   */
  function runDigitShuffle(valEl, finalStr) {
    valEl.innerHTML = "";
    valEl.classList.add("metric-value--roll");

    var digitEls = [];
    var frag = document.createDocumentFragment();

    for (var i = 0; i < finalStr.length; i++) {
      var ch = finalStr.charAt(i);
      if (ch === "-") {
        var sep = document.createElement("span");
        sep.className = "metric-roll-sep";
        sep.textContent = "-";
        frag.appendChild(sep);
      } else if (ch >= "0" && ch <= "9") {
        var span = document.createElement("span");
        span.className = "metric-shuffle-digit";
        span.textContent = randomDigit();
        span.dataset.final = ch;
        digitEls.push(span);
        frag.appendChild(span);
      }
    }
    valEl.appendChild(frag);

    if (!digitEls.length) return;

    var durationMs = 1000;
    var anchor = performance.now();
    var lastTick = anchor;

    var tickId = window.setInterval(function () {
      var now = performance.now();
      var elapsed = now - anchor;
      if (elapsed >= durationMs) {
        digitEls.forEach(function (el) {
          el.textContent = el.dataset.final;
        });
        window.clearInterval(tickId);
        return;
      }

      var u = elapsed / durationMs;
      var intervalMs = 22 + u * u * 240;

      if (now - lastTick >= intervalMs) {
        digitEls.forEach(function (el) {
          el.textContent = randomDigit();
        });
        lastTick = now;
      }
    }, 16);
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
          runDigitShuffle(valEl, text);
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
      { threshold: 0.08, rootMargin: "0px 0px 0px 0px" }
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
