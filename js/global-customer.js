(function () {
  function initGlobalCustomer() {
    var section = document.querySelector("[data-global-customer]");
    if (!section) return;

    var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
      section.classList.add("is-activated");
      return;
    }

    var activated = false;
    function activate() {
      if (activated) return;
      activated = true;
      section.classList.add("is-activated");
    }

    if (section.getBoundingClientRect().top < window.innerHeight * 0.92) {
      activate();
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          activate();
          observer.disconnect();
        });
      },
      {
        threshold: 0.08,
        rootMargin: "0px 0px -6% 0px",
      }
    );

    observer.observe(section);
  }

  var shell = window.siteShellReady;
  if (shell && typeof shell.then === "function") {
    shell.then(initGlobalCustomer);
  } else {
    initGlobalCustomer();
  }
})();
