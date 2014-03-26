<?php


//CreateLink - returns an html hyperlink to a file, given the folder location and file name
function CreateLink($folder,$file,$linkTitle){
	$folder=substr($folder, strpos($folder, 'www/')+4);
	return "<a href=\"".$folder.$file."\">".$linkTitle."</a>";
}

//GetLatestRev takes a slew of revisions, and returns the most recent
function GetLatestRev($revs){
	arsort($revs);
	$latestRev=$revs[0];
	foreach ($revs as $rev) {
		if (!is_numeric($rev)){
			$latestRev = $rev;
		}
	}
	return $latestRev;
}

//GenerateFileqTip -- creates all of the text for the tool tip
function GenerateFileURLs($pn,$fileroot,$allFiles=False,$option=''){
	$errorMsg='';
	$linksToFiles='';
	$partFolder= $fileroot."/".$pn."/";

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
					$errorMsg.='No files!</br>';
				}
				//setup links to files for latest revs, or all revs, if specified
				if($allFiles){
					//links to all files
					foreach ($partRevs as $rev) {
						$partFolderRev=$partFolder.$rev."/";
						if (($handle = opendir($partFolderRev)) && !$errorMsg) {  //open the part folder
						    while (false !== ($file = readdir($handle))) {  //only pay attention to real folders/files
						        if ($file != "." && $file != "..") {  //ignore system files
						            $linksArray[$file]=CreateLink($partFolderRev,$file,$file)."</br>";
						        }
						    }
						    arsort($linksArray);
						    foreach ($linksArray as $file => $filelink) {
						    	$linksToFiles.=$filelink;
						    }
						    closedir($handle);
						}	
					}
				}
				else{
					//links to latest rev files only
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
			}
			else{
				$errorMsg.='Invalid part!  Try again!</br>';
			}
		}
	}
	//Complete routine
	if($errorMsg){
		return $errorMsg;
	}
	else{
		return $linksToFiles;
	}

}

?>