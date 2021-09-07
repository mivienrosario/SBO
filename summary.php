<?php
  require 'inc/db.inc.php';
  $studentTable = '<table class="w3-table">
    <thead class="w3-blue">
    <tr>
        <th>Event Title</th>
      <th>Date</th>
      <th>AM Sign In</th>
      <th>AM Sign Out</th>
      <th>PM Sign In</th>
      <th>PM Sign Out</th>
      <th>Count of Absences</th>
      <th>CS Hours</th>
      </tr>
    </thead>
  <tbody class="w3-white">';
  include_once 'head.php';
?>

  <body class="w3-light-grey">
    <?php
      include 'header.php';
      if ($_SESSION['logged_in'] != TRUE) {
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
          <a href="profile.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
          <a href="account.php" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
        </div>
      </div>
      <hr>
      <div class="w3-container">
        <h5>Dashboard</h5>
      </div>
      <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
        <a href="event.php" class="w3-bar-item w3-button w3-padding "><i class="fas fa-calendar-week"></i>  Events</a>
        <a href="surveylist.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-poll"></i>  Surveys</a>
        <a href="summary.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fas fa-file-contract"></i></i>  Summary</a>
        <?php if ($_SESSION['utype'] != 4): ?>
            <a href="users.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-users"></i>  Users </a>
            <a href="studentlist.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-user-graduate"></i>  Students</a>
            <a href="section.php" class="w3-bar-item w3-button w3-padding "><i class="fa fa-bullseye fa-fw"></i>  Sections</a>
        <?php endif; ?>
        <a href="inc/logout.inc.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-sign-out-alt fa-fw"></i>  Logout</a><br><br>
      </div>
    </nav> <!--Sidebar/menu -->

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <div class="w3-container">
		    <ul class="breadcrumb">
			    <li class="breadcrumb-item"><i class="fas fa-file-contract"></i></i>  Summary</li>
        </ul>
      </div>

      <!-- content here -->
      <div class="w3-container  w3-margin-bottom" style="width: 80%; margin-left: 1em;">
        <!-- Header -->
        <header class="w3-container" style="padding-top:22px">
        </header> <!-- Header -->
        <div class="w3-container">
          <!-- check if user != student display attendance table -->
          <?php if ($_SESSION['utype'] != 4): ?>

          <?php endif; ?>

          <!-- student table -->
              <?php
              //if student
              $totalAbsent = 0;
              $totalAttendance = 0;
               echo $studentTable;
               $sId = $_SESSION['uid'];
               $stSql2 = "SELECT * FROM sbo.get_attendance_st g
	                            JOIN sbo.events e
		                        on e.event_id = g.event_id
                             WHERE student_id = ? ORDER BY date DESC";
               $stStmt2 = mysqli_stmt_init($conn);
               if (!mysqli_stmt_prepare($stStmt2, $stSql2)) {
                 header("Location: summary.php?error=sql");
                 exit();
               } else {
                 mysqli_stmt_bind_param($stStmt2, "s", $sId);
                 mysqli_stmt_execute($stStmt2);
                 $resultSt2 = mysqli_stmt_get_result($stStmt2);
                 $resultCheckSt2 = mysqli_num_rows($resultSt2);
                 if ($resultCheckSt2 > 0) {
                   while ($rowSt2 = mysqli_fetch_assoc($resultSt2)) {
                     echo '<tr>';
                     echo '<td>' . $rowSt2['title'] . '</td>';
                     echo '<td>'.$rowSt2['date'].'</td>';

                     if ($rowSt2['am_in'] == NULL) {
                       echo '<td>ABSENT</td>';
                       $totalAttendance += 1;
                       $totalAbsent += 1;
                     } else {
                       echo $rowSt2['am_in'];
                     }

                     if ($rowSt2['am_out'] == NULL) {
                       echo '<td>ABSENT</td>';
                       $totalAttendance += 1;
                       $totalAbsent += 1;
                     } else {
                       echo $rowSt2['am_out'];
                     }

                     if ($rowSt2['pm_in'] == NULL) {
                       echo '<td>ABSENT</td>';
                       $totalAttendance += 1;
                       $totalAbsent += 1;
                     } else {
                       echo $rowSt2['pm_in'];
                     }

                     if ($rowSt2['pm_out'] == NULL) {
                       echo '<td>ABSENT</td>';
                       $totalAttendance += 1;
                       $totalAbsent += 1;
                     } else {
                       echo $rowSt2['pm_out'];
                     }

                     echo '<td>';
                     echo $totalAttendance;
                     echo '</td>';

                     echo '</tr>';
                     $totalAttendance = 0;

                   } //end print time/absent
                 }//end check result
               }
               ?>
                 <tr>
                     <td>TOTAL</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td><?php echo $totalAbsent; ?></td>
                     <td></td>
                 </tr>
               <?php
               echo '</tbody></table>';
              ?>
            </tbody>
          </table> <!-- student table -->
        </div>
      </div>

      <?php if ($_SESSION['utype'] != 4): ?>
        <!-- modal -->

        <!-- modal -->
      <?php endif; ?>


      <!-- content here -->

    </div> <!-- !PAGE CONTENT! -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>


  <script>
    $(document).ready( function () {
      $('#table').DataTable();
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
