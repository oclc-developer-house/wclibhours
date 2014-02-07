<?php
    set_include_path('../../');
    require_once "app/controllers/application_controller.php";
    require_once "app/models/hours.php";
	date_default_timezone_set('America/New_York');
    
$graph = buildHoursGraph($myorg_rdf);

$resources = $graph->resourcesMatching('rdf:type');
$org = $resources[0];
echo "<h1>".$org->get('wcir:institutionName')."</h1>";

//echo '<h1>!Florida International University Medical Library</h1>';

$normalHoursResources = $graph->allOfType('wcir:normalHours');

//Display only if normal hrs is not empty
if (count($normalHoursResources)!==0){
	echo '<h2>Normal Hours</h2>';
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

/*
	echo '<h3>Holidays</h3>';
	$arrkey=[];
	$arrhrs=[];    
	foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
		$desc= $hoursSpecSp->get('wcir:description');
		if ($desc=="Holiday"){
			$arrhrs[rtndate($hoursSpecSp)]=rtnstatushrs($hoursSpecSp);
			array_push($arrkey, rtndate($hoursSpecSp));    	
		} //holiday
	} //foreach
	$arrkeySorted = bubbleSort($arrkey);
	sortprinthrs($arrkeySorted, $arrhrs);

	echo '<h3>Spring Break</h3>';
	$arrkey_sb=[];
	$arrhrs_sb=[];
	foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
		$desc= $hoursSpecSp->get('wcir:description');
		if ($desc=="Spring Break"){
			//date, status, hours
			$arrhrs_sb[rtndate($hoursSpecSp)]=rtnstatushrs($hoursSpecSp);
			array_push($arrkey_sb, rtndate($hoursSpecSp));    	
		} //if spring break    
	} //foreach
	$arrkeySorted_sb = bubbleSort($arrkey_sb);
	sortprinthrs($arrkeySorted_sb, $arrhrs_sb);

	echo '<h3>SPRING 2014 Exceptions</h3>';
	$arrkey_se=[];
	$arrhrs_se=[];
	foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
		$desc= $hoursSpecSp->get('wcir:description');
		if ($desc=="SPRING 2014 Exceptions"){
			$arrhrs_se[rtndate($hoursSpecSp)]=rtnstatushrs($hoursSpecSp);
			array_push($arrkey_se, rtndate($hoursSpecSp));    	
		} //
	} //foreach
	$arrkeySorted_se = bubbleSort($arrkey_se);
	sortprinthrs($arrkeySorted_se, $arrhrs_se);

	echo '<h3>Winter Break Hours</h3>';
	$arrkey_wb=[];
	$arrhrs_wb=[];
	foreach ($spHoursResources[0]->all('wcir:hoursSpecifiedBy') as $hoursSpecSp){
		$desc= $hoursSpecSp->get('wcir:description');
		if ($desc=="Winter Break Hours"){
			$arrhrs_wb[rtndate($hoursSpecSp)]=rtnstatushrs($hoursSpecSp);
			array_push($arrkey_wb, rtndate($hoursSpecSp));    	
		} //
	} //foreach
	$arrkeySorted_wb = bubbleSort($arrkey_wb);
	sortprinthrs($arrkeySorted_wb, $arrhrs_wb);
*/
}// If special hours is not an empty array


//Functions START
function printnmhrs($hoursSpec, $uri, $dayofweek){
    if (strpos($uri, $dayofweek) !== false) {
    	echo $dayofweek." : ";
    	$status= $hoursSpec->get('wcir:openStatus'); 
		if ($status=="Open24Hours"){
			print "Open 24/7";
		}
		else if ($status=="Open"){
			print dt_hr($hoursSpec->get('wcir:opens'));
			print ' - ';
			print dt_hr($hoursSpec->get('wcir:closes'));			
		}

		echo "<br/>";
    } //if 
}

function dt($tm){
	$tm = new DateTime($tm, new DateTimeZone('America/New_York'));
	$tm_st = $tm->format('m/d/Y');  
	$tm_lg = $tm->format('Y-m-d h:i'); 
	return $tm_st; 
}

function dt_hr($tm){
	$tm = new DateTime($tm, new DateTimeZone('America/New_York'));
	$tm_lg = $tm->format('h:i A'); 
	return $tm_lg; 
}

function printhrs($hoursSpecSp){
		$status= $hoursSpecSp->get('wcir:openStatus'); 
	    print "<br/>";	    
	    $sd=$hoursSpecSp->get('wcir:validFrom');
		$endd=$hoursSpecSp->get('wcir:validTo');		
		//One day or Longer?
		if ($sd==$endd){
			print dt($hoursSpecSp->get('wcir:validFrom'));	    
		} //if start =end date show the hours
	    else{
			print dt($hoursSpecSp->get('wcir:validFrom'));	    
			print ' - ';
			print dt($hoursSpecSp->get('wcir:validTo'));	
			print ' ';    
	    } //if more than one day
	    if ($status=="Open"){
	    	print " <strong>".$status."</strong> ";
			print dt_hr($hoursSpecSp->get('wcir:opens'));
			print ' - ';
			print dt_hr($hoursSpecSp->get('wcir:closes'));
		} //if open
		else if ($status=="Closed"){
	    	print " <strong>".$status."</strong> ";
		}// if closed
		//print ' ('.$hoursSpecSp->get('wcir:description').')';		
}

function rtndate($hoursSpecSp){
	    $sd=$hoursSpecSp->get('wcir:validFrom');
		return dt($sd);
}

function rtndaterange($hoursSpecSp){
	    $sd=$hoursSpecSp->get('wcir:validFrom');
		$endd=$hoursSpecSp->get('wcir:validTo');		
		return dt($sd)." - ".dt($endd);
}

function rtnstatushrs($hoursSpecSp){
		$sd=$hoursSpecSp->get('wcir:validFrom');
		$endd=$hoursSpecSp->get('wcir:validTo');	
		$desc= $hoursSpecSp->get('wcir:description');

		if ($sd==$endd) {$rt= "<br/>".dt($sd)." ";}
		else {$rt ="<br/>".dt($sd)." - ".dt($endd)." ";}
		
		$status= $hoursSpecSp->get('wcir:openStatus'); 		
		$rt .=": <strong>".$status."</strong> ";
		//if open, display hours
		if ($status=="Open"){
			$ophr=$hoursSpecSp->get('wcir:opens');
			$rt .= dt_hr($ophr)." - ";
			$closehr=$hoursSpecSp->get('wcir:closes');
			$rt .= dt_hr($closehr)."";
		}
		if ($status=="Open24Hours"){
			$rt .= " 24/7 ";
		}
		$rt.=" (".$desc.")";
		
		return $rt;
}

/**
   * swapValue2()
   * @param array $array
   * @param int $dex
   *  @param int $dex2
   * swap two array values
**/
function swapValues2( $array, $dex, $dex2 ) {
    list($array[$dex],$array[$dex2]) = array($array[$dex2], $array[$dex]);
    return $array;
}
 
/**
   * bubbleSort()
   * @param array $array
   * performs bubble sort using optimized implementation
**/
 
function bubbleSort( $array)
{
    for( $out=0, $size = count($array);
                                   $out < $size -1 ;
                                            $out++ )
       {
        for( $in = $out + 1;
                      $in < $size;
                      $in++ )
               {
              if (strtotime($array[ $out ]) >
                               strtotime($array[ $in ]))
                     {
                $array = swapValues2($array, $out, $in);
                      }
        }
    }
    return $array; 
}

function sortprinthrs($arrkeySorted, $arrhrs){
	foreach ($arrkeySorted as $value){
		foreach ($arrhrs as $k => $v){
			if ($value==$k){
			print $v;
			}
		}
	}
}
//Functions END
?>
