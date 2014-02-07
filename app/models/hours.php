<?php
    set_include_path('../../');
    require_once "lib/graph.php";
                    
	function buildHoursGraph($wcid) {
		EasyRdf_TypeMapper::set('http://purl.org/oclc/ontology/wcir/normalHours', 'Model_Hours');
		EasyRdf_TypeMapper::set('http://purl.org/oclc/ontology/wcir/specialHours', 'Model_Hours'); 

	  $arr_hours_uris = array("https://worldcat.org/wcr/organization/data/", 
                "https://worldcat.org/wcr/normal-hours/data/", 
                "https://worldcat.org/wcr/special-hours/data/");
    $graph_hrs = new EasyRdf_Graph();
 //   $graph_hrs->parseFile("../../data/org.1095.rdf");
 //   $graph_hrs->parseFile("../../data/hrs.1095.rdf");            
		$graph_hrs = buildGraph($arr_hours_uris, $wcid);

		return $graph_hrs;

	}
	
class Model_Hours extends EasyRdf_Resource
{                 
  function normalHours()
		{
				$hours = $this->all('wcir:normalHours', 'rdf:resource');
				if ($hours) {
						$year = substr($hours, 0, 4);
						if ($year) {
								return date('Y') - $year;
						}
				}
				return 'unknown';
		}


}

?>

