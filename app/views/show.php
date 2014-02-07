<html>
<head>
  <title><?php print $org->getName(); ?></title>
  <style type="text/css">
  body { font-family: Helvetica, Verdana, sans-serif; margin: 2em 15%; }
  </style>
</head>
<body>

<h1><?php print $org->getName(); ?></h1>

<h2>Normal Hours</h2>
<?php
$sortedHoursSpecs = $org->getNormalHoursSpecs();
foreach (range(1, 7) as $number) 
{
    print "<p>";
    $hoursSpec = $sortedHoursSpecs[$number];
    print '<strong>' . $hoursSpec->getDayOfWeek() . ':</strong> ';
    print $hoursSpec->getOpeningTime() . ' ';
    print $hoursSpec->getClosingTime() . ' ';
    print "</p>\n";
}
?>

<h2>Breaks &amp; Holidays</h2>
<?php
foreach($org->getSortedSpecialHoursSpecs() as $hoursSpec)
{
    print "<h3>" . $hoursSpec->getDescription() . "</h3>\n";
    print "<p>";
    print formatDateTimeAsDate($hoursSpec->getStartDate());
    if (formatDateTimeAsDate($hoursSpec->getEndDate()) != formatDateTimeAsDate($hoursSpec->getStartDate()))
        print ' - ' . formatDateTimeAsDate($hoursSpec->getEndDate()) . ' ';
    print "</p>\n";
    print "<p>";
    print $hoursSpec->getOpenStatus() . ' ';
    print $hoursSpec->getOpeningTime() . ' ';
    print $hoursSpec->getClosingTime() . ' ';
    print "</p>";
    print "\n\n";
}
?>
</body>
</html>