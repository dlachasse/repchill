<?php

include("../fileUtilities/fileSearchFuncs.inc");
include("../drawingLinks.php");

$pn = trim($_POST['pn']);
$fileroot = FindInParentDir($_SERVER['DOCUMENT_ROOT']."/fileStorage", 'fileStorage', 10,$pathType='server',$folder=True);
echo GenerateFileURLs($pn,$fileroot);

?>