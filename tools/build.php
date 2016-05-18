<?php
include 'tools/dirParser.php';
include 'tools/lapizBuilder.php';
include 'autodoc/autodoc.php';
include 'tools/JShrink/src/JShrink/Minifier.php';

$lapiz = new DirParser();
foreach($lapiz->projects as $project){
  $build = new LapizBuilder($project);

  print('== ' . $project['name'] . " ==\n");
  print($project['dir']. "\n");
  $dirLen = strlen($project['dir']);
  foreach(array_merge($project['inits'], $project['src']) as $file){
    print('* ' . substr($file, $dirLen) . "\n");
  }
  print($build->minOutput);
}
?>
