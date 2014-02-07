<?php
  set_include_path('../../');
  require_once "../app/controllers/application_controller.php";
  require_once "../app/models/hours.php";

date_default_timezone_set('America/New_York');
$graph = buildHoursGraph($myorg_id);
$resources = $graph->resourcesMatching('rdf:type');
$org = $resources[0];
?>

<html>
<head>
  <title><?php print $org->get('wcir:institutionName'); ?></title>
  <style type="text/css">
  body { font-family: Helvetica, Verdana, sans-serif; margin: 2em 15%; }
  </style>
</head>
<body>


<h1 typeOf= <?= '"' . $org->type() . '"' ?>> <?=$org->get('wcir:institutionName') ?></h1>
<?php
$normalHoursResources = $graph->allOfType('wcir:normalHours');

//Display only if normal hrs is not empty
if (count($normalHoursResources)!==0){
	print '<h2>Normal Hours</h2>';
	print "<table property=" . $normalHoursResources[0]->type() . ">";
	$mon='Monday';
	$tue='Tuesday';
	$wed='Wednesday';
	$thu='Thursday';
	$fri='Friday';
	$sat='Saturday';
	$sun='Sunday';
	foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
		$uri=$hoursSpec->getUri();    
		printnmhrs($hoursSpec, $uri, $mon);
	}//foreach
	foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
		$uri=$hoursSpec->getUri();    
		printnmhrs($hoursSpec, $uri, $tue);
	}//foreach
	foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
		$uri=$hoursSpec->getUri();    
		printnmhrs($hoursSpec, $uri, $wed);
	}//foreach
	foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
		$uri=$hoursSpec->getUri();    
		printnmhrs($hoursSpec, $uri, $thu);
	}//foreach
	foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
		$uri=$hoursSpec->getUri();    
		printnmhrs($hoursSpec, $uri, $fri);
	}//foreach
	foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
		$uri=$hoursSpec->getUri();    
		printnmhrs($hoursSpec, $uri, $sat);
	}//foreach
	foreach ($normalHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpec){
		$uri=$hoursSpec->getUri();    
		printnmhrs($hoursSpec, $uri, $sun);
	}//foreach
}//if normal hrs is not an empty array
print "</table>";
$spHoursResources = $graph->allOfType('wcir:specialHours');
//Display only if special hrs is not empty
if (count($spHoursResources)!==0){

	echo '<h2>Special Hours</h2>';
	$arrkey_all=[];
	$arrhrs_all=[]; 
	$arr_desc=[];
	foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
		$desc= $hoursSpecSp->get('wcir:description');
		//print_r($desc);
		//echo "<br/>";
		//print_r($desc->getValue());
		$v=$desc->getValue();
		if (!(in_array($v, $arr_desc))){
			array_push($arr_desc, $v);    
		}
		$arrhrs_all[rtndate($hoursSpecSp)]=rtnstatushrs($hoursSpecSp);
		array_push($arrkey_all, rtndate($hoursSpecSp));    
	} //foreach

	$arrkeySorted_all = bubbleSort($arrkey_all);
	//sortprinthrs($arrkeySorted_all, $arrhrs_all);
	//print_r($arr_desc);
	
	for ($i = 0, $l = count($arr_desc); $i < $l; ++$i){
		$v=$arr_desc[$i];
		echo "<br/><strong>".$v."</strong><br/>";
		foreach ($arrhrs_all as $value){
			if ((strpos($value, $v) !== false)){
				print_r($value);
			}//if
		}//foreach
		echo "<br/>";
	}//for

}// If special hours is not an empty array

include 'organization.php';
?>


</body>
</html>
