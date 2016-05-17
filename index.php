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
    <?php
      $lapiz = new DirParser();

      function includeScripts(&$scripts){
        foreach ($scripts as $script) {
          print("<script type='text/javascript' src='$script'></script>\n");
        }
      }

      foreach($lapiz->projects as $project) {
        includeScripts($project['inits']);
      }

      foreach($lapiz->projects as $project) {
        includeScripts($project['src']);
      }

      $testingLib = ['testing/test.js', 'testing/ui.js'];
      includeScripts($testingLib);

      foreach($lapiz->projects as $project) {
        includeScripts($project['tests']);
      }
    ?>
  </body>
</html>
