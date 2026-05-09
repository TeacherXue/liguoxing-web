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
      } else if (href === "/cases.html") {
        active = path === "/cases.html" || path.indexOf("/cases/") === 0;
      } else {
        active = path === href || path.endsWith(href);
      }
      if (active) {
        a.classList.add("active");
      }
    });
  }

  function injectPartials() {
    var headerHost = document.getElementById("site-header");
    var footerHost = document.getElementById("site-footer");
    if (!headerHost || !footerHost) {
      return Promise.resolve();
    }

    function load(name) {
      return fetch("/includes/" + name + ".html").then(function (r) {
        if (!r.ok) throw new Error("Failed to load partial: " + name);
        return r.text();
      });
    }

    return Promise.all([load("header"), load("footer")])
      .then(function (parts) {
        headerHost.outerHTML = parts[0].trim();
        footerHost.outerHTML = parts[1].trim();
        setActiveNav();
      })
      .catch(function (err) {
        console.error("[site-shell]", err);
      });
  }

  window.siteShellReady = injectPartials();
})();
