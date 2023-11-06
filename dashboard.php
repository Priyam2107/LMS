<?php


include_once("./config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/dashboard.php");

$counts = getCounts($conn);
$tabs = getTabData($conn);


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
        <h4 class="fw-bold text-uppercase">Dashboard</h4>
        <p>Statistics of the system!</p>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-center">
            <h6 class="card-title text-uppercase text-muted">
              Total Books
            </h6>
            <h1><?php echo $counts['total_books'] ?></h1>
            <a href="<?php echo BASE_URL; ?>books" class="card-link link-underline-light">View more</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-center">
            <h6 class="card-title text-uppercase text-muted">
              Total students
            </h6>
            <h1><?php echo $counts['total_students'] ?></h1>
            <a href="<?php echo BASE_URL; ?>students" class="card-link link-underline-light">View more</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-center">
            <h6 class="card-title text-uppercase text-muted">
              Total revenue
            </h6>
            <h1><?php echo number_format($counts['total_revenue']); ?></h1>
            <a href="<?php echo BASE_URL; ?>subscriptions/purchase-history.php" class="card-link link-underline-light">View more</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-center">
            <h6 class="card-title text-uppercase text-muted">
              Total Books loan
            </h6>
            <h1><?php echo ($counts['total_loans']); ?></h1>
            <a href="<?php echo BASE_URL; ?>loans" class="card-link link-underline-light">View more</a>
          </div>
        </div>
      </div>
    </div>

    <!--Tabs-->
    <div class="row mt-5 dashboard-tabs">
      <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active text-uppercase" id="student" data-bs-toggle="tab" data-bs-target="#student-pane" type="button" role="tab" aria-controls="student-pane" aria-selected="true">New Students</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link text-uppercase" id="recent-loan" data-bs-toggle="tab" data-bs-target="#recent-loan-pane" type="button" role="tab" aria-controls="recent-loan-pane" aria-selected="false">Recent Loans</button>
          </li>
          <li class="nav-item text-uppercase" role="presentation">
            <button class="nav-link" id="recent-subscription" data-bs-toggle="tab" data-bs-target="#recent-subscription-pane" type="button" role="tab" aria-controls="recent-subscription-pane" aria-selected="false">Recent Subscriptions</button>
          </li>

        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="student-pane" role="tabpanel" aria-labelledby="student" tabindex="0">
            <table class="table">
              <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone No</th>
                  <th scope="col">Registerd On</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                foreach($tabs['students'] as $st) { ?>
                <tr>
                  <th scope="row"><?php echo $i++ ?></th>
                  <td><?php echo $st['name'] ?></td>
                  <td><?php echo $st['email'] ?></td>
                  <td><?php echo $st['phone_no'] ?></td>
                  <td><?php echo date("d-m-Y H:i A",strtotime($st['created_at'])) ?></td>
                  <td>
                  <?php
                      if ($st['status'] == 1) {
                        echo '<span class="badge text-bg-success">Active</span>';
                      } else {
                        echo '<span class="badge text-bg-danger">Inactive</span>';
                      }
                      ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="recent-loan-pane" role="tabpanel" aria-labelledby="recent-loan" tabindex="0">
            <table class="table">
              <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Book Name</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Loan Date</th>
                  <th scope="col">Due Date</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $i=1;
                foreach($tabs['loans'] as $l) { ?>
                <tr>
                  <th scope="row"><?=$i++?></th>
                  <td><?php echo $l['book_title']; ?></td>
                  <td><?php echo $l['student_name']; ?></td>
                  <td><?php echo date("d-m-Y",strtotime($l['loan_date'])) ?></td>
                  <td><?php echo date("d-m-Y",strtotime($l['return_date'])) ?></td>
                  <td>
                  <?php
                      if ($l['is_return'] == 1) {
                        echo '<span class="badge text-bg-success">Returned</span>';
                      } else {
                        echo '<span class="badge text-bg-danger">Active</span>';
                      }
                      ?>
                  </td>
                </tr>
                <?php } ?>
                
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="recent-subscription-pane" role="tabpanel" aria-labelledby="recent-subscription" tabindex="0">
            <table class="table">
              <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Amount</th>
                  <th scope="col">Start Date</th>
                  <th scope="col">End Date</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $i=1;
                foreach($tabs['subscriptions'] as $s) { ?>
                <tr>
                  <th scope="row">1</th>
                  <td><?php echo $s['student_name'] ?></td>
                        <td>
                          <span class="badge text-bg-info me-1"><?php echo $s['plan_name'] ?></span>
                          <i class="fa-solid fa-indian-rupee-sign"><?php echo $s['amount'] ?></i>
                        </td>
                        <td><?php echo date("d-m-Y", strtotime($s['start_date'])) ?></td>
                        <td><?php echo date("d-m-Y", strtotime($s['end_date'])) ?></td>
                        <td>
                          <?php
                          $today = date("Y-m-d");
                          if ($today <= $s['end_date'])
                            echo '<span class="badge text-bg-success">Active</span>';
                          else
                            echo '<span class="badge text-bg-danger">Expired</span>';
                          ?>
                        </td>
                </tr>
             <?php } ?>
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