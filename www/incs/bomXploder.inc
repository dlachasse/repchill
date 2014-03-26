<?php

//buildXplodingRow - returns a table in string format to be collapsable
function buildXplodingRow($rawPart=False,$partBOMassociations=False,$bomLevel,$printHeader=True,$tableClass='xPlodeTable',$custom_header_attrs=False,$degguins=False,$tableType="jqTree"){
    
    if(!$degguins){
        $tableStr='';
        //setup header info
        if(!$custom_header_attrs){
            $header_attrs = array(
                'lvl' => 'Lvl',
                'pn' => 'Part Number', 
                'description' => 'Description', 
                'itemnum' => 'Item Number', 
                'qty' => 'Quantity', 
                'uom' => 'UoM', 
                'source' => 'Source', 
                'rev' => 'Rev' 
            );
        }
        else{
            $header_attrs = $custom_header_attrs;
        }

        //build table header
        $tableStr.="<table class=\"$tableClass\"><tr>";
        foreach ($header_attrs as $class => $header_text) {
                if(!$printHeader){
                    $header_text=''; 
                }
                //echo $header_text;
                $tableStr.="<th class=\"$class\">".$header_text."</th>";
        }
        $tableStr.='</tr>';

        //build data
        if(!$printHeader && ($tableType=="jqTree")){
            $tableStr.='<tr>';
            foreach ($header_attrs as $class => $header_text) {
                if(isset($rawPart->$class))$cellText = $rawPart->$class;
                if(isset($partBOMassociations->$class)) $cellText = $partBOMassociations->$class;
                if($class=='lvl') $cellText = $bomLevel;
                $tableStr.="<td>".$cellText."</td>";
                unset($cellText);
            }
            $tableStr.='</tr>'; 
        }

        //finish table
        if(!$tableType=="jqTreeData"){
            $tableStr.='</table>';    
        }

        $tableStr=replace_newline($tableStr);
    }
    else{
        $tableStr='debug';
    }

    return $tableStr;
}


//xPlode builds a HTML table or JS collapsable to show a fully exploded BOM
///Requirements: a global variable $jqTreeData outside of the functions scope, defined empty
///Inputs: 1x xploder object, and 1x tableMode (i.e. html or JS)
$jqTreeData="var data = [\n"; //used to build var data = ... in php first, then pass to JS
function xPlode($xploder,$tableMode='jqTree',$bomLevel=0){
    global $jqTreeData;
    $noMoreBOM = False; //assume we have a BOM to scour
    
    //only execute if you are on the top node
    if($bomLevel==0){
        if(!($xploder->headersWritten)){       
            if($tableMode=='html'){
                /*echo '<table class="xPlodeTable">
                        <thead>
                            <tr>
                                <th>Lvl</th>
                                <th>PN</th>
                                <th>Description</th>
                                <th>Item Number</th>
                                <th>Quantity</th>
                                <th>Revision</th>
                                <th>Source</th>
                            </tr>
                        </thead>';
                    
                    */
                echo buildXplodingRow($xploder,$bomLevel=0,$printHeader=True,$tableType="html");
            }
            if($tableMode=='jqTree'){
                echo "<div id=\"xplodeTree\"></div>\n\n";

            }
            $topNode=True;
            $xploder->headersWritten=True;
            $header = buildXplodingRow($xploder,$bomLevel=0,$printHeader=True);
            $jqTreeData.="{ label:  '$header'},";
        }
    }

    //only process if this part has children
    if($xploder->bom){
        //MAIN XPLODE
        while (!$noMoreBOM) { //while a parent has unexploded children
            $bom=$xploder->bom[$xploder->childNumCounter]; // get the child's details
            $childPN = $bom->pn;
            $$childPN = new bomitemXploder($childPN,$xploder->pn);
            //if (!array_key_exists($childPN, $GLOBALS)){ //create new xploder if that xploder doesn't already exist in memory
                //if(!$noMoreBOM){ //prep this row to table
                    //init BOM detail vars
                    //$childPN = $bom->pn;  //that's a mouthful.
                    $itemnum= $bom->itemnum;
                    $description = $bom->description;
                    $quantity = $bom->qty;
                    $rev = $bom->rev;
                    $source = $bom->source;
                    $uom = $$childPN->uom;
                    
                    if($tableMode=='html'){
                        echo "
                        <tr>
                        <td>".echoMultiple('.',$bomLevel)."$bomLevel</td>
                        <td>$childPN</td>
                        <td>$description</td>
                        <td>$itemnum</td>
                        <td>$quantity</td>
                        <td>$uom</td>
                        <td>$source</td>
                        <td>$rev</td>
                        </tr>";
                    }
                    if($tableMode=='jqTree'){
                        $jqTreeData.=echoMultiple("\t",$bomLevel,0,True)."{\n";
                        $lineData = buildXplodingRow($$childPN,$bom,$bomLevel,False);
                        $jqTreeData.=echoMultiple("\t",$bomLevel,1,True)."label: '$lineData',\n"; //start the parent
                        $jqTreeData.=echoMultiple("\t",$bomLevel,2,True)."children: [\n";
                        //}
                    }
                //}
                //global $$childPN = new bomitemXploder($xploder->pn,$xploder->parent);
                xPlode($$childPN,$tableMode,($bomLevel+1));  //here's where the stack gets cray cray@!!
                $xploder->xPlodedBOM[] =$$childPN;
            //}
                $jqTreeData.=echoMultiple("\t",$bomLevel,1,True)."]\n"; //close children, if any! note: we create a spot for children regardless, even if none exist
                $jqTreeData.=echoMultiple("\t",$bomLevel,0,True)."},\n";
                $xploder->childNumCounter=$xploder->childNumCounter+1; //incriment the current xploders child index (i.e. move to next child item)
                if($xploder->childNumCounter>=count($xploder->bom)){ //all BOM xPloders created. done with parent
                    $noMoreBOM = True;
                }
        }
        
        //Complete  node
        $jqTreeData = substr($jqTreeData, 0, -2); //remove the , from the children...cause there are no more!
        $jqTreeData.="\n";
        if($tableMode=='jqTree'){
            if(isset($topNode)){ //finish top node
                $jqTreeData.='];';
            }

        }

        //Finalize table or tree
        if(isset($topNode) && $noMoreBOM==True){
            if($tableMode=='html'){
                echo '</table>';
            }
            if($tableMode=='jqTree'){
                echo "\n\n<script>\n";
                echo "$jqTreeData\n";
                echo '$(\'#xplodeTree\').tree({';
                    echo 'data: data,';
                    echo 'autoOpen: false,';
                    echo 'dragAndDrop: false';
                    echo '});';
                echo '</script>';
            }
        }
    }
}
?>