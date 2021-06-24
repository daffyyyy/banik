$(document).ready(function () {
  $(document).on("click", ".close", function () {
    localStorage.setItem("hideAlert", "true");
  });
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
  let hide = localStorage.getItem("hideAlert");
  if (hide === "true") {
    $(".hide_alert").remove();
  }
});
