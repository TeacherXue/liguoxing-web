(function () {
  var form = document.querySelector("[data-message-form]");
  if (!form) return;

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    var data = new FormData(form);
    var lines = [
      "Name: " + (data.get("name") || ""),
      "Phone: " + (data.get("phone") || ""),
      "E-mail: " + (data.get("email") || ""),
      "WhatsApp: " + (data.get("whatsapp") || ""),
      "",
      "Message:",
      data.get("message") || ""
    ];
    var subject = "LIGUOXING business inquiry";
    var mailto = "mailto:leo@liguoxing.com?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(lines.join("\n"));

    window.location.href = mailto;
  });
})();
