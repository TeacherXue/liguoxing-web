(function () {
  var root = document.querySelector("[data-news-archive]");
  var pager = document.querySelector("[data-news-archive-pager]");
  if (!root || !pager) return;

  var items = Array.from(root.querySelectorAll("[data-news-archive-item]"));
  if (!items.length) return;

  var PER_PAGE = 6;
  var totalPages = Math.max(1, Math.ceil(items.length / PER_PAGE));
  var current = 1;

  function renderItems() {
    var start = (current - 1) * PER_PAGE;
    items.forEach(function (el, i) {
      var on = i >= start && i < start + PER_PAGE;
      el.hidden = !on;
      el.setAttribute("aria-hidden", on ? "false" : "true");
    });
  }

  function syncPagerControls() {
    var prevBtn = pager.querySelector("[data-news-prev]");
    var nextBtn = pager.querySelector("[data-news-next]");
    if (prevBtn) prevBtn.disabled = current <= 1;
    if (nextBtn) nextBtn.disabled = current >= totalPages;
    pager.querySelectorAll("[data-news-page]").forEach(function (btn) {
      var p = parseInt(btn.getAttribute("data-news-page"), 10);
      var isCurrent = p === current;
      btn.classList.toggle("is-current", isCurrent);
      btn.setAttribute("aria-current", isCurrent ? "page" : "false");
      btn.disabled = isCurrent;
    });
  }

  function buildPager() {
    pager.innerHTML = "";
    if (totalPages <= 1) {
      pager.hidden = true;
      return;
    }
    pager.hidden = false;

    var prevBtn = document.createElement("button");
    prevBtn.type = "button";
    prevBtn.className = "video-archive-pager-btn";
    prevBtn.setAttribute("data-news-prev", "");
    prevBtn.textContent = "Previous";
    prevBtn.setAttribute("aria-label", "Previous page");
    pager.appendChild(prevBtn);

    var pagesWrap = document.createElement("div");
    pagesWrap.className = "video-archive-pager-pages";
    for (var p = 1; p <= totalPages; p++) {
      var b = document.createElement("button");
      b.type = "button";
      b.className = "video-archive-pager-btn";
      b.setAttribute("data-news-page", String(p));
      b.textContent = String(p);
      b.setAttribute("aria-label", "Page " + p);
      pagesWrap.appendChild(b);
    }
    pager.appendChild(pagesWrap);

    var nextBtn = document.createElement("button");
    nextBtn.type = "button";
    nextBtn.className = "video-archive-pager-btn";
    nextBtn.setAttribute("data-news-next", "");
    nextBtn.textContent = "Next";
    nextBtn.setAttribute("aria-label", "Next page");
    pager.appendChild(nextBtn);
  }

  function go(page, scrollAfter) {
    current = Math.min(Math.max(1, page), totalPages);
    renderItems();
    syncPagerControls();
    if (scrollAfter) {
      var y = root.getBoundingClientRect().top + window.scrollY - 100;
      if (y < 0) y = 0;
      window.scrollTo({ top: y, behavior: "smooth" });
    }
  }

  pager.addEventListener("click", function (ev) {
    var t = ev.target.closest("button");
    if (!t || !pager.contains(t) || t.disabled) return;
    if (t.hasAttribute("data-news-prev")) {
      ev.preventDefault();
      go(current - 1, true);
      return;
    }
    if (t.hasAttribute("data-news-next")) {
      ev.preventDefault();
      go(current + 1, true);
      return;
    }
    var pg = t.getAttribute("data-news-page");
    if (pg != null) {
      ev.preventDefault();
      go(parseInt(pg, 10), true);
    }
  });

  buildPager();
  go(1, false);
})();
