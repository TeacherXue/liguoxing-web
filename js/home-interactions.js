(function () {
  function initHomeInteractions() {
  const home = document.querySelector("[data-home-page]");
  if (!home) return;

  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const selectors = [
    ".metric-strip",
    ".precision-section .section-head",
    ".process-card",
    ".about-photo",
    ".about-content",
    ".about-features article",
    ".applications-band .band-head",
    ".application-card",
    ".how-section .section-head",
    ".workflow article",
    ".news-head",
    ".news-card",
    ".cta",
  ];

  const targets = Array.from(home.querySelectorAll(selectors.join(",")));
  targets.forEach((target, index) => {
    target.classList.add("scroll-reveal");
    target.style.setProperty("--reveal-delay", `${Math.min(index % 5, 4) * 70}ms`);
  });

  if (prefersReducedMotion || !("IntersectionObserver" in window)) {
    targets.forEach((target) => target.classList.add("is-visible"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target);
      });
    },
    {
      threshold: 0.16,
      rootMargin: "0px 0px -8% 0px",
    }
  );

  targets.forEach((target) => observer.observe(target));
  }

  var shell = window.siteShellReady;
  if (shell && typeof shell.then === "function") {
    shell.then(initHomeInteractions);
  } else {
    initHomeInteractions();
  }
})();
