<?php

//StickyFieldEditPN
//Returns the value of the submitted form if it exists, OR, if the form is not submitted, it queries values from the database
function StickyFieldEditPN($pn,$field,$post){
	if (isset($post[$field])){
		return $post[$field];	
	}
	else{
		return getBOMDetail($pn,$field);
		echo getBOMDetail($pn,$field);
	}
}

?>