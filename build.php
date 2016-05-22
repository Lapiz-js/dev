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

    $test_src_html = file_get_contents('tools/unitTestHeader.html');
    $test_build_html = $test_src_html;
    $test_min_html = $test_src_html;

    foreach($lapiz->projects as $projectName => $project){
      $test_build_html .= "    <script type='text/javascript' src='build/$projectName.js'></script>\n";
      $test_min_html .= "    <script type='text/javascript' src='build/min/$projectName.min.js'></script>\n";
      foreach ($project['inits'] as $script) {
        $test_src_html .= "    <script type='text/javascript' src='$script'></script>\n";
      }
    }
    foreach($lapiz->projects as $projectName => $project){
      foreach ($project['src'] as $script) {
        $test_src_html .= "    <script type='text/javascript' src='$script'></script>\n";
      }
    }
    foreach(['testing/test.js', 'testing/ui.js'] as $script){
      $test_src_html .= "    <script type='text/javascript' src='$script'></script>\n";
      $test_build_html .= "    <script type='text/javascript' src='$script'></script>\n";
      $test_min_html .= "    <script type='text/javascript' src='$script'></script>\n";
    }

    foreach($lapiz->projects as $projectName => $project){
      foreach ($project['tests'] as $script) {
        $test_src_html .= "    <script type='text/javascript' src='$script'></script>\n";
        $test_build_html .= "    <script type='text/javascript' src='$script'></script>\n";
        $test_min_html .= "    <script type='text/javascript' src='$script'></script>\n";
      }
    }
    $footer = "  </body>\n</html>";
    $test_src_html .= $footer;
    $test_build_html .= $footer;
    $test_min_html .= $footer;

    file_put_contents('test.src.html', $test_src_html);
    file_put_contents('test.build.html', $test_build_html);
    file_put_contents('test.min.html', $test_min_html);
    ?>
    </div>
  </body>
</html>
