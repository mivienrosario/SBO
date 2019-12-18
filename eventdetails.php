<?php
  require_once 'inc/db.inc.php';
  $id = NULL;
  if (!isset($_GET)) {
    header("Location: test_event.php?error=id");
    exit();
  } else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM sbo.events WHERE event_id = $id;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $dateSt = $row['start_date'];
        $dateEnd = $row['end_date'];
        $desc = $row['description'];
      }
    } else if(empty($resultCheck)) {
      echo 'No results found.<br>';
    }

    $today = date('Y-m-d');
    date_default_timezone_set('Asia/Singapore');
    $currentTime = strtotime(date('H:i'));
    $getTime = date("H:i");
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>W3.CSS Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-ios.css">
    <script src="https://kit.fontawesome.com/e1f7070413.js" crossorigin="anonymous"></script>
    <style>
      html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
      hr {
        border: 0;
        height: 1px;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
      }
    </style>
  </head>
  <body class="w3-ios-background">
    <?php
      include 'header.php';
      if (isset($_SESSION['logged_in']) != TRUE) {
        header("Location: login.php?error=invader");
        exit();
      }
    ?>

    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
      <div class="w3-container w3-row">
        <div class="w3-col s4">
          <img src="src/img/user.png" class="w3-circle w3-margin-right" style="width:46px">
        </div>

        <div class="w3-col s8 w3-bar">
          <span>Welcome, <strong><?php echo $_SESSION['uname']; ?></strong></span><br>
          <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
          <a href="#" class="w3-bar-item w3-button"><i class="fas fa-cogs"></i></a>
        </div>
      </div>
      <hr>
      <div class="w3-container">
        <h5>Dashboard</h5>
      </div>
      <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
        <a href="event.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fas fa-calendar-week"></i>  Events</a>
        <?php if ($_SESSION['utype'] != 4): ?>
          <a href="studentlist.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Students</a>
          <a href="section" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Sections</a>
        <?php endif; ?>
        <a href="inc/logout.inc.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-sign-out-alt fa-fw"></i>  Logout</a><br><br>
      </div>
    </nav> <!--Sidebar/menu -->

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <!-- Header -->
      <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fas fa-calendar-week"></i> Events</b></h5>
      </header> <!-- Header -->

      <div class="w3-container  w3-margin-bottom" style="width: 80%; margin-left: 1em;">
        <div class="w3-container">
          <h5 class="w3-opacity"><b><?php echo $title; ?></b></h5>
          <p><?php echo $desc; ?></p>
          <hr>
          <div class="w3-row">
            <div class="w3-col m2">
              <h5 class="w3-opacity"><b>Attendance</b></h5>
            </div>

            <!--
              check if user != student & officer
              display attendance table
            -->
            <?php if ($_SESSION['utype'] != 4&3): ?>
              <div class="w3-col m2">
                <button onclick="document.getElementById('subscribe').style.display='block'" type="button" name="button" class="w3-btn "><i class="fas fa-calendar-week"></i></button>
              </div>
            <?php endif; ?>



          </div>

          <!--
            check if user != student
            display attendance table
          -->
            <?php
              if ($_SESSION['utype'] != 4) {
                $table = array("table1", "table2", "table3", "table4", "table5");

                $sql = "SELECT DISTINCT a.date FROM sbo.student_attendance sa
                          JOIN sbo.attendance a
                            ON sa.att_id = a.attendance_id
                          JOIN sbo.events e
                            ON a.event_id = e.event_id
                          where a.event_id = $id;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $date = $row['date'];
                    $sql2 = "SELECT
                                  concat(s.last_name, ', ', s.first_name) as name,
                                  concat(se.year, se.section) as year_section,
                                  sa.am_in,
                                  sa.am_out,
                                  sa.pm_in,
                                  sa.pm_out,
                                  a.event_id,
                                  a.date,
                                  a.attendance_id,
                                  a.am_in_start,
                                  a.am_in_end,
                                  a.am_out_start,
                                  a.am_out_end,
                                  a.pm_instart,
                                  a.pm_inend,
                                  a.pm_outstart,
                                  a.pm_outend,
                                  s.student_id
                                FROM sbo.student_attendance sa
                                  join student s
                                    on sa.student_id = s.student_id
                                  join attendance a
                                    on sa.att_id = a.attendance_id
                                  join events e
                                    on a.event_id = e.event_id
                                  join section se
                                    on se.section_id = s.section_id
                            WHERE a.event_id = $id AND a.date = '$date';";

                    $result2 = mysqli_query($conn, $sql2);
                    $resultCheck2 = mysqli_num_rows($result2);
                    echo '<table id="table1" class="display">
                        <thead>
                          <th>Student ID</th>
                          <th>Name</th>
                          <th>Section</th>
                          <th>AM Sign In</th>
                          <th>AM Sign Out</th>
                          <th>PM Sign In</th>
                          <th>PM Sign Out</th>
                        </thead>
                        <tbody>
                    ';

                    if ($resultCheck2 > 0) {
                      while ($row2 = mysqli_fetch_assoc($result2)) {
                        $am_instart = strtotime($row2['am_in_start']);
                        $am_inend = strtotime($row2['am_in_end']);
                        $am_outstart = strtotime($row2['am_out_start']);
                        $am_outend = strtotime($row2['am_out_end']);
                        $pm_instart = strtotime($row2['pm_instart']);
                        $pm_inend = strtotime($row2['pm_inend']);
                        $pm_outstart = strtotime($row2['pm_outstart']);
                        $pm_outend = strtotime($row2['pm_outend']);
                        $sId = $row2['student_id'];
                        $name = $row2['name'];
                        $sect = $row2['year_section'];

                        $attId = $row2['attendance_id'];
                        $am_in = 'am_in';
                        $am_out = 'am_out';
                        $pm_in = 'pm_in';
                        $pm_out = 'pm_out';

                        echo '<tr>';
                        echo '<td>' . $sId . '</td>';
                        echo '<td>' . $name . '</td>';
                        echo '<td>' . $sect . '</td>';
                        //check if student has signed in
                        if (($row2['am_in'] == NULL) && (($currentTime > $am_instart) && ($currentTime < $am_inend))) {
                          echo '<td class="dt-center">';
                          echo '<form action="inc/edit.inc.php" method="POST">
                                  <input type="hidden" name="eId" value="'.$id.'">
                                  <input type="hidden" name="sId" value="'.$sId.'">
                                  <input type="hidden" name="aId" value="'.$attId.'">
                                  <input type="hidden" name="type" value="'.$am_in.'">
                                  <input type="hidden" name="time" value="'.$getTime.'">
                                  <button  class="w3-btn w3-blue w3-round" type="submit" name="new-attendance">Sign Out</button>
                                </form>';
                          echo '</td>';

                        } elseif ($row2['am_in'] != NULL) {
                            echo '<td class="dt-center">'.$row2['am_in'].'</td>';
                        } else {
                          echo '<td class="dt-center">Absent</td>';
                        }

                        //check if student has signed in
                        if (($row2['am_out'] == NULL) && (($currentTime > $am_outstart) && ($currentTime < $am_outend))) {
                          echo '<td class="dt-center">';
                          echo '<form action="inc/edit.inc.php" method="POST">
                                  <input type="hidden" name="eId" value="'.$id.'">
                                  <input type="hidden" name="sId" value="'.$sId.'">
                                  <input type="hidden" name="aId" value="'.$attId.'">
                                  <input type="hidden" name="type" value="'.$am_out.'">
                                  <input type="hidden" name="time" value="'.$getTime.'">
                                  <button  class="w3-btn w3-blue w3-round" type="submit" name="new-attendance">Sign Out</button>
                                </form>';
                          echo '</td>';

                        } elseif ($row2['am_out'] != NULL) {
                            echo '<td class="dt-center">'.$row2['am_out'].'</td>';
                        } else {
                          echo '<td class="dt-center">Absent</td>';
                        }

                        //check if student has signed in
                        if (($row2['pm_in'] == NULL) && (($currentTime > $pm_instart) && ($currentTime < $pm_inend))) {
                          echo '<td class="dt-center">';
                          echo '<form action="inc/edit.inc.php" method="POST">
                                  <input type="hidden" name="eId" value="'.$id.'">
                                  <input type="hidden" name="sId" value="'.$sId.'">
                                  <input type="hidden" name="aId" value="'.$attId.'">
                                  <input type="hidden" name="type" value="'.$pm_in.'">
                                  <input type="hidden" name="time" value="'.$getTime.'">
                                  <button  class="w3-btn w3-blue w3-round" type="submit" name="new-attendance">Sign In</button>
                                </form>';
                          echo '</td>';

                        } elseif ($row2['pm_in'] != NULL) {
                            echo '<td class="dt-center">'.$row2['pm_in'].'</td>';
                        } else {
                          echo '<td class="dt-center">Absent</td>';
                        }

                        //check if student has signed in
                        if (($row2['pm_out'] == NULL) && (($currentTime > $pm_outstart) && ($currentTime < $pm_outend))) {
                          echo '<td class="dt-center">';
                          echo '<form action="inc/edit.inc.php" method="POST">
                                  <input type="hidden" name="eId" value="'.$id.'">
                                  <input type="hidden" name="sId" value="'.$sId.'">
                                  <input type="hidden" name="aId" value="'.$attId.'">
                                  <input type="hidden" name="type" value="'.$pm_out.'">
                                  <input type="hidden" name="time" value="'.$getTime.'">
                                  <button  class="w3-btn w3-blue w3-round" type="submit" name="new-attendance">Sign Out</button>
                                </form>';
                          echo '</td>';

                        } elseif ($row2['pm_out'] != NULL) {
                            echo '<td class="dt-center">'.$row2['pm_out'].'</td>';
                        } else {
                          echo '<td class="dt-center">Absent</td>';
                        }

                        echo '</tr>';

                      } //end loop
                    } //end resultcheck
                    echo '</tbody></table>';
                  } //end loop
                } //end resultcheck
              } else {
                echo '<table class="w3-table">
                  <thead class="w3-blue">
                    <th>Date</th>
                    <th>AM Sign In</th>
                    <th>AM Sign Out</th>
                    <th>PM Sign In</th>
                    <th>PM Sign Out</th>
                  </thead>
                <tbody>';
                $sId = $_SESSION['uid'];
                $stSql = "SELECT DISTINCT a.date FROM sbo.student_attendance sa
                          JOIN sbo.attendance a
                            ON sa.att_id = a.attendance_id
                          JOIN sbo.events e
                            ON a.event_id = e.event_id
                          where a.event_id = ?;";
                $stStmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stStmt, $stSql)) {
                  header("Location: test_event_details.php?error=sql");
                  exit();
                } else {
                  mysqli_stmt_bind_param($stStmt, "s", $id);
                  mysqli_stmt_execute($stStmt);
                  $resultSt = mysqli_stmt_get_result($stStmt);
                  $resultCheckSt = mysqli_num_rows($resultSt);
                  if($resultCheckSt > 0) {
                    while ($rowSt = mysqli_fetch_assoc($resultSt)) {
                      $date = $rowSt['date'];
                      $stSql2 = "SELECT
                                    a.date,
                                    sa.am_in,
                                    sa.am_out,
                                    sa.pm_in,
                                    sa.pm_out
                                  FROM student_attendance sa
	                                JOIN attendance a
		                                 ON a.attendance_id = sa.att_id
	                                WHERE a.event_id = ? AND sa.student_id = ?;";
                      $stStmt2 = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($stStmt2, $stSql2)) {
                        header("Location: test_section.php?error=sql");
                        exit();
                      } else {
                        mysqli_stmt_bind_param($stStmt2, "ss", $id, $sId);
                        mysqli_stmt_execute($stStmt2);
                        $resultSt2 = mysqli_stmt_get_result($stStmt2);
                        $resultCheckSt2 = mysqli_num_rows($resultSt2);
                        if ($resultCheckSt2 > 0) {
                          // code...
                          while ($rowSt2 = mysqli_fetch_assoc($resultSt2)) {
                            // code...
                            echo '<tr>
                              <td>'.$rowSt2['date'].'</td>';

                            if ($rowSt2['am_in'] == NULL) {
                              echo '<td>ABSENT</td>';
                            } else {
                              echo $rowSt2['am_in'];
                            }

                            if ($rowSt2['am_out'] == NULL) {
                              echo '<td>ABSENT</td>';
                            } else {
                              echo $rowSt2['am_out'];
                            }

                            if ($rowSt2['pm_in'] == NULL) {
                              echo '<td>ABSENT</td>';
                            } else {
                              echo $rowSt2['pm_in'];
                            }

                            if ($rowSt2['pm_out'] == NULL) {
                              echo '<td>ABSENT</td>';
                            } else {
                              echo $rowSt2['pm_out'];
                            }

                            echo '</tr>';


                          } //end inner populate array loop
                        } //end inner result check for student view
                      } //end inner check connection for student view
                    } //end populate array loop for  student view
                  } //end check result for student view
                } //end chceck connection for student view
                echo '</tbody>
              </table>';
              } //for students view
              ?>
        </div>
      </div>

      <!--
        check if user != student
        add attendance modal source code
      -->
      <?php if ($_SESSION['utype'] != 4): ?>
        <!-- modal -->
        <div id="subscribe" class="w3-modal">
          <div class="w3-modal-content w3-animate-zoom w3-padding-large">
          <div class="w3-container w3-white w3-center">
            <i onclick="document.getElementById('subscribe').style.display='none'" class="fa fa-remove w3-button w3-xlarge w3-right w3-transparent"></i>

            <h2 class="w3-wide">ADD NEW ATTENDANCE</h2>
            <p>Please provide the necessary information type to start monitoring the attendance.</p>

              <form class="" action="inc/insert.inc.php" method="post">
                  <p><input class="w3-input w3-border" type="hidden" value="<?php echo $id;?>" ></p>
                  <p> AM <input type="checkbox" class="w3-check" name="" value=""> PM <input type="checkbox" class="w3-check" name="" value=""> </p>

					<div class="w3-container">
					<div class="w3-row w3-large">
					  <div class="w3-col s6">
						<p><h5>AM Sign In</h5></p>
						<p> Start <input class="w3-input w3-border" type="time" name="" value=""> </p>
						<p> End <input class="w3-input w3-border" type="time" name="" value=""> </p>
					  </div>

					  <div class="w3-col s6">
						 <p><h5>AM Sign Out</h5></p>
						 <p> Start <input class="w3-input w3-border" type="time" name="" value=""> </p>
						 <p> End <input class="w3-input w3-border" type="time" name="" value=""> </p>
					  </div>
					</div>

					  <div class="w3-row w3-large">
					  <div class="w3-col s6">
						<p><h5>PM Sign In</h5></p>
						<p> Start <input class="w3-input w3-border" type="time" name="" value=""> </p>
						<p> End <input class="w3-input w3-border" type="time" name="" value=""> </p>
					  </div>

					  <div class="w3-col s6">
						 <p><h5>PM Sign Out</h5></p>
						 <p> Start <input class="w3-input w3-border" type="time" name="" value=""> </p>
						 <p> End <input class="w3-input w3-border" type="time" name="" value=""> </p>
					  </div>
					</div>
					</div>
		  <div class="w3-container w3-white w3-right">
            <button type="submit" class="w3-button w3-padding-large w3-blue w3-margin-bottom w3-round" onclick="document.getElementById('subscribe').style.display='none'" name="addAttendance">Save</button>
          </div>
          </div>

          </form>
          </div>
        </div>

        <!-- modal -->
      <?php endif; ?>





    </div> <!-- !PAGE CONTENT! -->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

  <script>
    $(document).ready( function () {
      $('#table1').DataTable();
    } );
    $(document).ready( function () {
      $('#table2').DataTable();
    } );
    $(document).ready( function () {
      $('#table3').DataTable();
    } );
    $(document).ready( function () {
      $('#table4').DataTable();
    } );
    $(document).ready( function () {
      $('#table5').DataTable();
    } );
    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
      if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
      } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
      }
    }

    // Close the sidebar with the close button
    function w3_close() {
      mySidebar.style.display = "none";
      overlayBg.style.display = "none";
    }
  </script>

  </body>
</html>
