<?php

class DirParser {
  public $projects;

  public function __construct(){
    $this->projects = [];
    $this->addProject('core/', 'lapiz');
    foreach(glob('components/*', GLOB_ONLYDIR | GLOB_MARK) as $dir){
      $this->addProject($dir);
    }
  }

  private function addProject($dir, $projectName = Null){
    $projectName = is_null($projectName) ? basename($dir) : $projectName;
    $proj = [
      'name' => $projectName,
      'dir' => $dir,
      'testFiles' => [],
      'nonTestJS' => [],
      'inits' => [],
    ];
    $oldDir = getcwd();
    chdir($dir);
    $this->recursiveDirScan($proj['testFiles'], $proj['nonTestJS'], $proj['inits'], false, $dir);
    chdir($oldDir);
    $this->projects[$projectName] = $proj;
  }

  private function recursiveDirScan(&$testFiles, &$nonTestJS, &$inits, $inTestsFolder, $path){
    $js = glob('*.js');

    foreach($js as $file){
      $full = $path.$file;
      if ($file == 'init.js'){
        $inits[] = $full;
      } else if ($inTestsFolder){
        $testFiles[] = $full;
      } else {
        $nonTestJS[] = $full;
      }
    }

    $dirs = glob('*', GLOB_ONLYDIR | GLOB_MARK);
    foreach($dirs as $dir){
      if ($dir != 'build'){
        $isTestsDir = ($dir == 'tests/') || $inTestsFolder;
        chdir($dir);
        $this->recursiveDirScan($testFiles, $nonTestJS, $inits, $isTestsDir, $path.$dir);
        chdir("..");
      }
    }
  }
}

?>
