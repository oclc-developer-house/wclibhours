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

try {
$graph1 = EasyRdf_Graph::newAndLoad("https://worldcat.org/wcr/organization/data/".$myorg_rdf);
$graph = $graph1;
}
catch (Exception $e) {
  print "graph1 not loaded. " . $e->getMessage() . "\n";
}
try {
$graph2 = EasyRdf_Graph::newAndLoad('https://worldcat.org/wcr/normal-hours/data/'.$myorg_rdf);
$graph->$graph2;
}
catch (Exception $e) {
  print "graph2 not loaded. " . $e->getMessage() . "\n";
}
try {
$graph3 = EasyRdf_Graph::newAndLoad('https://worldcat.org/wcr/special-hours/data/'.$myorg_rdf);
$graph->$graph3;
}
catch (Exception $e) {
  print "graph3 not loaded. " . $e->getMessage() . "\n";
}

EasyRdf_Namespace::set('schema', 'http://schema.org/');
EasyRdf_Namespace::set('wcir', 'http://purl.org/oclc/ontology/wcir/');


?>