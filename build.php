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
      $buildDirs = glob('components/*', GLOB_ONLYDIR);
      $buildDirs[] = 'core';

      foreach($buildDirs as $dir){
        $js = glob("$dir/*.js");
        $init = "$dir/init.js";
        $initIdx = array_search($init, $js);
        if ($initIdx !== false){
          unset($js[$initIdx]);
          array_unshift($js, $init);
        }
        $pos = strrpos($dir, '/');
        $name = $pos === false ? $dir : substr($dir, $pos + 1);
        $all = implode(" ",$js);
        print("<h2>$name</h2>");
        print("<ul>");
        foreach($js as $file){
          print('<li>' . substr($file, strrpos($file, '/') + 1) . '</li>');
        }
        print("</ul>");
        exec("cat $all > build/$name.js");
        $command = "java -jar /home/ubuntu/yuicompressor-2.4.8.jar --type js -o build/min/$name.min.js build/$name.js";
        print("$command >");
        exec($command, $out);
        $out = implode("\n",$out);
        print("<pre>$out</pre>");
      }
    ?>
    </div>
  </body>
</html>