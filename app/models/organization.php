<?php
  set_include_path(get_include_path() . PATH_SEPARATOR . '../../');
  require_once 'lib/graph.php';
EasyRdf_TypeMapper::set('schema:Organization', 'Organization');
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

        function print_branchOf()
        {
            foreach ($this->all('schema:branchOf') as $parent_org) {
				echo $parent_org->get("wcir:unitName");
                $bOfhrs= str_replace("https://www.worldcat.org/wcr/organization/resource/","../../basic/index.php?org=", $parent_org);  //link to hours  
                $bOflib= str_replace("https://www.worldcat.org/wcr/organization/resource/","../../app/views/organization.php?org=", $parent_org);  //link to hours  
              print "<li><a href=".$bOflib.">".Library."</a> (<a href=".$bOfhrs.">Hours</a>)</li>";
            }
            return null;
        }
       
        function print_hasBranch()
        {
            foreach ($this->all('wcir:hasBranch') as $branch_org) {
            	echo $branch_org->get("wcir:unitName");

                $hasBhrs= str_replace("https://www.worldcat.org/wcr/organization/resource/","../../basic/index.php?org=", $branch_org);  //link to hours  
                $hasBlib= str_replace("https://www.worldcat.org/wcr/organization/resource/","../../app/views/organization.php?org=", $branch_org);  //link to hours  
                print "<li><a href=".$hasBlib.">Library</a> (<a href=".$hasBhrs.">Hours</a>)</li>";

            }
            return null;
        }
   
        function getName()
        {
          return $this->get('wcir:unitName');
        }
       
}   
?>