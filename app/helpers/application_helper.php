<?php
//Helper functions for hours.
function printnmhrs($hoursSpec, $uri, $dayofweek){
   
    if (strpos($uri, $dayofweek) !== false) {
    
    	print "<tr><td>" . $dayofweek." : <td/>";
    	$status= $hoursSpec->get('wcir:openStatus');
      print "<td>";
		if ($status=="Open24Hours"){
			print  "Open 24/7" ;
		}
		else if ($status=="Open"){
			print dt_hr($hoursSpec->get('wcir:opens'));
			print ' - ';
			print dt_hr($hoursSpec->get('wcir:closes'));			
		}
    
		echo "</td></tr>";
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
//End helper functions for hours.
?>