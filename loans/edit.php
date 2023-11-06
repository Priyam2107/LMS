<?php


include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/loan.php");


if (isset($_GET['id']) && $_GET['id'] > 0) {
  $loan = getLoanByID($conn, $_GET['id']);
  if ($loan->num_rows > 0) {
    $loan = $loan->fetch_assoc();
    // echo "<pre>";
    // print_r($loan);
    // exit;
  } else {
    header("LOCATION: " . BASE_URL . "loans");
    exit;
  }
}

//Update Loan Functionality 
if (isset($_POST['submit'])) {
  $res = updateBookLoan($conn, $_POST);
  if (isset($res['success'])) {
    $_SESSION['success'] = "Book Loan has been updated successfully";
    header("LOCATION:" . BASE_URL . "loans");
    exit;
  } else {
    $_SESSION['error'] = $res['error'];
    header("LOCATION:" . BASE_URL . "loans/edit.php");
    exit;
  }
}


include_once(DIR_URL . "./include/header.php");
include_once(DIR_URL . "./include/topbar.php");
include_once(DIR_URL . "./include/sidebar.php");
?>

<!--Main content start-->
<main class="mt-2 pt-3">
  <div class="container-fluid">
    <!-- Cards-->
    <div class="row dashboard-counts">
      <div class="col-md-12">
        <?php
        include_once(DIR_URL . "./include/alerts.php"); ?>
        <h4 class="fw-bold text-uppercase">Edit Loan</h4>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Fill the Form
          </div>
          <div class="card-body">
            <form method="post" action="<?php echo BASE_URL; ?>loans/edit.php">
            <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <input type="hidden" value = "<?php echo $loan['id'];?>" name="id">
                    <label class="form-label">Select Book</label>
                    <select class="form-control" name="book_id">
                      <!-- <option value="">Please Select</option> -->
                      <?php
                        $books = getBooks($conn);
                        if($books->num_rows>0){
                          while($row = $books->fetch_assoc()) {
                            $selected = "";
                            if($row['id'] == $loan['book_id'])
                            {
                              $selected = "selected";
                            }
                            echo "<option ".$selected.  " value='".$row['id']."'>".$row['title']."</option>";
                          }
                        }
                      ?>
                      
                    </select>
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Select Student</label>
                    <select class="form-control" name="student_id">
                      <!-- <option value="">Please Select</option> -->
                      <?php
                        $students = getStudents($conn);
                        if($students->num_rows>0){
                          while($row = $students->fetch_assoc()) {
                            $selected = "";
                            if($row['id'] == $loan['student_id'])
                            {
                              $selected = "selected";
                            }
                            echo "<option ".$selected. " value='".$row['id']."'>".$row['name']."</option>";
                          }
                        }
                      ?>
                    </select>
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Loan Date </label>
                    <input value= "<?php echo $loan['loan_date']; ?>" type="date" name="loan_date" class="form-control" required>
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Return/Due Date </label>
                    <input value = "<?php echo $loan['return_date']; ?>" type="date" name="return_date" class="form-control" required>
                    </label>
                  </div>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="submit" class="btn btn-success">Update</button>
                  <a href="<?php echo BASE_URL?>loans" class="btn btn-secondary">Back</a>
                </div>

              </div>



            </form>
          </div>
        </div>
      </div>
    </div>
</main>
<!--Main content end-->

<?php include_once(DIR_URL . "./include/footer.php"); ?>