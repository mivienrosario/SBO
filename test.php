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

if ($_SESSION['utype'] != 4):  ?>
  <?php
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
        echo '<table id="';
          for($i=0; $i < $resultCheck2; $i++){
            echo $table[$i];
          }
        echo '" class="display">
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

  else: //for students view
    ?>
      <table class="w3-table">
        <thead>
          <th>Date</th>
          <th>AM Sign In</th>
          <th>AM Sign Out</th>
          <th>PM Sign In</th>
          <th>PM Sign Out</th>
        </thead>
      <tbody>
    <?php
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


                }
              }
            }
          }
        }
      }
  ?>
    </tbody>
  </table>
<?php endif; //display if user != student ?>
