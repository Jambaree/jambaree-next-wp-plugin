jQuery(document).ready(function ($) {
  console.log("customizer-iframe.js loaded");
  var newIframeSrc = "https://your-headless-site-url.com"; // Replace this with your headless site URL

  // Function to change the iframe URL
  function changeIframeURL() {
    var iframe = $("#customize-preview iframe"); // Selector for the iframe in the customizer
    if (iframe.length) {
      iframe.attr("src", newIframeSrc);
    }
  }

  // Listen for changes in the customizer and apply the function
  $(window).on("load", function () {
    console.log("customizer-iframe.js loaded");

    setTimeout(changeIframeURL, 3000); // Adjust timeout as needed
  });
});
