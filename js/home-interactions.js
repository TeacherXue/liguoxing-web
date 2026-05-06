(function () {
  const root = document.querySelector(".home-page");
  if (!root) return;

  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function setupReveal() {
    const targets = document.querySelectorAll(
      ".home-page .section h2, .home-page .section .lead, .home-page .stats, .home-page .grid-3, .home-page .grid-4, .home-page .news-list"
    );
    targets.forEach((el) => el.classList.add("fx-reveal"));

    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
      targets.forEach((el) => el.classList.add("is-visible"));
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.18, rootMargin: "0px 0px -8% 0px" }
    );

    targets.forEach((el) => observer.observe(el));
  }

  function setupHeroParallax() {
    if (prefersReducedMotion) return;
    const hero = document.querySelector("[data-hero-parallax]");
    if (!hero) return;

    hero.addEventListener("mousemove", function (event) {
      const rect = hero.getBoundingClientRect();
      const x = (event.clientX - rect.left) / rect.width - 0.5;
      const y = (event.clientY - rect.top) / rect.height - 0.5;
      hero.style.setProperty("--mx", x.toFixed(3));
      hero.style.setProperty("--my", y.toFixed(3));
    });

    hero.addEventListener("mouseleave", function () {
      hero.style.setProperty("--mx", "0");
      hero.style.setProperty("--my", "0");
    });
  }

  function setupScrollParallax() {
    if (prefersReducedMotion) return;
    const hero = document.querySelector("[data-hero-parallax]");
    if (!hero) return;

    function onScroll() {
      const rect = hero.getBoundingClientRect();
      const viewport = window.innerHeight || 1;
      if (rect.bottom <= 0 || rect.top >= viewport) return;

      const progress = Math.min(Math.max((viewport - rect.top) / (viewport + rect.height), 0), 1);
      const fast = (progress - 0.5) * -42;
      const slow = (progress - 0.5) * -14;

      hero.style.setProperty("--scroll-fast", `${fast.toFixed(2)}px`);
      hero.style.setProperty("--scroll-slow", `${slow.toFixed(2)}px`);
    }

    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll);
    onScroll();
  }

  function setupAboutDepthStack() {
    if (prefersReducedMotion) return;
    const stacks = document.querySelectorAll(".home-page [data-depth-stack]");
    if (!stacks.length) return;

    function onScroll() {
      const viewport = window.innerHeight || 1;
      stacks.forEach((stack) => {
        const rect = stack.getBoundingClientRect();
        if (rect.bottom <= 0 || rect.top >= viewport) return;

        const progress = Math.min(Math.max((viewport - rect.top) / (viewport + rect.height), 0), 1);
        const fast = (progress - 0.5) * -56;
        const slow = (progress - 0.5) * -20;

        stack.style.setProperty("--stack-fast", `${fast.toFixed(2)}px`);
        stack.style.setProperty("--stack-slow", `${slow.toFixed(2)}px`);
      });
    }

    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll);
    onScroll();
  }

  function setupCardTilt() {
    if (prefersReducedMotion) return;
    const cards = document.querySelectorAll(".home-page .card");
    cards.forEach((card) => {
      card.style.setProperty("--px", "50%");
      card.style.setProperty("--py", "50%");
      card.addEventListener("mousemove", function (event) {
        const rect = card.getBoundingClientRect();
        const x = (event.clientX - rect.left) / rect.width - 0.5;
        const y = (event.clientY - rect.top) / rect.height - 0.5;
        card.style.setProperty("--rx", `${(-y * 4).toFixed(2)}deg`);
        card.style.setProperty("--ry", `${(x * 5).toFixed(2)}deg`);
        card.style.setProperty("--px", `${((x + 0.5) * 100).toFixed(1)}%`);
        card.style.setProperty("--py", `${((y + 0.5) * 100).toFixed(1)}%`);
      });
      card.addEventListener("mouseleave", function () {
        card.style.setProperty("--rx", "0deg");
        card.style.setProperty("--ry", "0deg");
        card.style.setProperty("--px", "50%");
        card.style.setProperty("--py", "50%");
      });
    });
  }

  function setupMagneticButtons() {
    if (prefersReducedMotion) return;
    const buttons = document.querySelectorAll(".home-page [data-magnetic]");
    buttons.forEach((btn) => {
      btn.addEventListener("mousemove", function (event) {
        const rect = btn.getBoundingClientRect();
        const x = (event.clientX - rect.left) / rect.width - 0.5;
        const y = (event.clientY - rect.top) / rect.height - 0.5;
        btn.style.transform = `translate3d(${(x * 8).toFixed(2)}px, ${(y * 6).toFixed(2)}px, 0)`;
      });
      btn.addEventListener("mouseleave", function () {
        btn.style.transform = "translate3d(0,0,0)";
      });
    });
  }

  setupReveal();
  setupHeroParallax();
  setupScrollParallax();
  setupAboutDepthStack();
  setupCardTilt();
  setupMagneticButtons();
})();
