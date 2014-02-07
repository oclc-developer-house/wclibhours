<?php
  set_include_path('../../');
  require_once "../app/controllers/application_controller.php";
  require_once "../app/models/organization.php";  
  EasyRdf_TypeMapper::set('schema:Organization', 'Organization');
  $graph = buildOrganizationGraph($myorg_id);
?>

<h2>Branches:</h2>
<?php
  $orgs = $graph->allOfType('http://schema.org/Organization');
  foreach($orgs as $org) {
  
?>
  <h3>This Branch</h3>
  <span typeOf= <?= '"' . $org->type() . '"' ?>><?= $org->getName(); ?> :: </span> 
  
  <span property="schema:telephone"> <?= $org->get('schema:telephone'); ?> :: </span>
  
  <?php
  print_r($org->htmlLink());
  ?>
    
<?php
  }
?>
<!--
<span>Other Branches: </span>
-->
<?php
  /** Not working **/
  //graphChildBranches($graph);
  //graphParentBranches($graph));
  //graphSiblingBranches($graph);
 // $parent = $branches[0]->branchOf();
 
 ?>

