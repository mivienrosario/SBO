<?php
  require 'inc/db.inc.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Test Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-ios.css">
    <link rel="stylesheet" href="src/css/breadcrumb.css">
    <link rel="stylesheet" href="src/css/body.css">
    <script src="https://kit.fontawesome.com/e1f7070413.js" crossorigin="anonymous"></script>
  </head>
  <body class="w3-light-grey">
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
          <a href="profile.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
          <a href="account.php" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
        </div>
      </div>
      <hr>
      <div class="w3-container">
        <h5>Event List</h5>
      </div>
      <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
        <a href="event.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fas fa-calendar-week"></i>  Events</a>
        <a href="surveylist.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-poll"></i>  Surveys</a>
        <?php if ($_SESSION['utype'] != 4): ?>
        <a href="studentlist.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Students</a>
        <a href="section.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Sections</a>
        <?php endif; ?>

        <a href="inc/logout.inc.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-sign-out-alt fa-fw"></i>  Logout</a><br><br>
      </div>
    </nav> <!-- Sidebar/menu -->

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <div class="w3-container">
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><i class="fas fa-calendar-week"></i>  Events</li>
        </ul>
      </div>


      <div class="w3-container  w3-margin-bottom" style="width: 80%; margin-left: 1em;">
        <div class="w3-cell-row">
          <div class="w3-container w3-cell w3-mobile w3-red" style="width: 90%;">
            <!-- Header -->
            <header class="w3-container">
              <h1>Events List</h1>
            </header> <!-- Header -->
          </div>

          <div class="w3-container w3-cell w3-mobile w3-green w3-cell-middle">
            <!-- show if admin/attendance officer-->
            <?php if (($_SESSION['utype'] == 1) || ($_SESSION['utype'] == 2)): ?>
                <button onclick="document.getElementById('addEvent').style.display='block'" type="button" name="button" class="w3-btn w3-blue w3-round ">Add Event</button>
            <?php endif; ?>
          </div>
        </div>

        <div class="w3-card">
          <header class="w3-container"><h1>Event 1</h1></header>

        </div>








        <!--
        <div class="w3-card-2">
          <header class="w3-container w3-blue">
            <h1>Header</h1>
          </header>
          <div class="w3-container">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          </div>
          <footer class="w3-container w3-blue">
            <h5>footer</h5>
          </footer>
        </div> -->

      </div>


      <!-- modal -->
      <div id="addEvent" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom w3-padding-large">
        <div class="w3-container w3-white w3-center">
          <span onclick="document.getElementById('addEvent').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>
          <h2 class="w3-wide w3-text-blue">ADD NEW EVENT</h2>
          <p>Please provide the necessary information type to add a new event.</p>
          <form class="" action="inc/insert.inc.php" method="post">
				    <p>Event Title <input type="text" class="w3-input w3-border" name="title"></p>
				    <p>Description <textarea rows="2" col="40" class="w3-input" name="description" ></textarea></p>
				    <p>Start Date <input type="date" class="w3-input w3-border" name="start"></p>
				    <p>End Date <input type="date" class="w3-input w3-border" name="end"></p>

        <div class="w3-container w3-white w3-right">
          <button type="submit" class="w3-button w3-padding-large w3-blue w3-margin-bottom w3-round " onclick="document.getElementById('addEvent').style.display='none'" name="add-event">Save</button>
        </div>
      </form>
        </div>
        </div>
      </div>

      <!-- modal -->

    </div> <!-- !PAGE CONTENT! -->


  <script>
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
