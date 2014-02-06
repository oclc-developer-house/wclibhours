<?php

if (isset( $_GET['org'] )){
	$myorg = $_GET['org']; // Query Param
	if (is_numeric($myorg)){
		$myorg_rdf = $myorg.".rdf";
	}
	else {
	//error or check user's location for nearest organization
	  exit("Parameter 'org' should be numeric");
	}
}//if org is set
else{
	echo "Please specify the OCLC institution number in the URL.<br/>e.g. hrs.php?org=110570";
}//if org not set

?>