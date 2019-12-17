<?php

$table = array("table1", "table2", "table3", "table4");
    $size = array(1, 2, 3);

    for($i=0;$i < sizeof($size); $i++) {
    	echo $table[$i];
    }
?>

<?php if (sizeof($size) < 0): ?>
  <p>Size is more than 0</p>
<?php endif; ?>
