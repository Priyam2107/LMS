<?php

include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/subscription.php");


if (isset($_POST['submit'])) {
 

  if($_POST['id'] == ''){
 
  $res = storeSubscription($conn, $_POST);
  if (isset($res['success'])) {
    $_SESSION['success'] = "Subscription has been created successfully";
    header("LOCATION: " . BASE_URL . "subscriptions");
    exit;
  } else {
    $_SESSION['error'] = $res['error'];
    header("LOCATION: " . BASE_URL . "subscriptions");
    exit;
  }
}
else {
  $res = updatePlan($conn, $_POST);
  if (isset($res['success'])) {
    $_SESSION['success'] = "Plan has been updated successfully";
    header("LOCATION:" . BASE_URL . "subscriptions");
    exit;
  } else {
    $_SESSION['error'] = $res['error'];
    header("LOCATION:" . BASE_URL . "subscriptions");
    exit;
  }
}
}


// Get Loans
$plans = getPlans($conn);

//Delete Plans
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $del = deletePlan($conn, $_GET['id']);
  if ($del) {
    $_SESSION['success'] = "Plan has been deleted successfully";
  } else {
    $_SESSION['error'] = "Something went wrong";
  }
  header("LOCATION:" . BASE_URL . "subscriptions");
  exit;
}


//Update status of Plans
if (isset($_GET['action']) && $_GET['action'] == 'status') {
  $upd = updatePlanStatus($conn, $_GET['id'], $_GET['status']);
  if ($_GET['status'] == 0) {
    $msg = "Plan is deactivated";
  }
  if ($_GET['status'] == 1) {
    $msg = "Plan is activated";
  }
  if ($upd) {
    $_SESSION['success'] = $msg;
  } else {
    $_SESSION['error'] = "Something went wrong";
    header("LOCATION:" . BASE_URL . "subscriptions");
    exit;
  }
  header("LOCATION:" . BASE_URL . "subscriptions");
  exit;
}

//Edit Plan

if(isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']) && $_GET['id'] > 0  ) {
  $plan = getPlanById($conn, $_GET['id']);
  if($plan->num_rows > 0) {
    $plan = $plan->fetch_assoc();
  }
} else{
  $plan = array('title' => '', 'amount' => '', 'duration' => '', 'id' => '');
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
        <h4 class="fw-bold text-uppercase">Subscription Plans</h4>
      </div>
      <div class="row">
        <div class="col-md-8">

          <div class="card">
            <div class="card-header">
              All Plans
            </div>
            <div class="card-body">
            <table id="example" class="table table-responsive table-striped">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if($plans->num_rows > 0) {
                     
                      $i=1;
                      while($row = $plans->fetch_assoc()) { ?>
                      <tr>
                    <th scope="row"><?=$i?></th>
                    <td><?=$row['title']?></td>
                    <td>&#8377; <?=$row['amount']?></td>
                    <td><?=$row['duration']?> month(s)</td>
                    <?php if($row['status'] == 1){ ?>
                    <td><button class="btn btn-success btn-sm">Active</button></td>
                    <?php } ?>
                    <?php if($row['status'] == 0){ ?>
                    <td><button class="btn btn-danger btn-sm">Inactive</button></td>
                    <?php } ?>
                    <td>
                    <a href="<?php echo BASE_URL ?>subscriptions/?action=edit&id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                      <a onclick="return confirm('Are You Sure')" href="<?php echo BASE_URL ?>subscriptions?action=delete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>

                      <?php
                        if ($row['status'] == 1) {
                          echo "<a   href ='" . BASE_URL . "subscriptions?action=status&id=" . $row['id'] . "&status=0' class='btn btn-warning btn-sm'>Inactivate</a>";
                        }
                        if ($row['status'] == 0) {
                          echo "<a  href ='" . BASE_URL . "subscriptions?action=status&id=" . $row['id'] . "&status=1' class='btn btn-success btn-sm'>Activate</a>";
                        }
                        ?>
                    </td>
                      </tr>
                    <?php }$i++;} ?>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              Add/Edit Plan
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo BASE_URL ; ?>subscriptions/" >
              <input type="hidden" name="id" value="<?=$plan['id']?>" class="form-control">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label">Title</label>
                      <input value="<?=$plan['title']?>" name="title" type="text" class="form-control" aria-describedby="emailHelp">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label">Amount</label>
                      <input value="<?=$plan['amount']?>" name="amount" type="text" class="form-control">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label">Duration</label>
                      <select name="duration" class="form-control">
                        <option value="">Please Select</option>
                        <?php
                        for ($i = 1; $i <= 12; $i++) { 
                        $selected = "";
                        if($i == $plan['duration']) {
                          $selected = "selected";
                        }
                        ?>
                          <option <?=$selected?> value="<?php echo $i; ?>"><?php echo $i; ?> month(s)</option>
                        <?php } ?>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                    <?php if($plan['id'] == '') { ?>
                    <button type="reset" name="submit" class="btn btn-secondary">Cancel</button>
                    <?php } 
                    else { ?>
                    <a href="<?php echo BASE_URL; ?>subscriptions" class = "btn btn-secondary">Cancel</a>
                    <?php }?>
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