<?php
include 'tools/dirParser.php';
include 'tools/lapizBuilder.php';
include 'autodoc/autodoc.php';
include 'tools/JShrink/src/JShrink/Minifier.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Lapiz Build</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
    html, body{
      width: 100%;
      margin: 0;
      padding: 0;
      text-align: center;
      background: #ddd;
    }
    #wrapper, .group {
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
    <?php include 'tools/testLinks.php'; ?>
    <div id="wrapper">
    <?php

    $lapiz = new DirParser();
    foreach($lapiz->projects as $project){
      $build = new LapizBuilder($project);

      print('<h2>' . $project['name'] . '</h2>');
      print($project['dir']);
      $dirLen = strlen($project['dir']);
      print('<ul>');
      foreach(array_merge($project['inits'], $project['src']) as $file){
        print('<li>' . substr($file, $dirLen) . '</li>');
      }
      print('</ul>');
      print('<pre>'.$build->minOutput.'</pre>');
    }

    new IndexDocs();
    ?>
    </div>
  </body>
</html>
