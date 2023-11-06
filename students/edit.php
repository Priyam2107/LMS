<?php


include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/student.php");


if(isset($_GET['id']) && $_GET['id'] > 0)
{
    $student = getStudentByID($conn, $_GET['id']);
    if($student->num_rows > 0) {
        $student = $student->fetch_assoc(); 
    }else{
        header("LOCATION: ".BASE_URL."students");
        exit;
    }
}

//Update Student Functionality 
if (isset($_POST['update'])) {
    $res = updateStudent($conn, $_POST);
    if (isset($res['success'])) {
        $_SESSION['success'] = "Student has been updated successfully";
        header("LOCATION:" . BASE_URL . "students");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
        header("LOCATION:" . BASE_URL . "students/edit.php");
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
                <h4 class="fw-bold text-uppercase">Edit Student</h4>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Fill the Form
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL; ?>students/edit.php">
                        <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input value="<?php echo $student['id'] ?>"  type="hidden" class="form-control"  name="id">
                    <input value="<?php echo $student['name'] ?>"  type="text" class="form-control"  name="name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label  class="form-label">Email</label>
                    <input value="<?php echo $student['email'] ?>" type="email" class="form-control" name="email">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label  class="form-label">Phone No</label>
                    <input value="<?php echo $student['phone_no'] ?>" type="text" class="form-control" name="phone_no" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label  class="form-label">Address</label>
                    <input value="<?php echo $student['address'] ?>" type="text" class="form-control" name="address">
                  </div>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="update" class="btn btn-success">Update</button>
                  <a href= "<?php BASE_URL?>students" class="btn btn-secondary">Cancel</a>
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