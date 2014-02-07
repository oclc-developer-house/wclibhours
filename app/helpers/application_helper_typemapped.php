<?php
function formatDateTimeAsDate($dateTime) 
{
    $dateTimeObject = new DateTime($dateTime, new DateTimeZone('America/New_York'));
    return $dateTimeObject->format('F j, Y');  
}

function getDayOrder($dayOfWeek)
{
    $days = array(
        'Sunday' => 1,
        'Monday' => 2,
        'Tuesday' => 3,
        'Wednesday' => 4,
        'Thursday' => 5,
        'Friday' => 6,
        'Saturday' => 7
    );
    return $days[$dayOfWeek];
}
?>