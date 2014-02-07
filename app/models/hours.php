<?php
  require_once '../lib/graph.php';                  
	function buildHoursGraph($wcid) {
	  $arr_hours_uris = array("https://worldcat.org/wcr/organization/data/", 
                "https://worldcat.org/wcr/normal-hours/data/", 
                "https://worldcat.org/wcr/special-hours/data/");
    $graph_hrs = new EasyRdf_Graph();
 //   Uncomment to use data fixtures from sample data instead.
 //   $graph_hrs->parseFile("../../data/org.1095.rdf");
 //   $graph_hrs->parseFile("../../data/hrs.1095.rdf");            
		$graph_hrs = buildGraph($arr_hours_uris, $wcid);
		return $graph_hrs;
	}
?>

