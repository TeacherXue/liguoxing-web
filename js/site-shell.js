(function () {
  function normalizePath(pathname) {
    let p = pathname || "/";
    if (p.length > 1 && p.endsWith("/")) {
      p = p.slice(0, -1);
    }
    return p;
  }

  function setActiveNav() {
    const path = normalizePath(window.location.pathname);
    document.querySelectorAll(".header .nav a[href]").forEach(function (a) {
      var href = a.getAttribute("href");
      if (!href || href === "#" || href.indexOf("javascript:") === 0) return;
      a.classList.remove("active");
      var active = false;
      if (href === "/") {
        active = path === "/" || path.endsWith("/index.html");
      } else if (href === "/equipment.html") {
        if (a.classList.contains("nav-link")) {
          active = path === "/equipment.html" || path.indexOf("/equipment-") === 0;
        } else {
          active = path === "/equipment.html";
        }
      } else if (href === "/application.html") {
        active = path === "/application.html" || path.indexOf("/applications/") === 0;
      } else if (href === "/news.html") {
        active = path === "/news.html" || path.indexOf("/news/") === 0;
      } else if (href === "/videos.html") {
        active = path === "/videos.html";
      } else {
        active = path === href || path.endsWith(href);
      }
      if (active) {
        a.classList.add("active");
      }
    });
  }

  function initNavDrawer() {
    var header = document.querySelector(".header");
    if (!header) return;

    var mq = window.matchMedia("(max-width: 960px)");

    function closeDrawer() {
      header.classList.remove("is-nav-drawer-open");
      document.body.classList.remove("is-nav-drawer-open");
      var toggle = header.querySelector("[data-nav-drawer-toggle]");
      if (toggle) toggle.setAttribute("aria-expanded", "false");
    }

    function openDrawer() {
      if (!mq.matches) return;
      header.classList.add("is-nav-drawer-open");
      document.body.classList.add("is-nav-drawer-open");
      var toggle = header.querySelector("[data-nav-drawer-toggle]");
      if (toggle) toggle.setAttribute("aria-expanded", "true");
    }

    function toggleDrawer() {
      if (!mq.matches) return;
      if (header.classList.contains("is-nav-drawer-open")) {
        closeDrawer();
      } else {
        openDrawer();
      }
    }

    header.addEventListener("click", function (e) {
      if (e.target.closest("[data-nav-drawer-toggle]")) {
        e.preventDefault();
        toggleDrawer();
        return;
      }
      if (e.target.closest("[data-nav-drawer-close]") || e.target.closest("[data-nav-drawer-close-btn]")) {
        closeDrawer();
        return;
      }
      var link = e.target.closest("#nav-drawer-panel a[href]");
      if (link && mq.matches) {
        var href = link.getAttribute("href");
        if (href && href.charAt(0) !== "#") closeDrawer();
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && header.classList.contains("is-nav-drawer-open")) {
        closeDrawer();
      }
    });

    window.addEventListener(
      "resize",
      function () {
        if (!mq.matches) closeDrawer();
      },
      { passive: true }
    );
  }

  function partialBase() {
    var link = document.querySelector('link[href*="css/main.css"]');
    if (link) {
      var href = link.getAttribute("href") || "";
      var idx = href.indexOf("css/main.css");
      if (idx > 0) return href.slice(0, idx);
    }
    return "/";
  }

  function initShellFromExistingHeader() {
    if (!document.querySelector(".header")) return;
    setActiveNav();
    initNavDrawer();
  }

  function injectPartials() {
    var headerHost = document.getElementById("site-header");
    var footerHost = document.getElementById("site-footer");
    if (!headerHost || !footerHost) {
      initShellFromExistingHeader();
      return Promise.resolve();
    }

    var base = partialBase();

    function load(name) {
      return fetch(base + name + ".html", { cache: "no-cache" }).then(function (r) {
        if (!r.ok) throw new Error("Failed to load partial: " + name);
        return r.text();
      });
    }

    return Promise.all([load("header"), load("footer")])
      .then(function (parts) {
        headerHost.outerHTML = parts[0].trim();
        footerHost.outerHTML = parts[1].trim();
        setActiveNav();
        initNavDrawer();
      })
      .catch(function (err) {
        console.error("[site-shell]", err);
        initShellFromExistingHeader();
      });
  }

  window.siteShellReady = injectPartials();
})();
