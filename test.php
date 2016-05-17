<?php
include 'autodoc/autodoc.php';
$doc = new AutoDoc();
$doc->read('core/collectionsHelper.js');
$doc->out('Collections Helper', 'test.md');
?>
<a href='test.md'>Test</a>
