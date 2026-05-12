(function () {
  var mapWrap = document.querySelector("[data-contact-map]");
  if (!mapWrap) return;

  var apiKey = window.LIGUOXING_GOOGLE_MAPS_API_KEY;
  if (!apiKey) return;

  var callbackName = "initLiguoxingContactMap";
  var position = { lat: 36.344391, lng: 120.503610 };
  var content =
    '<div class="contact-map-info">' +
    "<strong>Qingdao Liguoxing Precision Machinery Co., Ltd.</strong>" +
    '<span>WhatsApp: <a href="https://wa.me/8618561683175" target="_blank" rel="noopener">+86 185 6168 3175</a></span>' +
    '<span>E-mail: <a href="mailto:leo@liguoxing.com">leo@liguoxing.com</a></span>' +
    "</div>";

  window[callbackName] = function () {
    var canvas = mapWrap.querySelector("[data-contact-map-canvas]");
    if (!canvas || !window.google || !google.maps) return;

    mapWrap.classList.add("is-api-loaded");

    var map = new google.maps.Map(canvas, {
      center: position,
      zoom: 15,
      mapTypeControl: true,
      streetViewControl: true,
      fullscreenControl: true
    });

    var marker = new google.maps.Marker({
      position: position,
      map: map,
      title: "Qingdao Liguoxing Precision Machinery Co., Ltd."
    });

    var infoWindow = new google.maps.InfoWindow({
      content: content,
      maxWidth: 420
    });

    infoWindow.open({
      anchor: marker,
      map: map,
      shouldFocus: false
    });

    marker.addListener("click", function () {
      infoWindow.open({
        anchor: marker,
        map: map,
        shouldFocus: false
      });
    });
  };

  var script = document.createElement("script");
  script.src = "https://maps.googleapis.com/maps/api/js?key=" + encodeURIComponent(apiKey) + "&callback=" + callbackName;
  script.async = true;
  script.defer = true;
  document.head.appendChild(script);
})();
