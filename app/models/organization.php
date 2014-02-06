<?php
    set_include_path('../../');
    require_once "lib/graph.php";

EasyRdf_TypeMapper::set('http://schema.org/Organization', 'Model_Organization'); 

function buildOrganizationGraph($wcid_rdf) {
      $arr_org_uris = array("https://worldcat.org/wcr/organization/data/");
		  $graph_org = buildGraph($arr_org_uris, $wcid_rdf);
		  return $graph_org;
}

class Model_Organization extends EasyRdf_Resource
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
          return $this->get('wcir:unitName');
        }
}
    
?>