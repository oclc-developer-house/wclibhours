<?php
    set_include_path('../../');
    require_once "../app/controllers/application_controller.php";
    require_once "../app/models/organization.php"; 
  $graph = buildOrganizationGraph($myorg_rdf);
?>

<html>
<head><title>EasyRdf Worldcat Branch Info Example</title></head>
<body>
<p>***EasyRdf Worldcat Branch Info Example***</p>

<?php
  $branch = $graph->allOfType('http://schema.org/Organization');
?>

<h1><?= $branch[0]->getName();?>
     
<?php 

echo '<a href="../app/views/hours.php?org='.$myorg.'"> (Hours)</a></h1>';


//Branch Library uri
$bOf= $branch[0]->get('schema:branchOf');
$bOf= (string)$bOf; //convert to string

//Parent Library uri		
$hasB= $branch[0]->get('wcir:hasBranch');
$hasB= (string)$hasB; //convert to string

if ($bOf!== ''){
	print "<p>Main library:</p>";
	print "<ul>";
	$branch[0]->print_branchOf();
	print "</ul>";
}

if ($hasB!== ''){ 
	print "<p>Branch library:</p>";
	print "<ul>";
	$branch[0]->print_hasBranch();
	print "</ul>";
}

		
  //print($branch[1]->branchOf());
  
  /*
	$branches=$branch[0]->branchOf();
	for ($i = 0, $l = count($branches); $i < $l; ++$i){
		
		echo "<br/><strong>".branches[$i]."</strong><br/>";
	}//for
*/

?>

</body>
</html>