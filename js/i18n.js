(function () {
  const STORAGE_KEY = "liguoxing_lang";
  const DEFAULT_LANG = "en";
  const SUPPORTED = ["en", "zh"];

  function getSavedLang() {
    const saved = window.localStorage.getItem(STORAGE_KEY);
    if (SUPPORTED.includes(saved)) return saved;
    return DEFAULT_LANG;
  }

  function setActiveButton(lang) {
    const buttons = document.querySelectorAll("[data-set-lang]");
    buttons.forEach((button) => {
      const active = button.getAttribute("data-set-lang") === lang;
      button.classList.toggle("active", active);
      button.setAttribute("aria-pressed", active ? "true" : "false");
    });
  }

  function applyTextByLang(lang) {
    const textNodes = document.querySelectorAll("[data-i18n-en][data-i18n-zh]");
    textNodes.forEach((node) => {
      const value = node.getAttribute(lang === "zh" ? "data-i18n-zh" : "data-i18n-en");
      if (value !== null) node.textContent = value;
    });

    const htmlNodes = document.querySelectorAll("[data-i18n-en-html][data-i18n-zh-html]");
    htmlNodes.forEach((node) => {
      const value = node.getAttribute(lang === "zh" ? "data-i18n-zh-html" : "data-i18n-en-html");
      if (value !== null) node.innerHTML = value;
    });
  }

  function applyMetaByLang(lang) {
    const titleNode = document.querySelector("title[data-i18n-en][data-i18n-zh]");
    if (titleNode) {
      const value = titleNode.getAttribute(lang === "zh" ? "data-i18n-zh" : "data-i18n-en");
      if (value) titleNode.textContent = value;
    }

    const descNode = document.querySelector('meta[name="description"][data-i18n-en][data-i18n-zh]');
    if (descNode) {
      const value = descNode.getAttribute(lang === "zh" ? "data-i18n-zh" : "data-i18n-en");
      if (value) descNode.setAttribute("content", value);
    }
  }

  function applyLang(lang) {
    applyTextByLang(lang);
    applyMetaByLang(lang);
    document.documentElement.setAttribute("lang", lang === "zh" ? "zh-CN" : "en");
    setActiveButton(lang);
    window.localStorage.setItem(STORAGE_KEY, lang);
  }

  function bindEvents() {
    const buttons = document.querySelectorAll("[data-set-lang]");
    buttons.forEach((button) => {
      button.addEventListener("click", function () {
        const lang = button.getAttribute("data-set-lang");
        if (!SUPPORTED.includes(lang)) return;
        applyLang(lang);
      });
    });
  }

  bindEvents();
  applyLang(getSavedLang());
})();
