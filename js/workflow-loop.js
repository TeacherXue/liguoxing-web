(function () {
  function initWorkflowLoop() {
    var workflow = document.querySelector("[data-workflow-loop]");
    if (!workflow) return;

    var steps = Array.from(workflow.querySelectorAll(".workflow-step"));
    var stations = Array.from(workflow.querySelectorAll(".workflow-station"));
    var belt = workflow.querySelector(".workflow-belt");
    var product = workflow.querySelector(".workflow-product");
    if (steps.length === 0) return;

    var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (prefersReducedMotion) {
      steps[0].classList.add("is-active");
      if (stations[0]) stations[0].classList.add("is-active");
      return;
    }

    var index = 0;
    var timer = null;
    var isRunning = false;

    function getOffset(i, active, total) {
      var delta = i - active;
      if (delta > total / 2) delta -= total;
      if (delta < -total / 2) delta += total;
      return delta;
    }

    function setCoverflowState(next) {
      var total = steps.length;
      steps.forEach(function (step, i) {
        var offset = getOffset(i, next, total);
        step.classList.remove("is-active", "is-left-1", "is-left-2", "is-right-1", "is-right-2");
        if (offset === 0) step.classList.add("is-active");
        if (offset === -1) step.classList.add("is-left-1");
        if (offset === -2) step.classList.add("is-left-2");
        if (offset === 1) step.classList.add("is-right-1");
        if (offset === 2) step.classList.add("is-right-2");
      });
    }

    function setStationState(next) {
      stations.forEach(function (station, i) {
        station.classList.toggle("is-active", i === next);
      });
    }

    function setProductPosition(next) {
      if (!belt || !product || !stations[next]) return;
      var beltRect = belt.getBoundingClientRect();
      var stationRect = stations[next].getBoundingClientRect();
      var x = stationRect.left + stationRect.width / 2 - beltRect.left - product.offsetWidth / 2;
      var min = 8;
      var max = beltRect.width - product.offsetWidth - 8;
      x = Math.max(min, Math.min(x, max));
      product.style.transform = "translate(" + x.toFixed(1) + "px, -50%)";
    }

    function activateStep(next) {
      setCoverflowState(next);
      setStationState(next);
      setProductPosition(next);
    }

    function tick() {
      index = (index + 1) % steps.length;
      activateStep(index);
    }

    function start() {
      if (isRunning) return;
      isRunning = true;
      workflow.classList.add("is-looping");
      activateStep(index);
      timer = window.setInterval(tick, 2200);
    }

    function stop() {
      if (!isRunning) return;
      isRunning = false;
      if (timer) {
        window.clearInterval(timer);
        timer = null;
      }
    }

    if (!("IntersectionObserver" in window)) {
      start();
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            start();
          } else {
            stop();
          }
        });
      },
      {
        threshold: 0.25,
        rootMargin: "0px 0px -12% 0px",
      }
    );

    observer.observe(workflow);

    window.addEventListener("resize", function () {
      activateStep(index);
    });
  }

  var shell = window.siteShellReady;
  if (shell && typeof shell.then === "function") {
    shell.then(initWorkflowLoop);
  } else {
    initWorkflowLoop();
  }
})();
