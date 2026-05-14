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

  function initCustomerPhotoLightbox() {
    var section = document.querySelector("[data-global-customer]");
    if (!section) return;

    var modal = document.createElement("div");
    modal.className = "gc-photo-lightbox";
    modal.setAttribute("role", "dialog");
    modal.setAttribute("aria-modal", "true");
    modal.setAttribute("aria-label", "Customer photo");
    modal.innerHTML = [
      '<div class="gc-photo-lightbox-panel">',
      '<button type="button" class="gc-photo-lightbox-close" aria-label="Close">&times;</button>',
      '<img class="gc-photo-lightbox-img" src="" alt="">',
      "</div>",
    ].join("");
    document.body.appendChild(modal);

    var lightboxImg = modal.querySelector(".gc-photo-lightbox-img");
    var closeBtn = modal.querySelector(".gc-photo-lightbox-close");
    var lastFocus = null;

    section.querySelectorAll(".customer-node").forEach(function (node) {
      node.setAttribute("tabindex", "0");
      node.setAttribute("role", "button");
      var cap = node.querySelector("p");
      if (cap) {
        node.setAttribute("aria-label", "View larger: " + cap.textContent.trim());
      }
      node.addEventListener("keydown", function (ev) {
        if (ev.key !== "Enter" && ev.key !== " ") return;
        ev.preventDefault();
        var img = node.querySelector("img");
        if (img) open(img);
      });
    });

    function open(img) {
      var src = img.getAttribute("src");
      if (!src) return;
      lastFocus = document.activeElement;
      lightboxImg.setAttribute("src", src);
      lightboxImg.setAttribute("alt", img.getAttribute("alt") || "");
      var cap = img.closest(".customer-node");
      cap = cap && cap.querySelector("p");
      modal.setAttribute("aria-label", cap ? cap.textContent.trim() + " — customer photo" : "Customer photo");
      modal.classList.add("is-open");
      document.body.classList.add("gc-photo-lightbox-open");
      closeBtn.focus();
    }

    function close() {
      modal.classList.remove("is-open");
      document.body.classList.remove("gc-photo-lightbox-open");
      lightboxImg.removeAttribute("src");
      lightboxImg.removeAttribute("alt");
      if (lastFocus && typeof lastFocus.focus === "function") {
        lastFocus.focus();
      }
    }

    section.addEventListener("click", function (ev) {
      var node = ev.target.closest(".customer-node");
      if (!node || !section.contains(node)) return;
      var img = node.querySelector("img");
      if (!img) return;
      ev.preventDefault();
      open(img);
    });

    modal.addEventListener("click", function (ev) {
      if (ev.target === modal) {
        close();
      }
    });

    closeBtn.addEventListener("click", function (ev) {
      ev.stopPropagation();
      close();
    });

    document.addEventListener("keydown", function (ev) {
      if (ev.key === "Escape" && modal.classList.contains("is-open")) {
        close();
      }
    });
  }

  function boot() {
    initGlobalCustomer();
    initCustomerPhotoLightbox();
  }

  var shell = window.siteShellReady;
  if (shell && typeof shell.then === "function") {
    shell.then(boot);
  } else {
    boot();
  }
})();
