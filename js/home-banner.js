(function () {
  const slider = document.querySelector("[data-banner-slider]");
  if (!slider) return;

  const slides = Array.from(slider.querySelectorAll("[data-slide]"));
  const dotsWrap = document.querySelector("[data-slide-dots]");
  const dots = dotsWrap ? Array.from(dotsWrap.querySelectorAll("[data-slide-to]")) : [];
  const prevBtn = document.querySelector("[data-slide-prev]");
  const nextBtn = document.querySelector("[data-slide-next]");

  if (!slides.length) return;

  let current = 0;
  let timer = null;
  const interval = 5000;

  function render(index) {
    slides.forEach((slide, i) => {
      const active = i === index;
      slide.classList.toggle("is-active", active);
      slide.hidden = !active;
    });

    dots.forEach((dot, i) => {
      dot.classList.toggle("is-active", i === index);
    });

    current = index;
  }

  function next() {
    render((current + 1) % slides.length);
  }

  function prev() {
    render((current - 1 + slides.length) % slides.length);
  }

  function restart() {
    if (timer) {
      window.clearInterval(timer);
    }
    timer = window.setInterval(next, interval);
  }

  if (nextBtn) {
    nextBtn.addEventListener("click", function () {
      next();
      restart();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener("click", function () {
      prev();
      restart();
    });
  }

  dots.forEach((dot) => {
    dot.addEventListener("click", function () {
      const target = Number(dot.getAttribute("data-slide-to"));
      if (Number.isNaN(target)) return;
      render(target);
      restart();
    });
  });

  slider.addEventListener("mouseenter", function () {
    if (timer) {
      window.clearInterval(timer);
      timer = null;
    }
  });

  slider.addEventListener("mouseleave", function () {
    restart();
  });

  render(current);
  restart();
})();
