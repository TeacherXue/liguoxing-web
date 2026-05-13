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
      try {
        href = new URL(href, window.location.origin).pathname;
      } catch (error) {
        return;
      }
      href = normalizePath(href);
      a.classList.remove("active");
      var active = false;
      if (href === "/" || href === "") {
        active = path === "/" || path.endsWith("/index.htm") || path.endsWith("/index.html");
      } else if (href === "/equipment.htm" || href === "/equipment.html") {
        if (a.classList.contains("nav-link")) {
          active = path === "/equipment.htm" || path === "/equipment.html" || path.indexOf("/equipment-") === 0;
        } else {
          active = path === "/equipment.htm" || path === "/equipment.html";
        }
      } else if (href === "/application.htm" || href === "/application.html") {
        active = path === "/application.htm" || path === "/application.html" || path.indexOf("/applications/") === 0;
      } else if (href === "/news.htm" || href === "/news.html") {
        active = path === "/news.htm" || path === "/news.html" || path.indexOf("/news/") === 0;
      } else if (href === "/video.htm" || href === "/video.html") {
        active = path === "/video.htm" || path === "/video.html" || path.indexOf("/video/") === 0;
      } else if (href === "/cases.htm" || href === "/cases.html") {
        active = path === "/cases.htm" || path === "/cases.html" || path.indexOf("/cases/") === 0;
      } else {
        active = path === href || path.endsWith(href);
      }
      if (active) {
        a.classList.add("active");
      }
    });
  }

  function bindMobileNav() {
    var header = document.querySelector(".header");
    if (!header) return;

    var toggle = header.querySelector(".mobile-menu-toggle");
    var drawer = header.querySelector(".nav-right");
    var backdrop = header.querySelector(".mobile-nav-backdrop");
    var dropdownToggle = header.querySelector(".nav-dropdown-toggle");
    var dropdown = header.querySelector(".nav-dropdown");
    var mobileQuery = window.matchMedia("(max-width: 720px)");

    if (!toggle || !drawer || !backdrop) return;

    function syncExpanded() {
      var expanded = header.classList.contains("mobile-nav-open");
      toggle.setAttribute("aria-expanded", expanded ? "true" : "false");
      document.body.classList.toggle("mobile-nav-open", expanded);
      if (!expanded && dropdown) {
        dropdown.classList.remove("is-expanded");
      }
    }

    function closeDrawer() {
      header.classList.remove("mobile-nav-open");
      syncExpanded();
    }

    function openDrawer() {
      header.classList.add("mobile-nav-open");
      syncExpanded();
    }

    toggle.addEventListener("click", function () {
      if (!mobileQuery.matches) return;
      if (header.classList.contains("mobile-nav-open")) {
        closeDrawer();
      } else {
        openDrawer();
      }
    });

    backdrop.addEventListener("click", closeDrawer);

    drawer.querySelectorAll("a[href]").forEach(function (link) {
      link.addEventListener("click", function () {
        if (mobileQuery.matches) {
          closeDrawer();
        }
      });
    });

    if (dropdownToggle && dropdown) {
      dropdownToggle.addEventListener("click", function (event) {
        if (!mobileQuery.matches) return;
        event.preventDefault();
        event.stopPropagation();
        dropdown.classList.toggle("is-expanded");
      });
    }

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        closeDrawer();
      }
    });

    mobileQuery.addEventListener("change", function (event) {
      if (!event.matches) {
        closeDrawer();
      }
    });

    syncExpanded();
  }

  function injectPartials() {
    var headerHost = document.getElementById("site-header");
    var footerHost = document.getElementById("site-footer");
    if (!headerHost || !footerHost) {
      setActiveNav();
      bindMobileNav();
      return Promise.resolve();
    }

    function load(name) {
      return fetch("/includes/" + name + ".htm", { cache: "no-cache" }).then(function (r) {
        if (!r.ok) throw new Error("Failed to load partial: " + name);
        return r.text();
      });
    }

    return Promise.all([load("header"), load("footer")])
      .then(function (parts) {
        headerHost.outerHTML = parts[0].trim();
        footerHost.outerHTML = parts[1].trim();
        setActiveNav();
        bindMobileNav();
      })
      .catch(function (err) {
        console.error("[site-shell]", err);
      });
  }

  window.siteShellReady = injectPartials();
})();
