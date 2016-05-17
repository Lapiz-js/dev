<?php
include 'autodoc/autodoc.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Lapiz Auto Docs</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
    html, body{
      width: 100%;
      margin: 0;
      padding: 0;
      text-align: center;
      background: #ddd;
    }
    #wrapper {
      background: #fff;
      max-width: 1100px;
      display: block;
      margin: auto;
      padding: 10px;
      text-align: left;
      border: 2px solid black;
      border-radius: 4px;
      min-height: 100%;
    }
    pre {
      font-family: monospace;
    }
    </style>
  </head>
  <body>
    <div id="wrapper">
    <?php
      #$buildDirs = glob('components/*', GLOB_ONLYDIR);
      $buildDirs[] = 'core';

      $index = ['## Index'];

      foreach($buildDirs as $dir){
        $js = glob("$dir/*.js");
        foreach($js as $file){
          $autoDoc = new AutoDoc();
          $autoDoc->read($file);
          $autoDoc->out($file, "docs/$file.md", "index.md");
          print("<h2>$file</h2>");
          $index[] = "* [$file.md](../$file.md)"; // a hack, but it will work for now
        }
      }
      $file = fopen('docs/core/index.md','w');
      fwrite($file,implode("\n", $index));
    ?>
    </div>
  </body>
</html>
