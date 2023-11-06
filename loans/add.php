<?php


include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/loan.php");




//Add Loan Functionality 
if (isset($_POST['submit'])) {
  $res = createLoan($conn, $_POST);
  if (isset($res['success'])) {
    $_SESSION['success'] = "Book Loan has been created successfully";
    header("LOCATION:" . BASE_URL . "loans");
    exit;
  } else {
    $_SESSION['error'] = $res['error'];
    header("LOCATION:" . BASE_URL . "loans/add.php");
    exit;
  }
}
include_once(DIR_URL . "./include/header.php");
include_once(DIR_URL . "./include/topbar.php");
include_once(DIR_URL . "./include/sidebar.php");
?>

<!--Main content start-->
<main class="mt-2 pt-3">
  <div class="container-fluid">;
    <!-- Cards-->
    <div class="row dashboard-counts">
      <div class="col-md-12">
        <?php
        include_once(DIR_URL . "./include/alerts.php"); ?>
        <h4 class="fw-bold text-uppercase">Add Loan</h4>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Fill the Form
          </div>
          <div class="card-body">
            <form method="post" action="<?php echo BASE_URL; ?>loans/add.php">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Select Book</label>
                    <select class="form-control" name="book_id">
                      <option value="">Please Select</option>
                      <?php
                        $books = getBooks($conn);
                        if($books->num_rows>0){
                          while($row = $books->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['title']."</option>";
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
                      <option value="">Please Select</option>
                      <?php
                        $students = getStudents($conn);
                        if($students->num_rows>0){
                          while($row = $students->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
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
                    <input type="date" name="loan_date" class="form-control" required>
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Return/Due Date </label>
                    <input type="date" name="return_date" class="form-control" required>
                    </label>
                  </div>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="submit" class="btn btn-success">Save</button>
                  <button type="reset" class="btn btn-secondary">Cancel</button>
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