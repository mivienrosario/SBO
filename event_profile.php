<?php
include 'inc/db.inc.php';
  $evId = $_GET['id'];
  $sql = "SELECT * FROM sbo.events WHERE event_id = $evId;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);

  if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $title = $row['title'];
      $dateCr = $row['create_date'];
      $dateSt = $row['start_date'];
      $dateEnd = $row['end_date'];
      $desc = $row['description'];
    }
  } else if(empty($resultCheck)) {
    echo 'No results found.<br>';
  }

  $today = date('Y-m-d');

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" href="src/css/master.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  </head>
  <body>
    <div class="main-wrapper">
      <div class="sidenav">
        <?php
          include 'sidenav.php';
          date_default_timezone_set('Asia/Singapore');
          $currentTime = strtotime(date('H:i'));

        ?>
      </div>

      <div class="content-wrapper">
        <ul class="breadcrumb w3-green">
         <li><a href="welcome.php">Events</a></li>
         <li><a href="event_list.php">Events List</a></li>
         <li>CIT Night</li>
        </ul>

        <!--
          Modal buttons must be outside a form
          to avoid the modal from auto closing.
        -->
        <div class="w3-container">
          <div class="w3-row">
            <div class="w3-col">
              <h2><?php echo $title; ?></h2>
            </div>
            <div class="w3-col">
              <!-- edit event modal button-->
              <button onclick="document.getElementById('eventModal').style.display='block'" class="float-right w3-button w3-blue">Edit Event</button>
            </div>

          </div>

        </div>
        <div class="w3-container">
          <table class="w3-table">
            <tr>
              <td>Start of Event</td>
              <td><?php echo $dateSt; ?></td>
            </tr>
            <tr>
              <td>End of Event</td>
              <td><?php echo $dateEnd; ?></td>
            </tr>
            <tr>
              <td>Description</td>
              <td><?php echo $desc; ?></td>
            </tr>
          </table>

          <h2>Attendance</h2>
          <!-- add new attendance modal button-->
          <button onclick="document.getElementById('attendanceModal').style.display='block'" class="float-right w3-button w3-blue">Add Attendance</button>

          <form class="" action="" method="post">
            <select class="" name="attDate">
              <option selected>Select Date</option>
              <?php
                $sql = "SELECT DISTINCT a.date FROM sbo.student_attendance sa
                        	JOIN sbo.attendance a
                        		ON sa.att_id = a.attendance_id
                        	JOIN sbo.events e
                        		ON a.event_id = e.event_id
                        	where a.event_id = $evId;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['date'];
                    echo '">';
                    echo $row['date'];
                    echo '</option>';
                  }
                }
              ?>
            </select>
            <button type="submit" name="selectAttDate">Select Date</button>
          </form>
          <!-- edit attendance modal button-->
          <button onclick="document.getElementById('amModal').style.display='block'" class="float-right w3-button w3-blue">Edit</button>

          <?php
            if (isset($_POST['selectAttDate'])) {
              $sql = "SELECT
                            concat(s.last_name, ', ', s.first_name) as name,
                            concat(se.year, se.section) as year_section,
                            sa.am_in,
                            sa.am_out,
                            sa.pm_in,
                            sa.pm_out,
                            a.event_id,
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
                      WHERE a.event_id = $evId;";

              $result = mysqli_query($conn, $sql);
              $resultCheck = mysqli_num_rows($result);
              echo '
                <table id="attendance" class="display">
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

              if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $am_instart = strtotime($row['am_in_start']);
                  $am_inend = strtotime($row['am_in_end']);
                  $am_outstart = strtotime($row['am_out_start']);
                  $am_outend = strtotime($row['am_out_end']);
                  $pm_instart = strtotime($row['pm_instart']);
                  $pm_inend = strtotime($row['pm_inend']);
                  $pm_outstart = strtotime($row['pm_outstart']);
                  $pm_outend = strtotime($row['pm_outend']);
                  $sId = $row['student_id'];
                  $name = $row['name'];
                  $sect = $row['year_section'];

                  echo '<tr>';
                  echo '<td>' . $sId . '</td>';
                  echo '<td>' . $name . '</td>';
                  echo '<td>' . $sect . '</td>';
                  //check if student has signed in
                  if (($row['am_in'] == NULL) && (($currentTime > $am_instart) && ($currentTime < $am_inend))) {
                    echo '<td class="dt-center">';
                    echo '<a href="inc/edit.inc.php?add='.$currentTime.'&sId='.$sId.'&eId='.$evId.'">';
                    echo 'Sign In</a>';
                    echo '</td>';
                  //} elseif (($row['sign_in'] == NULL) && ($currentTime < )) {
                    // code...
                  } else {
                    echo '<td class="dt-center">Absent</td>';
                  }

                  //check if student has signed in
                  if (($row['am_out'] == NULL) && (($currentTime > $am_outstart) && ($currentTime < $am_outend))) {
                    echo '<td>Sign Out</td>';
                  //} elseif (($row['sign_in'] == NULL) && ($currentTime < )) {
                    // code...
                  } else {
                    echo '<td class="dt-center">Absent</td>';
                  }

                  //check if student has signed in
                  if (($row['pm_in'] == NULL) && (($currentTime > $pm_instart) && ($currentTime < $pm_inend))) {
                    echo '<td class="dt-center">';
                    echo '<a href="inc/edit.inc.php?add='.$currentTime.'&sId='.$sId.'&eId='.$evId.'">';
                    echo 'Sign In</a>';
                    echo '</td>';
                  //} elseif (($row['sign_in'] == NULL) && ($currentTime < )) {
                    // code...
                  } else {
                    echo '<td class="dt-center">Absent</td>';
                  }

                  //check if student has signed in
                  if (($row['pm_out'] == NULL) && (($currentTime > $pm_outstart) && ($currentTime < $pm_outend))) {
                    echo '<td>Sign Out</td>';
                  //} elseif (($row['sign_in'] == NULL) && ($currentTime < )) {
                    // code...
                  } else {
                    echo '<td class="dt-center">Absent</td>';
                  }

                  echo '</tr>';

                } //end loop
              } //end resultcheck
            } //end if isset
          ?>



   <!-- attendance table -->

        </div>



        <!--
          Edit Event modal
          Depending on the decision, the schema may still be subject
          to change and remove the Start and End date of an Event.

        -->
        <div id="eventModal" class="w3-modal">
          <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-teal">
              <span onclick="document.getElementById('eventModal').style.display='none'"
              class="w3-button w3-display-topright">&times;</span>
              <h2>Edit Event</h2>
            </header>
            <div class="w3-container">
              <form class="w3-container" action="inc/edit.inc.php" method="post">
                <input type="text" name="id" value="<?php echo $evId; ?>">
                <p>
                  <label>Event Title</label></p>
                  <input type="text" class="w3-input" name="title" required>
                </p>
                <p>
                  <label>Description</label></p>
                  <input type="text" class="w3-input" name="desc" required>
                </p>
                <p>
                  <label>Start Date</label>
                  <input type="date" name="start">
                </p>
                <p>
                  <label>End Date</label>
                  <input type="date" name="end">
                </p>
                <p>
                  <button class="w3-btn" type="submit" name="edit-event">Save</button>
                </p>
              </form>
            </div>
            <footer class="w3-container w3-teal">

            </footer>
          </div>
        </div> <!-- Edit Event modal -->

        <!-- Add Attendance modal -->
        <div id="attendanceModal" class="w3-modal">
          <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-teal">
              <span onclick="document.getElementById('attendanceModal').style.display='none'"
              class="w3-button w3-display-topright">&times;</span>
              <h2>Add Attendance</h2>
            </header>
            <div class="w3-container">
              <form class="w3-container" action="inc/insert.inc.php" method="post">
                <p>
                  <input type="text" name="eventId" value="<?php echo $evId; ?>" hidden>
                  <input type="date" name="date">
                </p>
                <p>
                  <label>Select Attendance Type</label>
                  <select name="type">
                    <option value="morning">AM</option>
                    <option value="afternoon">PM</option>
                  </select>
                </p>
                <!--
                  Alternative solution
                    1. Create a script where the system generates
                        limited selection of attendance period according
                        to the attendance type (i.e. if the officer selects
                        AM for the type, the system will only limit the option
                        to blablablablabla)
                    2. Or hard code it.
                -->
                <p>
                  <label>Start Time</label></p>
                  <input type="time" name="start" class="w3-input">
                </p>
                <p>
                  <label>End Time</label></p>
                  <input type="time" name="end" class="w3-input">
                </p>
                <p>
                  <button class="w3-btn" type="submit" name="add-attendance">Save</button>
                </p>
              </form>
            </div>
            <footer class="w3-container w3-teal">

            </footer>
          </div>
        </div> <!-- Add Attendance modal -->

        <!-- Add Attendance modal -->
        <div id="amModal" class="w3-modal">
          <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-teal">
              <span onclick="document.getElementById('amModal').style.display='none'"
              class="w3-button w3-display-topright">&times;</span>
              <h2>Edit Attendance - AM</h2>
            </header>
            <div class="w3-container">
              <form class="w3-container" action="inc/edit.inc.php" method="post">
                <p>
                  <input type="text" name="eventId" value="<?php echo $evId; ?>" hidden>
                  <input type="date" name="date">
                </p>
                <p>
                  <label>Select Attendance Type</label>
                  <select name="type">
                    <option value="morning">AM</option>
                    <option value="afternoon">PM</option>
                  </select>
                </p>
                <p>
                  <label>Start Time</label></p>
                  <input type="time" name="start" class="w3-input">
                </p>
                <p>
                  <label>End Time</label></p>
                  <input type="time" name="end" class="w3-input">
                </p>
                <p>
                  <button class="w3-btn" type="submit" name="add-attendance">Save</button>
                </p>
              </form>
            </div>
            <footer class="w3-container w3-teal">

            </footer>
          </div>
        </div> <!-- Add Attendance modal -->

      </div> <!-- end content wrapper WARNING: do not add content beyond this part. -->
    </div> <!-- end main wrapper -->


   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
   <script>
     $(document).ready( function () {
       $('#morning').DataTable();
     } );

     $(document).ready( function () {
       $('#afternoon').DataTable();
     } );
     $(document).ready( function () {
       $('#attendance').DataTable();
     } );
   </script>



  </body>
</html>
