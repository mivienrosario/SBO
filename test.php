<?php
require 'inc/db.inc.php';
$sql2 = "SELECT * FROM sbo.student;";
$list = mysqli_query($conn, $sql2);
$listCheck = mysqli_num_rows($list);
$index = 0;

//store student IDs into array
if ($listCheck > 0) {
  while ($row = mysqli_fetch_assoc($list)) {
    $students[] = $row['student_id'];
    echo $students[$index];
    echo '<br>';
    $index++;
  }
} //end result check
$attId = mysqli_insert_id($conn);
echo $attId;
echo "<br>";
echo count($students);


// code...


/*

if ($resultCheck > 0) {

  //get last inserted id from sbo.attendance
  $attId = mysqli_stmt_insert_id($stmt);



} else { //end first resultcheck
  echo mysqli_error($conn);
}

for ($i=0; $i < count($students); $i++) {
  $student_id = $students[$i];
  $sql3 = "INSERT INTO sbo.student_attendance(att_id, student_id) VALUES(?, ?);";
  $stmt2 = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt2, $sql3)) {
    header("Location: ../eventdetails.php?error=sql");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt2, "ss", $attId, $student_id);
    echo mysqli_error($conn);
    mysqli_stmt_execute($stmt2);

  } //end insert
} //end loop
*/

/*
$sql = "INSERT INTO sbo.attendance(date, event_id, am_in_start, am_in_end, am_out_start, am_out_end, pm_instart, pm_inend, pm_outstart, pm_outend) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../eventdetails.php?error=sql");
  exit();
} else {
  mysqli_stmt_bind_param($stmt, "sssssssss", $date, $evId, $inStartAM, $inEndAM, $outStartAM, $outEndAM, $inStartPM, $inEndPM, $outStartPM, $outEndPM);
  echo mysqli_error($conn);
  mysqli_stmt_execute($stmt);
  /*
  $result = mysqli_stmt_get_result($stmt);
  $resultCheck = mysqli_num_rows($result);
  if ($resultCheck > 0) {
    //get last inserted id from sbo.attendance
    $attId = mysqli_insert_id($conn);
    // code...
    //fetch student IDs
    $sql = "SELECT * FROM sbo.student;";
    $list = mysqli_query($conn, $sql);
    $listCheck = mysqli_num_rows($list);

    //store student IDs into array
    if ($listCheck > 0) {
      while ($row = mysqli_fetch_assoc($list)) {
        $students[] = $row['student_id'];
      }
    } //end result check

    for ($i=0; $i < count($students); $i++) {
      $student_id = $students[$i];
      $sql2 = "INSERT INTO sbo.student_attendance(att_id, student_id) VALUES(?, ?);";
      $stmt2 = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../eventdetails.php?error=sql");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt2, "ss", $attId, $student_id);
        echo mysqli_error($conn);
        mysqli_stmt_execute($stmt2);

      } //end insert
    } //end loop
  } //end first resultcheck

  header("Location: ../eventdetails.php?id=$evId");
} //end insert

if (!mysqli_query($conn, $sql)) {
  echo mysqli_error($conn);
} else {
  //get last inserted id from sbo.attendance
  $attId = mysqli_insert_id($conn);

  //fetch student IDs
  $sql = "SELECT * FROM sbo.student;";
  $list = mysqli_query($conn, $sql);
  $listCheck = mysqli_num_rows($list);

  //store student IDs into array
  if ($listCheck > 0) {
    while ($row = mysqli_fetch_assoc($list)) {
      $students[] = $row['student_id'];
    }
  } //end result check

  for ($i=0; $i < count($students); $i++) {
    $student_id = $students[$i];
    $sql2 = "INSERT INTO sbo.student_attendance(att_id, student_id) VALUES($attId, '$student_id');";
    mysqli_query($conn, $sql2);
  } //end loop

  header("Location: ../eventdetails.php?id=$evId");
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
} */
