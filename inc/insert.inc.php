<?php
session_start();
  require 'db.inc.php';
  $today = date('Y-m-d');

  //insert student
  if (isset($_POST['saveStud'])) {
    $id = $_POST['sId'];
    $sectId = $_POST['yr_sect'];
    $last = $_POST['lname'];
    $first = $_POST['fname'];
    $mid = $_POST['mname'];
    $address = $_POST['address'];
    $num = $_POST['num'];

    $sql = "INSERT INTO sbo.student(student_id,
              last_name,
              first_name,
              middle_name,
              address,
              contact_num,
              section_id)
            VALUES('$id', '$last', '$first', '$mid', '$address', '$num', $sectId);";

    if (!mysqli_query($conn, $sql)) {
      echo (mysqli_error($conn));
    } else {
      header("Location: ../studentlist.php?registration=successful");
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }

  //insert emergency_contact
  if (isset($_POST['em-save'])) {
    $emLast = $_POST['em-lname'];
    $emFirst = $_POST['em-fname'];
    $emMid = $_POST['em-mname'];
    $emNum = $_POST['em-num'];
    $emAdd = $_POST['em-address'];

    $sql = "INSERT INTO sbo.emergency(last_name, first_name, middle_name, contact_num, address) VALUES('$emLast', '$emFirst', '$emMid', '$emNum', '$emAdd')";

    if (!mysqli_query($conn, $sql)) {
      echo (mysqli_error($conn));
    } else {
      header("Location: ../index.php?saveEm=error");
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }

  //insert event
  if (isset($_POST['add-event'])) {
    $title = $_POST['title'];
    $start = date('Y-m-d', strtotime($_POST['start']));
    $end = date('Y-m-d', strtotime($_POST['end']));
    if ($_POST['description'] == NULL) {
      $desc = "No description.";
    } else {
      // code...
      $desc = $_POST['description'];
    }


    $sql = "INSERT INTO sbo.events(title, description, start_date, end_date) VALUES(?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?saveEvent=error");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ssss", $title, $desc, $start, $end);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      header("Location: ../event.php?saveEvent=success");
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  } //insert event

  //insert attendance, insert student attendance
  if (isset($_POST['add-attendance'])) {

    $setDate = date('Y-m-d', strtotime($_POST['setDate']));

    $evId = $_POST['eventId'];

    if (isset($_POST['setAM'])) {

      $inStartAM = date('H:i', strtotime($_POST['inStartAM']));

      $inEndAM = date('H:i', strtotime($_POST['inEndAM']));

      $outStartAM = date('H:i', strtotime($_POST['outStartAM']));

      $outEndAM = date('H:i', strtotime($_POST['outEndAM']));

    } else {

      $inStartAM = 'N/A';

      $inEndAM  = 'N/A';

      $outStartAM = 'N/A';

      $outEndAM = 'N/A';

    }

    if (isset($_POST['setPM'])) {

      $inStartPM = date('H:i', strtotime($_POST['inStartPM']));

      $inEndPM = date('H:i', strtotime($_POST['inEndPM']));

      $outStartPM = date('H:i', strtotime($_POST['outStartPM']));

      $outEndPM = date('H:i', strtotime($_POST['outEndPM']));

    } else {

      $inStartPM = 'N/A';

      $inEndPM  = 'N/A';

      $outStartPM = 'N/A';

      $outEndPM = 'N/A';

    }

    $sql = "INSERT INTO
                sbo.attendance(
                    date,
                    event_id,
                    am_in_start,
                    am_in_end,
                    am_out_start,
                    am_out_end,
                    pm_instart,
                    pm_inend,
                    pm_outstart,
                    pm_outend)
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../eventdetails.php?id=$evId&error=sql");
      exit();
    } else {
      mysqli_stmt_bind_param(
          $stmt,
          "ssssssssss",
          $setDate,
          $evId,
          $inStartAM,
          $inEndAM,
          $outStartAM,
          $outEndAM,
          $inStartPM,
          $inEndPM,
          $outStartPM,
          $outEndPM);
      echo mysqli_error($conn);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $attId = mysqli_insert_id($conn);
      echo $attId;
      echo "<br>";

        //fetch student IDs
        $sql2 = "SELECT * FROM sbo.student;";
        $list = mysqli_query($conn, $sql2);
        $listCheck = mysqli_num_rows($list);
        $index = 0;

        //store student IDs into array
        if ($listCheck > 0) {
          while ($row = mysqli_fetch_assoc($list)) {
            $sId = $row['student_id'];
            echo $sId;
            $sql3 = "INSERT INTO sbo.student_attendance(att_id, student_id) VALUES(?, ?)";
            $stmt2 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt2, $sql3)) {
              echo mysqli_error($conn);
            } else {
              mysqli_stmt_bind_param($stmt2, "ss", $attId, $sId);
              echo mysqli_error($conn);
              mysqli_stmt_execute($stmt2);
            }
          }
        } else { //end result check
          // code...
          echo mysqli_error($conn);
        }

        header("Location: ../eventdetails.php?success=addAttendance&id=$evId");
        exit();
    } //end insert attendance
  } //end add-attendance

  //insert new survey
  if (isset($_POST['add-survey'])) {
    $event = $_POST['id'];
    $title = $_POST['title'];
    $sql = "INSERT INTO sbo.survey(surveytitle, eventid) VALUES(?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo mysqli_error($conn);
      //header("Location: ../index.php?saveEvent=error");
      //exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $title, $event);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      header("Location: ../surveylist.php?addSurvey=success");
      exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
