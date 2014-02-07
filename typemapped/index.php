<?php
require '../vendor/autoload.php';
require '../app/helpers/application_helper_typemapped.php';
require '../app/models/institution_typemapped.php';
require '../app/models/hours_spec_typemapped.php';

EasyRdf_Namespace::set('schema', 'http://schema.org/');
EasyRdf_Namespace::set('wcir', 'http://purl.org/oclc/ontology/wcir/');
EasyRdf_TypeMapper::set('schema:Organization', 'Institution');
EasyRdf_TypeMapper::set('wcir:hoursSpecification', 'HoursSpec');

$graph = new EasyRdf_Graph();
// $graph->load('https://worldcat.org/wcr/organization/data/128807.rdf');
$graph->parseFile("../sample-data/organization.rdf");
// $graph->load('https://worldcat.org/wcr/normal-hours/data/128807.rdf');
$graph->parseFile("../sample-data/normal-hours.rdf");
// $graph->load('https://worldcat.org/wcr/special-hours/data/128807.rdf');
$graph->parseFile("../sample-data/special-hours.rdf");

$orgs = $graph->allOfType('schema:Organization');
$org = $orgs[0];

include '../app/views/show_typemapped.php'
?>
