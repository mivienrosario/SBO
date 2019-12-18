<?php
session_start();
  require 'db.inc.php';
  $today = date('Y-m-d');

  //insert student
  if (isset($_POST['saveStud'])) {
    $id = $_POST['studID'];
    $sectId = $_POST['sect_id'];
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
              contact_num)
            VALUES('$id', '$last', '$first', '$mid', '$address', '$num');";
    $sql = "INSERT INTO sbo.student_section(student_id,
              section_id)
            VALUES('$id', $sectId);";

    if (!mysqli_multi_query($conn, $sql)) {
      echo (mysqli_error($conn));
      header("Location: ../students.php?registration=error");
    } else {
      header("Location: ../students.php?registration=successful");
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
    //$start = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['start'])));
    //$end = date('Y-m-d',  strtotime(str_replace('-', '/', $_POST['end'])));
    $start = $_POST['start'];
    $end = $_POST['end'];
    $desc = $_POST['desc'];

    $sql = "INSERT INTO sbo.event(title, create_date, description, start_date, end_date) VALUES('$title', '$today', '$desc', '$start', '$end')";

    if (!mysqli_query($conn, $sql)) {
      echo (mysqli_error($conn));
      echo "<br><br>";
      echo $title;
      echo "<br><br>";
      echo $today;
      echo "<br><br>";
      echo $desc;
      echo "<br><br>";
      echo $start;
      echo "<br><br>";
      echo $end;
    } else {
      header("Location: ../index.php?saveEvent=error");
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  } //insert event

  //insert attendance, insert student attendance
  if (isset($_POST['add-attendance'])) {
    /*
    $inStartPM = date('H:i', strtotime($_POST['inStartPM']));
    $inEndPM = date('H:i', strtotime()$_POST['inEndPM']);
    $outStartPM = date('H:i', strtotime()$_POST['outStartPM']);
    $outEndPM = date('H:i', strtotime()$_POST['outEndPM']); */
    $date = $_POST['setDate'];
    //$type = $_POST['type'];
    $evId = $_POST['eventId'];
    //$start = date('H:i', strtotime($_POST['start']));
    //$end = date('H:i', strtotime($_POST['end']));
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

    $sql = "INSERT INTO sbo.attendance(date, event_id, am_in_start, am_in_end, am_out_start, am_out_end, pm_instart, pm_inend, pm_outstart, pm_outend) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../eventdetails.php?error=sql");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ssssssssss", $date, $evId, $inStartAM, $inEndAM, $outStartAM, $outEndAM, $inStartPM, $inEndPM, $outStartPM, $outEndPM);
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
    } //end insert attendance
  } //end add-attendance
