<?php
require 'vendor/autoload.php';

$graph = EasyRdf_Graph::newAndLoad("https://worldcat.org/wcr/organization/data/110570.rdf");
$graph->load('https://worldcat.org/wcr/normal-hours/data/110570.rdf');
$graph->load('https://worldcat.org/wcr/special-hours/data/110570.rdf');

//echo $graph->dump();

EasyRdf_Namespace::set('schema', 'http://schema.org/');
EasyRdf_Namespace::set('wcir', 'http://purl.org/oclc/ontology/wcir/');

echo '<h1>Florida International University Medical Library</h1>';
echo '<h2>Normal Hours</h2>';

$normalHoursResources = $graph->allOfType('wcir:normalHours');

foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
    //print $hoursSpec->getUri() . "\n";
    $uri=$hoursSpec->getUri();    
    $weekday=str_replace('https://www.worldcat.org/wcr/normal-hours/resource/110570#', '', $uri);
    print $weekday.' : ';
    print $hoursSpec->get('wcir:opens');
    print ' - ';
    print $hoursSpec->get('wcir:closes');
    echo "<br/>";
}

echo '<h2>Special Hours</h2>';

$spHoursResources = $graph->allOfType('wcir:specialHours');
echo '<h3>Holidays</h3>';

foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
	$desc= $hoursSpecSp->get('wcir:description');
	if ($desc=="Holiday"){
		printhrs($hoursSpecSp);		
    } //holiday
    
} //foreach

echo '<h3>Spring Break</h3>';
foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
	
	$desc= $hoursSpecSp->get('wcir:description');
	if ($desc=="Spring Break"){
		printhrs($hoursSpecSp);	
    } //Spring Break
    
}//foreach

echo '<h3>SPRING 2014 Exceptions</h3>';
foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
	$desc= $hoursSpecSp->get('wcir:description');
	if ($desc=="SPRING 2014 Exceptions"){
		printhrs($hoursSpecSp);	
    } //Spring 2014 Exceptions
	
}//foreach

echo '<h3>Winter Break Hours</h3>';
foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
	$desc= $hoursSpecSp->get('wcir:description');
	if ($desc=="Winter Break Hours"){
		printhrs($hoursSpecSp);	
    } //Winter Break Hours
}//foreach

function dt($tm){
	$tm = new DateTime($tm, new DateTimeZone('America/New_York'));
	$tm_st = $tm->format('m/d, Y');  
	$tm_lg = $tm->format('Y-m-d H:i'); 
	return $tm_st; 
}

function printhrs($hoursSpecSp){
			//Open or Closed?
		$status= $hoursSpecSp->get('wcir:openStatus'); 
	    print "<br/>";	    
	    $sd=$hoursSpecSp->get('wcir:validFrom');
		$endd=$hoursSpecSp->get('wcir:validFrom');		
		//One day or Longer?
		if ($sd!==$endd){
			print dt($hoursSpecSp->get('wcir:validFrom'));	    
		} //if start =end date show the hours
	    else{
			print dt($hoursSpecSp->get('wcir:validFrom'));	    
			print ' - ';
			print $hoursSpecSp->get('wcir:validTo');	
			print '<br/>';    
	    } //if more than one day
	    if ($status=="Open"){
	    	print " <strong>".$status."</strong> ";
			print $hoursSpecSp->get('wcir:opens');
			print ' - ';
			print $hoursSpecSp->get('wcir:closes');
		} //if open
		else if ($status=="Closed"){
	    	print " <strong>".$status."</strong> ";
		}// if closed
		//print ' ('.$hoursSpecSp->get('wcir:description').')';		
}
//var_dump($hoursSpec);

?>