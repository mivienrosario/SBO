<?php
  require 'db.inc.php';
  //edit event
  if (isset($_POST['edit-event'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    $sql = "UPDATE sbo.events
      SET title='$title', description='$desc', start_date='$start', end_date='$end' WHERE event_id = $id;";

    if ($conn->query($sql) === TRUE) {
      header("Location: ../eventdetails.php?id=$id&update=successful");
      exit();
    } else {
      echo mysqli_error($conn);
      echo $id;
    }
  }

  //edit emergency contact
  if (isset($_POST['edit-contact'])) {

  }

  //mark attendance of a student
  if (isset($_POST['new-attendance'])) {
    $time = date('H:i', strtotime($_POST['time']));
    $sId = $_POST['sId'];
    $aId = $_POST['aId'];
    $type = $_POST['type'];
    $eId = $_POST['eId'];

    $sql = "UPDATE sbo.student_attendance SET $type = '$time' WHERE (att_id = $aId) AND (student_id = '$sId')";
    echo $sql;

    if ($conn->query($sql) === TRUE) {
      header("Location: ../test_event_details.php?id=$eId&update=successful");
      exit();
    } else {
      echo mysqli_error($conn);
      echo $eId;
    }
  }

  if (isset($_POST['addAttendance'])) {
    $setDate = $_POST['setDate'];
    //$var attendance type
    $inStartAM = date('H:i', $_POST['inStartAM']);
    $inStartAM = date('H:i', $_POST['inEndAM']);
    $inStartAM = date('H:i', $_POST['outStartAM']);
    $inStartAM = date('H:i', $_POST['outEndAM']);
    $inStartAM = date('H:i', $_POST['inStartPM']);
    $inStartAM = date('H:i', $_POST['inEndPM']);
    $inStartAM = date('H:i', $_POST['outStartPM']);
    $inStartAM = date('H:i', $_POST['outEndPM']);
  }
