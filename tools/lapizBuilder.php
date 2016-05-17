<?php
class LapizBuild{
  public $command, $commandOutput;
  public function __construct($project){
    $allNonTest = array_merge($project['inits'], $project['nonTestJS']);
    $all = implode(' ', $allNonTest);

    $name = $project['name'];
    exec("cat $all > build/$name.js");

    $this->command = "java -jar tools/yuicompressor-2.4.8.jar --type js -o build/min/$name.min.js build/$name.js 2>&1";
    exec($this->command, $commandOutput);
    $this->commandOutput = implode("\n",$commandOutput);

    $index = ['## Index of '.$project['dir']];
    $dirLen = strlen($project['dir']);
    @mkdir('docs/'.$project['dir'], 0775, true);
    foreach($allNonTest as $file){
      $autoDoc = new AutoDoc();
      $autoDoc->read($file);
      $autoDoc->out($file, "docs/$file.md", "index.md");
      $relFile =  substr($file, $dirLen);
      $index[] = "* [$file]($relFile.md)"; // a hack, but it will work for now
    }
    $file = fopen('docs/'.$project['dir'].'index.md','w');
    fwrite($file,implode("\n", $index));
    fclose($file);
  }
}

?>
