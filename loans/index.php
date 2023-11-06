<?php


include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/loan.php");

//Get Loans
$loans = getLoans($conn);

//Delete Loans
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $del = deleteLoan($conn, $_GET['id']);
  if ($del) {
    $_SESSION['success'] = "Loan has been deleted successfully";
  } else {
    $_SESSION['error'] = "Something went wrong";
  }
  header("LOCATION:" . BASE_URL . "loans");
  exit;
}


//Update status of Books
if (isset($_GET['action']) && $_GET['action'] == 'status') {
  $upd = updateLoanStatus($conn, $_GET['id'], $_GET['is_return']);
  if ($_GET['status'] == 0) {
    $msg = "Student's loan is not returned";
  }
  if ($_GET['status'] == 1) {
    $msg = "Student's laon is returned";
  }
  if ($upd) {
    $_SESSION['success'] = $msg;
  } else {
    $_SESSION['error'] = "Something went wrong";
    header("LOCATION:" . BASE_URL . "loans");
  exit;
  }
  header("LOCATION:" . BASE_URL . "loans");
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
        <h4 class="fw-bold text-uppercase">Manage Loans</h4>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            All Loans
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-responsive table-striped">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Loan Date</th>
                    <th scope="col">Return Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  if ($loans->num_rows > 0) {
                    $i = 1;
                    while ($row = $loans->fetch_assoc()) {
                      echo "<tr>";
                      echo "<th scope='row'>" . $i . "</th>";
                      echo "<td>" . $row['book_title'] . "</td>";
                      echo "<td>" . $row['student_name'] . "</td>";
                      echo "<td>" . date("d-m-Y", strtotime($row['loan_date'])) . "</td>";
                      echo "<td>" . date("d-m-Y", strtotime($row['return_date'])) . "</td>";
                      echo  "<td>" ?>
                      <?php
                      if ($row['is_return'] == 1) {
                        echo '<span class="badge text-bg-success">Returned</span>';
                      } else {
                        echo '<span class="badge text-bg-danger">Active</span>';
                      }
                      ?>
                      <?php echo "</td>";
                      echo  "<td>" . date("d-m-Y h:i A", strtotime($row['created_at'])) . "</td>";
                      $i++;
                      ?>
                      <td>
                        <a href="<?php echo BASE_URL ?>loans/edit.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a onclick="return confirm('Are You Sure')" href="<?php echo BASE_URL ?>loans?action=delete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        <?php
                        if ($row['is_return'] == 0) {
                          echo "<a  href ='" . BASE_URL . "loans?action=status&id=" . $row['id'] . "&is_return=1' class='btn btn-success btn-sm'>Returned</a>";
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