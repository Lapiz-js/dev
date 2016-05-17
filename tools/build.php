<?php
include 'tools/dirParser.php';
include 'tools/lapizBuilder.php';

$lapiz = new DirParser();
foreach($lapiz->projects as $project){
  $build = new LapizBuild($project);

  print('== ' . $project['name'] . " ==\n");
  print($project['dir']. "\n");
  $dirLen = strlen($project['dir']);
  foreach(array_merge($project['inits'], $project['nonTestJS']) as $file){
    print('* ' . substr($file, $dirLen) . "\n");
  }
  print($build->command . ">\n");
  print($build->commandOutput);
}
?>
