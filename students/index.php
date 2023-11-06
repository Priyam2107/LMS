<?php


include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/student.php");

//Get Books
$books = getStudents($conn);

//Delete Books
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $del = deleteStudent($conn, $_GET['id']);
  if ($del) {
    $_SESSION['success'] = "Student has been deleted successfully";
  } else {
    $_SESSION['error'] = "Something went wrong";
  }
  header("LOCATION:" . BASE_URL . "students");
  exit;
}


//Update status of Books
if (isset($_GET['action']) && $_GET['action'] == 'status') {
  $upd = updateStudentStatus($conn, $_GET['id'], $_GET['status']);
  if ($_GET['status'] == 0) {
    $msg = "Student's status is deactivated";
  }
  if ($_GET['status'] == 1) {
    $msg = "Student's status is activated";
  }
  if ($upd) {
    $_SESSION['success'] = $msg;
  } else {
    $_SESSION['error'] = "Something went wrong";
  }
  header("LOCATION:" . BASE_URL . "students");
  exit;
}

include_once(DIR_URL . "./include/header.php");
include_once(DIR_URL . "./include/topbar.php");
include_once(DIR_URL . "./include/sidebar.php");
?>

<!--Main content start-->
<main class="mt-1 pt-3">
  <div class="container-fluid">
    <!-- Cards-->
    <div class="row dashboard-counts">
      <div class="col-md-12">
        <?php include(DIR_URL . "./include/alerts.php"); ?>
        <h4 class="fw-bold text-uppercase">Manage Students</h4>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            All Students
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-responsive table-striped">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone No</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  if ($books->num_rows > 0) {
                    $i = 1;
                    while ($row = $books->fetch_assoc()) {
                      echo "<tr>";
                      echo "<th scope='row'>" . $i . "</th>";
                      echo "<td>" . $row['name'] . "</td>";
                      echo "<td>" . $row['email'] . "</td>";
                      echo "<td>" . $row['phone_no'] . "</td>";
                      echo  "<td>" ?>
                      <?php
                      if ($row['status'] == 1) {
                        echo '<span class="badge text-bg-success">Active</span>';
                      } else {
                        echo '<span class="badge text-bg-danger">Inactive</span>';
                      }
                      ?>
                      <?php echo "</td>";
                      echo  "<td>" . date("d-m-Y h:i A", strtotime($row['created_at'])) . "</td>";
                      $i++;
                      ?>
                      <td>
                        <a href="<?php echo BASE_URL ?>students/edit.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a onclick="return confirm('Are You Sure')" href="<?php echo BASE_URL ?>students?action=delete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        <?php
                        if ($row['status'] == 1) {
                          echo "<a   href ='" . BASE_URL . "students?action=status&id=" . $row['id'] . "&status=0' class='btn btn-warning btn-sm'>Inactivate</a>";
                        }
                        if ($row['status'] == 0) {
                          echo "<a  href ='" . BASE_URL . "students?action=status&id=" . $row['id'] . "&status=1' class='btn btn-success btn-sm'>Activate</a>";
                        }
                        ?>
                      </td>
                      </tr>
                  <?php }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>
<!--Main content end-->

<?php include_once(DIR_URL . "./include/footer.php"); ?>