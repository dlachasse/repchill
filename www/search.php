<?php
require('../db_connect_info.inc');
connectToBOMDb();

	$term=strtoupper($_GET['term']);

	$query = "SELECT pn,description FROM item WHERE CONCAT(description,pn) LIKE '%".$term."%' LIMIT 10";
	$result = mysql_query($query) or die(mysql_error());

	while($row=mysql_fetch_array($result)) {
		$jsonItems['label']=$row['pn']."::".$row['description'];
		$jsonItems['value']=$row['pn'];
		$pn_queries[]=$jsonItems;
	}
	//json_encode($jsonItems);
	print json_encode($pn_queries);
?>