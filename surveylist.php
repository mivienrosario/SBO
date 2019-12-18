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
        <a href="surveylist.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fas fa-poll"></i>  Surveys</a>
        <?php if ($_SESSION['utype'] != 4): ?>
        <a href="studentlist.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Students</a>
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
			    <li class="breadcrumb-item"><i class="fas fa-poll"></i>  Surveys</li>
        </ul>
      </div>



      <!-- content here -->


      <div class="w3-container  w3-margin-bottom" style="width: 80%; margin-left: 1em;">
        <!-- Header -->
        <header class="w3-container" style="padding-top:22px">
          <h1>Survey List</h1>
        </header> <!-- Header -->
        <div class="w3-container">
          <!--
            check if user != student
            display attendance table
          -->
          <?php if ($_SESSION['utype'] != 4&3): ?>
            <div class="w3-col w3-right-align">
              <button onclick="document.getElementById('subscribe').style.display='block'" type="button" name="button" class="w3-btn w3-blue w3-round" style="margin-bottom: 0.5em;"><i class="fas fa-plus"></i>   New Survey</button>
            </div>
          <?php endif; ?>

          <!-- student table -->
          <table id="table" class="display">
            <thead>
              <tr>
                <th>Title</th>
                <th>Event</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT * FROM sbo.survey s
                          JOIN sbo.events e
                            ON s.eventid = e.event_id;
                      ";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    //$dateEvent = date('M d Y', strtotime($row['start_date']));
                    echo '<tr>';
                    echo '<td>'; echo $row['surveytitle']; echo '</td>';
                    echo '<td>'; echo $row['title']; echo '</td>';
                    echo '<td class="w3-center">';
                    ?>
                    <?php if ($_SESSION['utype'] != 4&3): ?>
                      <button onclick="document.getElementById('editSurvey').style.display='block'" type="button" name="button" class="w3-btn w3-blue w3-round"><i class="fas fa-edit"></i>   Edit</button>
                    <?php endif; ?>
                    <?php
                    echo '<a href="surveydetails.php?id='.$row['surveyid'].'" style="text-decoration: none;"><button class="w3-btn w3-blue w3-round"><i class="fas fa-eye"></i>   View</a></button></td>';
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
