<!DOCTYPE html>
<html>
  <head>
    <title>Unit Tests</title>
    <link rel="stylesheet" href="testing/testing.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
    <?php
      function recursiveDirScan(&$testFiles, &$nonTestJS, &$inits, $inTestsFolder, $path){
        $js = glob('*.js');
        foreach($js as $file){
          $full = $path.$file;
          if (!in_array($full, $exclude)){
            if ($file == 'init.js'){
              $inits[] = $full;
            } else if ($inTestsFolder){
              $testFiles[] = $full;
            } else {
              $nonTestJS[] = $full;
            }
          }
        }
        $dirs = glob('*', GLOB_ONLYDIR);
        foreach($dirs as $dir){
          if ($dir != 'build'){
            if ($dir == "ui2"){
              continue;
            }
            $isTestsDir = ($dir == "tests") || $inTestsFolder;
            chdir($dir);
            recursiveDirScan($testFiles, $nonTestJS, $inits, $isTestsDir, $path.$dir."/", $exclude);
            chdir("..");
          }
        }
      }

      function includeScripts(&$scripts){
        foreach ($scripts as $script) {
          print("<script type='text/javascript' src='$script'></script>\n");
        }
      }

      $testFiles = [];
      $inits = [];
      $nonTestFiles = [];
      recursiveDirScan($testFiles, $nonTestFiles, $inits, false, "");
      includeScripts($inits);
      includeScripts($nonTestFiles);
      includeScripts($testFiles);
    ?>
  </body>
</html>