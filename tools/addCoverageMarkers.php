<?php
include '../testing/addCoverageCounters.php';

$x =new AddCoverageCounters(file_get_contents('../'.$_GET['file']), $_GET['file']);
print($x->out);

?>