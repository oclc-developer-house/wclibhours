<?php
    set_include_path('../../');
    require_once "app/models/organization.php";
    require_once "app/controllers/application_controller.php";
  
  $graph = buildOrganizationGraph($myorg_rdf);
?>

<html>
<head><title>EasyRdf Worldcat Branch Info Example</title></head>
<body>
<h1>EasyRdf Worldcat Branch Info Example</h1>
<?php
  $branch = $graph->allOfType('http://schema.org/Organization');
?>
<dl>
    <dt>Org Name:</dt><dd><?= $branch[0]->getName();?></dd>
</dl>
<?php
  print "Parent Branch: " . "<a href=" . $branch[0]->branchOf() . ">" . $branch[0]->branchOf() . "</a>";
?>

</body>
</html>