<?php

/**
 * Generate an array of string dates between 2 dates
 *
 * @param string $start Start date
 * @param string $end End date
 * @param string $format Output format (Default: Y-m-d)
 *
 * @return array
 */

 function getRangeOfDate($start, $end, $format = 'Y-m-d')
 {
     $interval = new DateInterval('P1D');

     $endDate = new DateTime($end);
     $endDate->add($interval);

     $period = new DatePeriod(
        new DateTime($start),
        $interval,
        $endDate
     );

     foreach($period as $date) {
         $array[] = $date->format('m-d-Y');
     }

     return $array;
 }

$arr[] = getRangeOfDate('01-02-2020', '01-08-2020');
for ($i = 0; $i < sizeof($arr); $i++) {
    $s = $arr[$i];

    print_r ($s[$i]);

}

 ?>
