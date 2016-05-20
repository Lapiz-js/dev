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
      'tests' => [],
      'src' => [],
      'inits' => [],
    ];
    $oldDir = getcwd();
    chdir($dir);
    $this->recursiveDirScan($proj['tests'], $proj['src'], $proj['inits'], false, $dir);
    chdir($oldDir);
    $this->projects[$projectName] = $proj;
  }

  private function recursiveDirScan(&$tests, &$src, &$inits, $inTestsFolder, $path){
    $js = glob('*.js');

    foreach($js as $file){
      $full = $path.$file;
      if ($inTestsFolder){
        $tests[] = $full;
      } else if ($file == 'init.js'){
        $inits[] = $full;
      } else {
        $src[] = $full;
      }
    }

    $dirs = glob('*', GLOB_ONLYDIR | GLOB_MARK);
    foreach($dirs as $dir){
      $isTestsDir = ($dir == 'tests/') || $inTestsFolder;
      chdir($dir);
      $this->recursiveDirScan($tests, $src, $inits, $isTestsDir, $path.$dir);
      chdir("..");
    }
  }
}

?>
