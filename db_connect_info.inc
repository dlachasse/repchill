<?php 
DEFINE ('DB_USER', 'cdaringe');
DEFINE ('DB_USER2', 'cdarin5_pubdev');
DEFINE ('DB_PASS', 'pubdev');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'cdarin5_bom');
DEFINE ('DB_NAME2', 'cdarin5_footie');

function connectToBOMDb(){
  //Connect to database for use
  /*DB connect parameter*/
  @mysql_connect(DB_HOST,DB_USER,DB_PASS) OR die(':\'( '. mysql_error());
  /*connet to BOM DB*/
  @mysql_select_db(DB_NAME);
}

function connectToFootieDb(){
  //Connect to database for use
  /*DB connect parameter*/
  @mysql_connect(DB_HOST,DB_USER2,DB_PASS) OR die(':\'( '. mysql_error());
  /*connet to BOM DB*/
  @mysql_select_db(DB_NAME2);
}


?>    