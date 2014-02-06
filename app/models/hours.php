<?php
    set_include_path('../../');
    require_once "lib/graph.php";
                    
	function buildHoursGraph($wcid_rdf) {
	  $arr_hours_uris = array("https://worldcat.org/wcr/organization/data/", 
                    "https://worldcat.org/wcr/normal-hours/data/", 
                    "https://worldcat.org/wcr/special-hours/data/");
		$graph_hrs = buildGraph($arr_hours_uris, $wcid_rdf);
		return $graph_hrs;
		
		EasyRdf_TypeMapper::set('http://purl.org/oclc/ontology/wcir/normalHours', 'Model_Hours');
		EasyRdf_TypeMapper::set('http://purl.org/oclc/ontology/wcir/specialHours', 'Model_Hours'); 
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

