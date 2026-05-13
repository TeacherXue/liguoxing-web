(function () {
  var triggers = document.querySelectorAll("[data-video-trigger]");
  if (!triggers.length) return;

  var lastTrigger = null;
  var modal = document.createElement("div");
  modal.className = "video-modal";
  modal.setAttribute("role", "dialog");
  modal.setAttribute("aria-modal", "true");
  modal.setAttribute("aria-label", "Video player");
  modal.innerHTML = [
    '<div class="video-modal-frame">',
    '<button class="video-modal-close" type="button" aria-label="Close video">&times;</button>',
    '<iframe title="Video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
    "</div>"
  ].join("");
  document.body.appendChild(modal);

  var iframe = modal.querySelector("iframe");
  var closeButton = modal.querySelector(".video-modal-close");

  function extractYouTubeId(src) {
    if (!src) return "";
    var value = String(src).trim();
    var patterns = [
      /youtu\.be\/([A-Za-z0-9_-]{11})/i,
      /youtube\.com\/watch\?[^#]*v=([A-Za-z0-9_-]{11})/i,
      /youtube\.com\/embed\/([A-Za-z0-9_-]{11})/i,
      /youtube\.com\/shorts\/([A-Za-z0-9_-]{11})/i,
    ];

    for (var i = 0; i < patterns.length; i += 1) {
      var match = value.match(patterns[i]);
      if (match && match[1]) return match[1];
    }

    return /^[A-Za-z0-9_-]{11}$/.test(value) ? value : "";
  }

  function toEmbedUrl(src) {
    var value = String(src || "").trim();
    if (!value) return "";

    if (/youtube\.com\/embed\//i.test(value)) {
      return value;
    }

    var videoId = extractYouTubeId(value);
    if (videoId) {
      return "https://www.youtube.com/embed/" + videoId;
    }

    return value;
  }

  function withAutoplay(src) {
    var embedSrc = toEmbedUrl(src);
    if (!embedSrc) return "";
    var separator = embedSrc.indexOf("?") === -1 ? "?" : "&";
    return embedSrc + separator + "autoplay=1&rel=0";
  }

  function openModal(trigger) {
    var src = trigger.getAttribute("data-video-src");
    if (!src) return;

    lastTrigger = trigger;
    iframe.setAttribute("title", trigger.getAttribute("data-video-title") || "Video player");
    iframe.setAttribute("src", withAutoplay(src));
    modal.classList.add("is-open");
    document.body.classList.add("video-modal-open");
    closeButton.focus();
  }

  function closeModal() {
    modal.classList.remove("is-open");
    document.body.classList.remove("video-modal-open");
    iframe.removeAttribute("src");

    if (lastTrigger) {
      lastTrigger.focus();
    }
  }

  triggers.forEach(function (trigger) {
    trigger.addEventListener("click", function () {
      openModal(trigger);
    });
  });

  closeButton.addEventListener("click", closeModal);

  modal.addEventListener("click", function (event) {
    if (event.target === modal) {
      closeModal();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && modal.classList.contains("is-open")) {
      closeModal();
    }
  });
})();
