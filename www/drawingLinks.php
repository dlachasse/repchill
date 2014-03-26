<?php

//If script is run client side, grab the vars JS posted back to the server
if (isset($_POST['fileroot'])){
	$pn = trim($_POST['pn']);
	$fileroot = $_POST['fileroot'];
	$partFolder= $fileroot.$pn."/";	
}

//CreateLink - returns an html hyperlink to a file, given the folder location and file name
function CreateLink($folder,$file,$linkTitle){
	return "<a href=\"".$folder.$file."\">".$linkTitle."</a>";
}

//GetLatestRev takes a slew of revisions, and returns the most recent
function GetLatestRev($revs){
	arsort($revs);
	$latestRev=$revs[0];
	foreach ($revs as $rev) {
		if (!is_numeric($rev)){
			$latestRev = $rev;
			exit;
		}
	}
	return $latestRev;
}

//GenerateFileqTip -- creates all of the text for the tool tip
function GenerateFileURLs($pn,$fileroot,$partFolder){
	$errorMsg='';
	$linksToFiles='';

	if(!is_dir($partFolder)){
		$errorMsg.='No files exist!  Check your part number. :( </br>';
	}
	else{
		//get all revs
		if (($handle = opendir($partFolder)) && !$errorMsg) {  //open the part folder
			if (strlen($pn)>1){  //exit if part is not specified
			    while (false !== ($file = readdir($handle))) {  //only pay attention to real folders/files
			        if ($file != "." && $file != "..") {  //ignore system files
			        	if (is_dir($partFolder.$file)){
			        		$partRevs[]=$file;
			        	}
			        }
			    }
			    closedir($handle);

				//find the latest rev
				if(is_array($partRevs)){
					$latestRev = GetLatestRev($partRevs);
					$partFolderLastestRev=$partFolder.$latestRev."/";	
				}
				else{
					$errorMsg.='No files! </br>';
				}
			
			//setup links to files for latest revs
			if (($handle = opendir($partFolderLastestRev)) && !$errorMsg) {  //open the part folder
			    while (false !== ($file = readdir($handle))) {  //only pay attention to real folders/files
			        if ($file != "." && $file != "..") {  //ignore system files
			            $linksToFiles.=CreateLink($partFolderLastestRev,$file,$file)."</br>";
			        }
			    }
			    closedir($handle);
				//add link to folder root
				$linksToFiles.="---</br>";
				$linksToFiles.=CreateLink($partFolder,"",'all files');
			}

			}
			else{
				$errorMsg.='Invalid part!  Try again!</br>';
			}
		}
	}
	//Complete routine
	if($errorMsg){
		echo $errorMsg;
	}
	else{
		echo $linksToFiles;
	}

}

?>