<?php
  require 'inc/db.inc.php';
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
  <body class="w3-light-grey">
    <?php
      include 'header.php';
      if ($_SESSION['logged_in'] != TRUE) {
        header("Location: event.php?error=invader");
        exit();
      } elseif ($_SESSION['utype'] == 4) {
        header("Location: event.php?error=invader");
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
          <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
        </div>
      </div>
      <hr>
      <div class="w3-container">
        <h5>Dashboard</h5>
      </div>
      <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
        <a href="event.php" class="w3-bar-item w3-button w3-padding "><i class="fas fa-calendar-week"></i>  Events</a>
        <a href="student_list.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Students</a>
        <a href="section.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Sections</a>
        <a href="inc/logout.inc.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-sign-out-alt fa-fw"></i>  Logout</a><br><br>
      </div>
    </nav> <!--Sidebar/menu -->

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <!-- Header -->
      <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Student</b></h5>
      </header> <!-- Header -->


      <!-- content here -->


      <div class="w3-container  w3-margin-bottom" style="width: 80%; margin-left: 1em;">
        <div class="w3-container">
          <!--
            check if user != student
            display attendance table
          -->
          <?php if ($_SESSION['utype'] != 4): ?>
            <div class="w3-col m2">
              <button onclick="document.getElementById('subscribe').style.display='block'" type="button" name="button" class="w3-btn w3-blue w3-round">Register Student</button>
            </div>
          <?php endif; ?>

          <!-- student table -->
          <table id="table" class="display">
            <thead>
              <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Year and Section</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Year and Section</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                $sql = "SELECT
                          s.student_id,
                          concat(s.last_name, ', ', s.first_name) as name,
                          CONCAT(se.year,se.section) as year_section
                        FROM student s
                        join section se
                          on s.section_id = se.section_id";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    //$dateEvent = date('M d Y', strtotime($row['start_date']));
                    echo '<tr>';
                    echo '<td><a href="student_profile.php?id='. $row['student_id'].'">';
                    echo $row['student_id']. '</a></td>';
                    echo '<td>'. $row['name'] .'</td>';
                    echo '<td>'. $row['year_section'] . '</td>';
                    echo '</tr>';
                  }
                }
              ?>
            </tbody>
          </table> <!-- student table -->
        </div>
      </div>

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


      <!-- content here -->


      <!-- Footer -->
      <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
      </footer>

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
