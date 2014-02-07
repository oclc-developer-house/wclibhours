<?php
require_once '../lib/graph.php';
function buildOrganizationGraph($wcid) {
      $arr_org_uris = array("https://worldcat.org/wcr/organization/data/");
      $graph_org = new EasyRdf_Graph();
    //  Uncomment to load data fixtures instead of live data.
    //  $graph_org->parseFile("../../data/org.1095.rdf");
		  $graph_org = buildGraph($arr_org_uris, $wcid);
		  return $graph_org;
}

function graphBranches($graph, $property){
  $branches = $graph->resourcesMatching($property);
  $graph_branches = new EasyRdf_Graph();
  foreach($branches as $branch) {
    $branch = str_replace('wcr/organization/resource/', 'wcr/organization/data/', $branch);
    $branch = $branch . ".rdf";
    $graph_branches->load($branch);
    return $graph_branches;
  }
   return $graph_branches;
 }
 /** Not working
 * function graphChildBranches($graph){
  return graphBranches($graph, 'wcir:hasBranch');
 }

 * function graphParentBranches($graph){ 
  return graphBranches($graph, 'schema:branchOf');
 }   
  
 * function graphSiblingBranches($graph){  
  //If this is not the main branch, get other children of the parent, i.e. other branches of the main library.
  return graphBranches(graphParentBranches($graph), 'wcir:hasBranch');
 }
**/

class Organization extends EasyRdf_Resource
{          
        function branchOf()
        {
            foreach ($this->all('schema:branchOf') as $parent_org) {
                    return $parent_org;
            }
            return null;
        }
    
        function getName()
        {
          $name = $this->get('wcir:unitName');
          if (empty($name)){
          $name = $this->get('wcir:institutionName');
          }
          return $name;
        }
}   
?>