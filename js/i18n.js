(function () {
  const STORAGE_KEY = "liguoxing_lang";
  const COOKIE_KEY = "liguoxing_lang";
  const DEFAULT_LANG = "en";
  const SUPPORTED = ["en", "ru", "es"];
  const LANG_META = {
    en: { html: "en", short: "EN" },
    ru: { html: "ru", short: "RU" },
    es: { html: "es", short: "ES" },
  };
  const TRANSLATIONS = {
    en: {
      "nav.home": "Home",
      "nav.about": "About Us",
      "nav.equipment": "Equipment",
      "nav.applications": "Applications",
      "nav.cases": "Cases",
      "nav.news": "News",
      "nav.contact": "Contact",
      "nav.download": "Download",
      "header.quote": "Get a Quote",
      "footer.brand.tagline": "Your trusted partner for block bottom valve bag making equipment. High performance. Global service.",
      "footer.quickLinks": "Quick Links",
      "footer.equipment": "Equipment",
      "footer.equip.bvm120": "BVM-120 Block Bottom",
      "footer.equip.cement": "Cement Valve Bag",
      "footer.equip.line": "Making Line",
      "footer.equip.parts": "Spare Parts",
      "footer.equip.upgrade": "Upgrade Solutions",
      "footer.equip.service": "Service & Support",
      "footer.apps.cement": "Cement Valve Bags",
      "footer.apps.open": "Open-Mouth Bags",
      "footer.apps.powder": "Powder & Mineral Bagging",
      "footer.apps.automation": "Downstream Automation",
      "footer.apps.all": "All Applications",
      "footer.contact": "Contact Us",
      "footer.address": "Address: Qingdao, China",
      "footer.qr": "Scan to contact us<br>on WhatsApp",
      "footer.copyright": "© 2026 LIGUOXING Machinery Co., Ltd. All rights reserved.",
      "footer.privacy": "Privacy Policy",
      "footer.terms": "Terms of Use",
      "footer.sitemap": "Sitemap",
    },
    ru: {
      "nav.home": "Главная",
      "nav.about": "О нас",
      "nav.equipment": "Оборудование",
      "nav.applications": "Применение",
      "nav.cases": "Кейсы",
      "nav.news": "Новости",
      "nav.contact": "Контакты",
      "nav.download": "Скачать",
      "header.quote": "Запросить цену",
      "footer.brand.tagline": "Надежный партнер по оборудованию для производства клапанных мешков с блочным дном. Высокая производительность. Глобальный сервис.",
      "footer.quickLinks": "Быстрые ссылки",
      "footer.equipment": "Оборудование",
      "footer.equip.bvm120": "BVM-120 Блочное дно",
      "footer.equip.cement": "Клапанные мешки для цемента",
      "footer.equip.line": "Производственная линия",
      "footer.equip.parts": "Запчасти",
      "footer.equip.upgrade": "Решения для модернизации",
      "footer.equip.service": "Сервис и поддержка",
      "footer.apps.cement": "Клапанные мешки для цемента",
      "footer.apps.open": "Открытые мешки",
      "footer.apps.powder": "Упаковка порошков и минералов",
      "footer.apps.automation": "Автоматизация downstream",
      "footer.apps.all": "Все применения",
      "footer.contact": "Связаться с нами",
      "footer.address": "Адрес: Циндао, Китай",
      "footer.qr": "Сканируйте, чтобы связаться с нами<br>в WhatsApp",
      "footer.copyright": "© 2026 LIGUOXING Machinery Co., Ltd. Все права защищены.",
      "footer.privacy": "Политика конфиденциальности",
      "footer.terms": "Условия использования",
      "footer.sitemap": "Карта сайта",
    },
    es: {
      "nav.home": "Inicio",
      "nav.about": "Sobre Nosotros",
      "nav.equipment": "Equipos",
      "nav.applications": "Aplicaciones",
      "nav.cases": "Casos",
      "nav.news": "Noticias",
      "nav.contact": "Contacto",
      "nav.download": "Descargas",
      "header.quote": "Solicitar Cotizacion",
      "footer.brand.tagline": "Su socio de confianza en equipos para fabricar sacos valvulados de fondo cuadrado. Alto rendimiento. Servicio global.",
      "footer.quickLinks": "Enlaces Rapidos",
      "footer.equipment": "Equipos",
      "footer.equip.bvm120": "BVM-120 Fondo cuadrado",
      "footer.equip.cement": "Sacos valvulados para cemento",
      "footer.equip.line": "Linea de produccion",
      "footer.equip.parts": "Repuestos",
      "footer.equip.upgrade": "Soluciones de actualizacion",
      "footer.equip.service": "Servicio y soporte",
      "footer.apps.cement": "Sacos valvulados para cemento",
      "footer.apps.open": "Sacos de boca abierta",
      "footer.apps.powder": "Envasado de polvo y minerales",
      "footer.apps.automation": "Automatizacion downstream",
      "footer.apps.all": "Todas las aplicaciones",
      "footer.contact": "Contactenos",
      "footer.address": "Direccion: Qingdao, China",
      "footer.qr": "Escanee para contactarnos<br>por WhatsApp",
      "footer.copyright": "© 2026 LIGUOXING Machinery Co., Ltd. Todos los derechos reservados.",
      "footer.privacy": "Politica de privacidad",
      "footer.terms": "Terminos de uso",
      "footer.sitemap": "Mapa del sitio",
    },
  };
  const AUTO_DICT = window.I18N_AUTO_DICT || {};
  const TRACKED_ATTRS = ["alt", "title", "aria-label", "placeholder"];
  const LITERAL_TOKENS = new Set([
    "mm",
    "kW",
    "bags/min",
    "pcs/min",
    "m3/h",
    "MPa",
    "°C",
    "cm²",
    "UTC+8",
    "PDF",
    "DOCX",
    "PPTX",
    "BVM-120",
    "LIGUOXING",
    "PLC",
    "HMI",
    "PLC/HMI",
    "WhatsApp",
  ]);
  const ORIGINAL_TEXT_MAP = new WeakMap();
  const ORIGINAL_ATTR_MAP = new WeakMap();
  const ORIGINAL_DOC = { title: null, metaDesc: null };
  let eventsBound = false;

  function getLangFromQuery() {
    const params = new URLSearchParams(window.location.search);
    const q = params.get("lang");
    if (SUPPORTED.includes(q)) return q;
    return null;
  }

  function getCookie(name) {
    const parts = document.cookie ? document.cookie.split("; ") : [];
    for (let i = 0; i < parts.length; i += 1) {
      const eqIndex = parts[i].indexOf("=");
      if (eqIndex < 0) continue;
      const key = decodeURIComponent(parts[i].slice(0, eqIndex));
      if (key !== name) continue;
      return decodeURIComponent(parts[i].slice(eqIndex + 1));
    }
    return null;
  }

  function saveLang(lang) {
    try {
      window.localStorage.setItem(STORAGE_KEY, lang);
    } catch (error) {
      // localStorage might be blocked in privacy mode; cookie/query fallback still works.
    }
    document.cookie =
      encodeURIComponent(COOKIE_KEY) +
      "=" +
      encodeURIComponent(lang) +
      "; path=/; max-age=31536000; samesite=lax";
  }

  function getSavedLang() {
    const fromQuery = getLangFromQuery();
    if (fromQuery) return fromQuery;
    try {
      const saved = window.localStorage.getItem(STORAGE_KEY);
      if (SUPPORTED.includes(saved)) return saved;
    } catch (error) {
      // Ignore and continue to cookie fallback.
    }
    const fromCookie = getCookie(COOKIE_KEY);
    if (SUPPORTED.includes(fromCookie)) return fromCookie;
    return DEFAULT_LANG;
  }

  function decorateInternalLinks(lang) {
    document.querySelectorAll("a[href]").forEach((link) => {
      const raw = link.getAttribute("href");
      if (!raw || raw.startsWith("#")) return;
      if (
        raw.startsWith("mailto:") ||
        raw.startsWith("tel:") ||
        raw.startsWith("javascript:")
      ) {
        return;
      }
      let url;
      try {
        url = new URL(raw, window.location.origin);
      } catch (error) {
        return;
      }
      if (url.origin !== window.location.origin) return;
      const pathname = url.pathname || "/";
      const dot = pathname.lastIndexOf(".");
      if (dot > pathname.lastIndexOf("/")) {
        const ext = pathname.slice(dot).toLowerCase();
        if (ext !== ".html") return;
      }
      if (lang === DEFAULT_LANG) {
        url.searchParams.delete("lang");
      } else {
        url.searchParams.set("lang", lang);
      }
      link.setAttribute("href", url.pathname + url.search + url.hash);
    });
  }

  function isProtectedNode(node) {
    const parent = node && node.parentElement;
    if (!parent) return false;
    return !!parent.closest("[data-i18n-key], [data-i18n-key-html], [data-i18n-en], [data-i18n-en-html]");
  }

  function shouldPreserveLiteral(text) {
    const t = (text || "").trim();
    if (!t) return true;
    if (LITERAL_TOKENS.has(t)) return true;
    if (/^[0-9][0-9.,+\-/%\s:]*$/.test(t)) return true;
    return false;
  }

  function translateByKey(lang) {
    const dict = TRANSLATIONS[lang] || TRANSLATIONS.en;
    const fallback = TRANSLATIONS.en;
    document.querySelectorAll("[data-i18n-key]").forEach((node) => {
      const key = node.getAttribute("data-i18n-key");
      if (!key) return;
      const value = dict[key] || fallback[key];
      if (value !== undefined) node.textContent = value;
    });
    document.querySelectorAll("[data-i18n-key-html]").forEach((node) => {
      const key = node.getAttribute("data-i18n-key-html");
      if (!key) return;
      const value = dict[key] || fallback[key];
      if (value !== undefined) node.innerHTML = value;
    });
  }

  function resolveAttr(node, lang, fallbackLang, prefix) {
    const value = node.getAttribute(prefix + "-" + lang);
    if (value !== null) return value;
    return node.getAttribute(prefix + "-" + fallbackLang);
  }

  function applyTextByLang(lang) {
    document.querySelectorAll("[data-i18n-en]").forEach((node) => {
      const value = resolveAttr(node, lang, "en", "data-i18n");
      if (value !== null) node.textContent = value;
    });

    document.querySelectorAll("[data-i18n-en-html]").forEach((node) => {
      const value = resolveAttr(node, lang + "-html", "en-html", "data-i18n");
      if (value !== null) node.innerHTML = value;
    });

    translateByKey(lang);
  }

  function applyMetaByLang(lang) {
    const titleNode = document.querySelector("title[data-i18n-en]");
    if (titleNode) {
      const value = resolveAttr(titleNode, lang, "en", "data-i18n");
      if (value) titleNode.textContent = value;
    }

    const descNode = document.querySelector('meta[name="description"][data-i18n-en]');
    if (descNode) {
      const value = resolveAttr(descNode, lang, "en", "data-i18n");
      if (value) descNode.setAttribute("content", value);
    }
  }

  function applyAutoDictText(lang) {
    const dict = AUTO_DICT[lang] || null;
    const body = document.body;
    if (!body) return;

    const walker = document.createTreeWalker(body, NodeFilter.SHOW_TEXT);
    let node;
    while ((node = walker.nextNode())) {
      if (isProtectedNode(node)) continue;

      if (!ORIGINAL_TEXT_MAP.has(node)) {
        ORIGINAL_TEXT_MAP.set(node, node.nodeValue || "");
      }
      const original = ORIGINAL_TEXT_MAP.get(node) || "";
      const trimmed = original.trim();
      if (!trimmed) continue;
      if (shouldPreserveLiteral(trimmed)) {
        node.nodeValue = original;
        continue;
      }

      const leading = original.match(/^\s*/)[0];
      const trailing = original.match(/\s*$/)[0];
      if (lang === "en" || !dict || !dict[trimmed]) {
        node.nodeValue = original;
      } else {
        node.nodeValue = leading + dict[trimmed] + trailing;
      }
    }
  }

  function rememberAttr(el, attr) {
    let cache = ORIGINAL_ATTR_MAP.get(el);
    if (!cache) {
      cache = {};
      ORIGINAL_ATTR_MAP.set(el, cache);
    }
    if (!(attr in cache)) {
      cache[attr] = el.getAttribute(attr) || "";
    }
    return cache[attr];
  }

  function applyAutoDictAttrs(lang) {
    const dict = AUTO_DICT[lang] || null;
    document.querySelectorAll("*").forEach((el) => {
      TRACKED_ATTRS.forEach((attr) => {
        if (!el.hasAttribute(attr)) return;
        const original = rememberAttr(el, attr);
        const trimmed = original.trim();
        if (!trimmed) return;
        if (shouldPreserveLiteral(trimmed)) {
          el.setAttribute(attr, original);
          return;
        }

        if (lang === "en" || !dict || !dict[trimmed]) {
          el.setAttribute(attr, original);
        } else {
          el.setAttribute(attr, dict[trimmed]);
        }
      });
    });

    if (ORIGINAL_DOC.title === null) {
      ORIGINAL_DOC.title = document.title;
    }
    if (lang === "en" || !dict || !dict[ORIGINAL_DOC.title]) {
      document.title = ORIGINAL_DOC.title;
    } else {
      document.title = dict[ORIGINAL_DOC.title];
    }

    const metaDesc = document.querySelector('meta[name="description"]');
    if (metaDesc) {
      if (ORIGINAL_DOC.metaDesc === null) {
        ORIGINAL_DOC.metaDesc = metaDesc.getAttribute("content") || "";
      }
      const src = ORIGINAL_DOC.metaDesc;
      if (lang === "en" || !dict || !dict[src]) {
        metaDesc.setAttribute("content", src);
      } else {
        metaDesc.setAttribute("content", dict[src]);
      }
    }
  }

  function applyAutoTranslations(lang) {
    applyAutoDictText(lang);
    applyAutoDictAttrs(lang);
  }

  function closeDropdowns() {
    document.querySelectorAll("[data-lang-dropdown]").forEach((dropdown) => {
      dropdown.classList.remove("is-open");
      const toggle = dropdown.querySelector("[data-lang-toggle]");
      if (toggle) toggle.setAttribute("aria-expanded", "false");
    });
  }

  function setActiveButton(lang) {
    document.querySelectorAll("[data-set-lang]").forEach((button) => {
      const active = button.getAttribute("data-set-lang") === lang;
      button.classList.toggle("active", active);
      button.setAttribute("aria-pressed", active ? "true" : "false");
    });
    document.querySelectorAll("[data-lang-current]").forEach((node) => {
      node.textContent = (LANG_META[lang] || LANG_META.en).short;
    });
  }

  function applyLang(lang) {
    const target = SUPPORTED.includes(lang) ? lang : DEFAULT_LANG;
    applyTextByLang(target);
    applyMetaByLang(target);
    applyAutoTranslations(target);
    decorateInternalLinks(target);
    document.documentElement.setAttribute("lang", (LANG_META[target] || LANG_META.en).html);
    setActiveButton(target);
    closeDropdowns();
    saveLang(target);
  }

  function bindEvents() {
    if (eventsBound) return;
    eventsBound = true;

    document.addEventListener("click", function (event) {
      const button = event.target.closest("[data-set-lang]");
      if (button) {
        const lang = button.getAttribute("data-set-lang");
        if (SUPPORTED.includes(lang)) applyLang(lang);
        return;
      }

      const toggle = event.target.closest("[data-lang-toggle]");
      if (toggle) {
        const dropdown = toggle.closest("[data-lang-dropdown]");
        const opening = dropdown && !dropdown.classList.contains("is-open");
        closeDropdowns();
        if (dropdown && opening) {
          dropdown.classList.add("is-open");
          toggle.setAttribute("aria-expanded", "true");
        }
        return;
      }

      if (!event.target.closest("[data-lang-dropdown]")) {
        closeDropdowns();
      }
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") closeDropdowns();
    });
  }

  function init() {
    bindEvents();
    applyLang(getSavedLang());
  }

  if (window.siteShellReady && typeof window.siteShellReady.then === "function") {
    window.siteShellReady.finally(init);
  } else if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init, { once: true });
  } else {
    init();
  }
})();
