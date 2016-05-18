<?php
include 'tools/dirParser.php'
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Unit Tests</title>
    <link rel="stylesheet" href="testing/testing.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
    <script type='text/javascript' src='testing/test.js'></script>
    <script type='text/javascript' src='testing/ui.js'></script>
    <?php
      include 'tools/testLinks.php';
      $lapiz = new DirParser();

      function includeScripts(&$scripts){
        foreach ($scripts as $script) {
          print("<script type='text/javascript' src='$script'></script>\n");
        }
      }

      function includeCoverageScripts(&$scripts){
        foreach ($scripts as $script) {
          print("<script type='text/javascript' src='tools/addCoverageMarkers.php?file=$script'></script>\n");
        }
      }

      foreach($lapiz->projects as $project) {
        includeCoverageScripts($project['inits']);
      }

      foreach($lapiz->projects as $project) {
        includeCoverageScripts($project['src']);
      }

      foreach($lapiz->projects as $project) {
        includeScripts($project['tests']);
      }
    ?>
  </body>
</html>
