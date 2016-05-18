<?php
class LapizBuilder{
  public $minOutput;
  public function __construct($project){
    $allNonTest = array_merge($project['inits'], $project['src']);
    $all = implode(' ', $allNonTest);

    $dir = $project['dir'];
    $name = $project['name'];

    exec("cat $all > build/$name.js");

    //$this->command = "java -jar tools/yuicompressor-2.4.8.jar --type js --nomunge -o build/min/$name.min.js build/$name.js 2>&1";
    try{
      file_put_contents("build/min/$name.min.js" , \JShrink\Minifier::minify(file_get_contents("build/$name.js")));
      $this->minOutput = "";
    } catch (Exception $e){
      $this->minOutput = $e->getMessage();
    }
    //exec($this->command, $commandOutput);
    //$this->commandOutput = implode("\n",$commandOutput);

    $index = ["## Index of $dir"];
    $dirLen = strlen($dir);
    @mkdir("docs/$dir", 0775, true);
    foreach($allNonTest as $file){
      $autoDoc = new AutoDoc();
      $autoDoc->read($file);
      $autoDoc->out($file, "docs/$file.md", "index.md");
      $relFile =  substr($file, $dirLen);
      $index[] = "* [$file]($relFile.md)"; // a hack, but it will work for now
    }
    $file = fopen("docs/$dir".'index.md','w');
    fwrite($file,implode("\n", $index));
    fclose($file);
  }
}

class IndexDocs{
  public function __construct(){
    chdir('docs/');
    $this->recursiveIndex('lapiz/', false);
    chdir('..');
  }

  private function recursiveIndex($dir, $hasParent){
    $docs = glob('*.js.md');

    $index = ["## Index of $dir\n"];
    if ($hasParent){
      $index[] = "<sub><sup>[Back](../index.md)</sup></sub>\n";
    }
    foreach($docs as $doc){
      $filename = basename($doc, ".md");
      $index[] = "* [$filename]($doc)";
    }

    $dirs = glob('*', GLOB_ONLYDIR | GLOB_MARK);
    foreach($dirs as $child){
      $index[] = "* [$child](".$child.'index.md)';
      chdir($child);
      $this->recursiveIndex($dir . $child, true);
      chdir('..');
    }

    $file = fopen('index.md','w');
    fwrite($file,implode("\n", $index));
    fclose($file);
  }
}

?>
