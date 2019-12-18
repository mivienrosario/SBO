<?php
  require 'db.inc.php';
  //edit event
  if (isset($_POST['edit-event'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $start = date('Y-m-d', strtotime($_POST['start']));
    $end = date('Y-m-d', strtotime($_POST['end']));

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
      header("Location: ../eventdetails.php?id=$eId&update=successful");
      exit();
    } else {
      echo mysqli_error($conn);
      echo $eId;
    }
  }

  //update student's section
  if(isset($_POST['student-section-update'])) {
    $id = $_POST['yrsect'];
    $sId = $_POST['sId'];
    $sql = "UPDATE sbo.student SET section_id = ? WHERE (student_id = ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo mysqli_error($conn);
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $id, $sId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      header("Location: ../profile.php?id=$sId&saveEvent=success");
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
