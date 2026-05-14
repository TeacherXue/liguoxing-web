(function () {
  function initHomeBanner() {
  const hero = document.querySelector("[data-hero-carousel]");
  if (!hero) return;

  const copy = hero.querySelector(".hero-copy");
  const kicker = hero.querySelector(".kicker");
  const title = hero.querySelector("h1");
  const text = hero.querySelector(".hero-copy p");
  const primary = hero.querySelector(".hero-buttons .btn-primary");
  const secondary = hero.querySelector(".hero-buttons .btn-ghost");
  const machine = hero.querySelector(".hero-machine");
  const machineWatermark = hero.querySelector(".hero-machine-watermark");
  const prevButton = hero.querySelector("[data-hero-prev]");
  const nextButton = hero.querySelector("[data-hero-next]");
  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  const slides = [
    {
      bg: 'url("/images/footer.jpg")',
      machine: 'url("/images/hero-slide-line.webp")',
      kicker: "Manufacturer <i></i> Factory <i></i> Direct",
      title:
        'Direct Block Bottomer Machine<br><span>Manufacturer</span>',
      text:
        "With 30 years of manufacturing experience, we provide factory-direct square bottom valve bag making machines with premium quality and prices.",
      primary: "Explore Equipment",
      secondary: "Request a Quote",
    },
    {
      bg: 'url("/images/home.webp")',
      machine: 'url("/images/hero-slide-unwind.webp")',
      kicker: "Automation <i></i> Welding <i></i> Servo",
      title:
        'Advanced Hot Air<br><span>Welding Technology</span>',
      text:
        "Featuring servo-driven control, 120 pcs/min high-speed production, and nano micro-perforation, our machines deliver dust-free, superior packaging solutions.",
      primary: "Explore Equipment",
      secondary: "Request a Quote",
    },
    {
      bg: 'url("/images/p1.webp")',
      machine: 'url("/images/hero-slide-process.webp")',
      kicker: "Global <i></i> Proven <i></i> Export",
      title:
        'Trusted By Global<br><span>Packaging Plants</span>',
      text:
        "With over 200 sets delivered worldwide, we empower top cement and chemical factories globally with reliable valve bag production lines.",
      primary: "Explore Equipment",
      secondary: "Request a Quote",
    },
  ];

  let current = 0;
  let timer = null;
  let activeBg = null;
  const interval = 5000;
  const firstInterval = 2600;

  function createBgPanel(bg, className) {
    const panel = document.createElement("div");
    panel.className = `hero-bg-panel ${className}`;
    panel.style.setProperty("--panel-bg", bg);
    hero.prepend(panel);
    return panel;
  }

  /** Same slide transition as .hero-machine so faint watermark never mixes two images. */
  function crossfadeHeroMachineVisual(el, previousSlide, enteringClass, leavingClass) {
    if (!el) return;
    const leavingEl = el.cloneNode(true);
    leavingEl.style.setProperty("--hero-machine", previousSlide.machine);
    leavingEl.classList.add(leavingClass);
    hero.insertBefore(leavingEl, el);
    el.classList.remove("is-entering", "is-entering-prev");
    void el.offsetWidth;
    el.classList.add(enteringClass);
    leavingEl.addEventListener(
      "animationend",
      function () {
        leavingEl.remove();
      },
      { once: true }
    );
    el.addEventListener(
      "animationend",
      function () {
        el.classList.remove("is-entering", "is-entering-prev");
      },
      { once: true }
    );
  }

  function restartReveal() {
    if (prefersReducedMotion || !copy) return;
    copy.classList.remove("is-revealing");
    void copy.offsetWidth;
    copy.classList.add("is-revealing");
  }

  function slideVisuals(nextSlide, previousSlide, isInitial, direction) {
    hero.style.setProperty("--hero-bg", nextSlide.bg);
    hero.style.setProperty("--hero-machine", nextSlide.machine);

    if (prefersReducedMotion || isInitial) {
      if (activeBg) activeBg.remove();
      activeBg = createBgPanel(nextSlide.bg, "");
      return;
    }

    const enteringClass = direction === "prev" ? "is-entering-prev" : "is-entering";
    const leavingClass = direction === "prev" ? "is-leaving-prev" : "is-leaving";
    const leavingBg = activeBg || createBgPanel(previousSlide.bg, "");
    leavingBg.classList.add(leavingClass);
    activeBg = createBgPanel(nextSlide.bg, enteringClass);

    leavingBg.addEventListener("animationend", function () {
      leavingBg.remove();
    }, { once: true });

    crossfadeHeroMachineVisual(machine, previousSlide, enteringClass, leavingClass);
    crossfadeHeroMachineVisual(machineWatermark, previousSlide, enteringClass, leavingClass);
  }

  function render(index, direction = "next") {
    const slide = slides[index];
    const previousSlide = slides[current] || slide;
    const isInitial = activeBg === null;
    slideVisuals(slide, previousSlide, isInitial, direction);
    if (kicker) kicker.innerHTML = slide.kicker;
    if (title) title.innerHTML = slide.title;
    if (text) text.textContent = slide.text;
    if (primary) primary.innerHTML = slide.primary;
    if (secondary) secondary.innerHTML = slide.secondary;
    restartReveal();
    current = index;
  }

  function next() {
    render((current + 1) % slides.length, "next");
  }

  function prev() {
    render((current - 1 + slides.length) % slides.length, "prev");
  }

  function schedule(delay = interval) {
    window.clearTimeout(timer);
    timer = window.setTimeout(function () {
      next();
      schedule(interval);
    }, delay);
  }

  function stop() {
    window.clearTimeout(timer);
    timer = null;
  }

  hero.addEventListener("mouseenter", function () {
    stop();
  });

  hero.addEventListener("mouseleave", function () {
    schedule(interval);
  });

  if (nextButton) {
    nextButton.addEventListener("click", function () {
      next();
      schedule(interval);
    });
  }

  if (prevButton) {
    prevButton.addEventListener("click", function () {
      prev();
      schedule(interval);
    });
  }

  render(0, "next");
  schedule(firstInterval);
  }

  var shell = window.siteShellReady;
  if (shell && typeof shell.then === "function") {
    shell.then(initHomeBanner);
  } else {
    initHomeBanner();
  }
})();
