<?php
  set_include_path(get_include_path() . PATH_SEPARATOR . '../');
  require_once "vendor/autoload.php";
	
	$client = new EasyRdf_Http_Client();
  $client->setHeaders('Accept',"application/rdf+xml");
	EasyRdf_Http::setDefaultHttpClient($client);     

	function buildGraph($arr_uris, $id_rdf) {
		$graph_hrs = new EasyRdf_Graph();
		foreach($arr_uris as $uri){
			try {
				$graph_hrs->load($uri . $id_rdf);
			}
			catch (Exception $e) {
				"Error " . $e->getMessage() . "\n";
			}
		}
		return $graph_hrs;
	}
              
EasyRdf_Namespace::set('schema', 'http://schema.org/');
EasyRdf_Namespace::set('wcir', 'http://purl.org/oclc/ontology/wcir/');

?>