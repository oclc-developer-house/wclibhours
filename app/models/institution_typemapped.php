<?php
class Institution extends EasyRdf_Resource
{
    function getName()
    {
        $names = $this->all('schema:name');
        $name = $names[0];
        return $name->getValue();
    }
    
    function getNormalHoursSpecs()
    {
        $normalHours = $this->all('wcir:normalHours');
        $sortedHoursSpecs = $this->sortNormalHoursSpecs($normalHours[0]);
        return $sortedHoursSpecs;
    }

    function getSortedSpecialHoursSpecs()
    {
        $specialHours = $this->all('wcir:specialHours');
        $specialHoursSpec = $specialHours[0];
        $hoursSpecs = $specialHoursSpec->all('wcir:hoursSpecifiedBy');
        return $this->sortSpecialHoursSpecs($hoursSpecs);
    }
    
    private function sortNormalHoursSpecs($hoursResources)
    {
        $sortedHoursResources = array();
        foreach ($hoursResources->all('wcir:hoursSpecifiedBy') as $hoursSpec)
        {
            $dayOfWeek = HoursSpec::parseDayOfWeekFromUri($hoursSpec->getUri());
            $sortedHoursResources[getDayOrder($dayOfWeek)] = $hoursSpec;
        }
        return $sortedHoursResources;
    }

    private function sortSpecialHoursSpecs($specialHoursSpecs)
    {
        $sortedHoursSpecs = array();
        $hoursSpecsByStartDate = array();
        foreach ($specialHoursSpecs as $specialHoursSpec)
        {
            $startDateStr = $specialHoursSpec->getStartDate()->getValue();
            $hoursSpecsByStartDate[$startDateStr] = $specialHoursSpec;
        }
        
        $dates = array_keys($hoursSpecsByStartDate);
        sort($dates);
        $i = 0;
        foreach ($dates as $date)
        {
            $sortedHoursSpecs[$i] = $hoursSpecsByStartDate[$date];
            $i++;
        }
        return $sortedHoursSpecs;
    }
}
?>