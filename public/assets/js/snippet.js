(function() {
  $(function() {
    "use strict";
    var editor;
    if ($('.js-submit-snippet-form').length > 0) {
      editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        mode: "text/x-php",
        theme: "monokai",
        lineNumbers: true,
        matchBrackets: true,
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift"
      });
    }
    if ($('.js-prettyprint').length > 0) {
      $(window).load(function() {
        return prettyPrint();
      });
    }
    if ($('.js-submit-snippet-form').length > 0) {
      return $('select').chosen({
        no_results_text: "Oops, nothing found!"
      });
    }
  });

}).call(this);
