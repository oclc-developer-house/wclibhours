<?php
  set_include_path(get_include_path() . PATH_SEPARATOR . '../');
  require_once "vendor/autoload.php";   

	function buildGraph($arr_uris, $id_wcir) {
	
	  $client = new EasyRdf_Http_Client();
    $client->setHeaders("Accept","application/rdf+xml"); 
  
    $graph = new EasyRdf_Graph();
		foreach($arr_uris as $uri){
			try {
			  $uri = $uri . $id_wcir . '.rdf';
			  print_r($uri);
			  EasyRdf_Http::setDefaultHttpClient($client);
				$graph->load($uri, "rdfxml");
				$graph->dump();
			}
			catch (Exception $e) {
				"Error " . $e->getMessage() . "\n";
			}
		}
		EasyRdf_Namespace::set('schema', 'http://schema.org/');
    EasyRdf_Namespace::set('wcir', 'http://purl.org/oclc/ontology/wcir/');
		return $graph;
	}
              

?>