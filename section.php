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
    <link rel="stylesheet" href="src/css/breadcrumb.css">
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
        <?php if ($_SESSION['utype'] != 4): ?>
        <a href="studentlist.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Students</a>
        <a href="section.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-bullseye fa-fw"></i>  Sections</a>
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
			    <li class="breadcrumb-item"><i class="fa fa-bullseye fa-fw"></i>   Section</li>
        </ul>
      </div>

      <!-- content here -->

      <div class="w3-container  w3-margin-bottom" style="width: 80%; margin-left: 1em;">
        <!-- Header -->
        <header class="w3-container" style="padding-top:22px">
          <h1>Section List</h1>

        </header> <!-- Header -->
        <div class="w3-container">
          <!-- student table -->

              <?php
                $sql = "SELECT section_id, concat(year,section) as year_section FROM sbo.section;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                $index = 0;
                $table = array("table1", "table2", "table3", "table4", "table5", "table5", "table6", "table7", "table8", "table9", "table10");
                if ($resultCheck > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $section = $row['section_id'];
                    $yrsect = $row['year_section'];
                    echo '<h3 id="'.$yrsect.'">' . $yrsect . '</h3>';
                    echo '
                    <table id="'.$table[$index].'" class="display">
                      <thead>
                        <tr class="">
                          <th>Student ID</th>
                          <th>Name</th>
                          <th>Year and Section</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                    ';

                    $sql = "SELECT
    	                         s.student_id,
                               concat(s.last_name, ', ', s.first_name) as name,
    	                         CONCAT(se.year,se.section) as year_section
                            FROM sbo.section se
    	                      join student s
    		                      on s.section_id = se.section_id
                            WHERE se.section_id = ?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                      header("Location: test_section.php?error=sql");
                      exit();
                    } else {
                      mysqli_stmt_bind_param($stmt, "s", $section);
                      mysqli_stmt_execute($stmt);
                      $result2 = mysqli_stmt_get_result($stmt);
                      $resultCheck2 = mysqli_num_rows($result2);
                      if($resultCheck2 > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                          echo '<tr class="w3-white">';
                          echo '<td><a href="profile.php?id='.$row2['student_id'].'">';
                          echo $row2['student_id'].'</a></td>';
                          echo '<td>'. $row2['name'] .'</td>';
                          echo '<td class="w3-center">'. $row2['year_section'] . '</td>';
                          echo '<td class="w3-center">';
                          ?>
                          <?php if ($_SESSION['utype'] != 4&3): ?>
                            <button class="w3-btn w3-blue w3-round"><i class="fas fa-edit"></i> <a href="profile.php?id=<?php echo $row2['student_id']; ?>" style="text-decoration: none;">Edit</a>  </button>
                            <button class="w3-btn w3-blue w3-round"><i class="fas fa-eye"></i>   View</button>
                          <?php endif; ?>
                          <?php
                          echo '</td>';
                          echo '</tr>';
                        }
                      }
                    }
                    /*
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);

                    if ($resultCheck > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {

                        echo '<tr>';
                        echo '<td><a href="student_profile.php?id='. $row['student_id'].'">';
                        echo $row['student_id']. '</a></td>';
                        echo '<td>'. $row['name'] .'</td>';
                        echo '<td>'. $row['year_section'] . '</td>';
                        echo '</tr>';


                      } //end second query result
                    } //end second query
                    */

                    echo '
                        </tbody>
                      </table>
                      ';
                      $index++;
                  } //end first query result
                } //end first query


              ?>
        </div>
      </div>


      <!-- content here -->
      <!-- modal -->
      <div id="editSection" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom w3-padding-large">
        <div class="w3-container w3-white w3-center">
          <span onclick="document.getElementById('editSection').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>
          <h2 class="w3-wide w3-text-blue">UPDATE STUDENT'S SECTION</h2>
          <p>Please select the new year and section of the student.</p>
          <form class="" action="inc/edit.inc.php" method="post">
            <select class="w3-input" name="yrsect" style="margin-bottom: 0.5em;">
              <?php
                $sql = "SELECT section_id, concat(year, section) as yr_sect FROM section;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row['section_id'].'">'.$row['yr_sect'].'</option>';
                  }
                }

              ?>

            </select>
        <div class="w3-container w3-white w3-right">
          <button type="submit" class="w3-button w3-padding-large w3-blue w3-margin-bottom w3-round " onclick="document.getElementById('editSection').style.display='none'" name="student-section-update">Save</button>
        </div>
      </form>
        </div>
        </div>
      </div>

      <!-- modal -->

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
    $(document).ready( function () {
      $('#table6').DataTable();
    } );
    $(document).ready( function () {
      $('#table7').DataTable();
    } );
    $(document).ready( function () {
      $('#table8').DataTable();
    } );
    $(document).ready( function () {
      $('#table9').DataTable();
    } );
    $(document).ready( function () {
      $('#table10').DataTable();
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
