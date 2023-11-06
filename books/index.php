<?php


include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./models/book.php");

//Get Books
$books = getBooks($conn);

//Delete Books
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $del = deleteBook($conn, $_GET['id']);
  if ($del) {
    $_SESSION['success'] = "Book has been deleted successfully";
  } else {
    $_SESSION['error'] = "Something went wrong";
  }
  header("LOCATION:" . BASE_URL . "books");
  exit;
}


//Update status of Books
if (isset($_GET['action']) && $_GET['action'] == 'status') {
  $upd = updateBookStatus($conn, $_GET['id'], $_GET['status']);
  if ($_GET['status'] == 0) {
    $msg = "Book status is deactivated";
  }
  if ($_GET['status'] == 1) {
    $msg = "Book status is activated";
  }
  if ($upd) {
    $_SESSION['success'] = $msg;
  } else {
    $_SESSION['error'] = "Something went wrong";
  }
  header("LOCATION:" . BASE_URL . "books");
  exit;
}

include_once(DIR_URL . "./include/header.php");
include_once(DIR_URL . "./include/topbar.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./include/sidebar.php");
?>

<!--Main content start-->
<main class="mt-1 pt-3">
  <div class="container-fluid">
    <!-- Cards-->
    <div class="row dashboard-counts">
      <div class="col-md-12">
        <?php include(DIR_URL . "./include/alerts.php"); ?>
        <h4 class="fw-bold text-uppercase">Manage Books</h4>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            All Books
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-responsive table-striped">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Publication Year</th>
                    <th scope="col">Author Name</th>
                    <th scope="col">ISBN Number</th>
                    <th scope="col">Category Name</th>
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
                      echo "<td>" . $row['title'] . "</td>";
                      echo "<td>" . $row['publication_year'] . "</td>";
                      echo "<td>" . $row['author'] . "</td>";
                      echo  "<td>" . $row['isbn'] . "</td>";
                      echo  "<td>" . $row['cat_name'] . "</td>";
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
                        <a href="<?php echo BASE_URL ?>books/edit.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a onclick="return confirm('Are You Sure')" href="<?php echo BASE_URL ?>books?action=delete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        <?php
                        if ($row['status'] == 1) {
                          echo "<a   href ='" . BASE_URL . "books?action=status&id=" . $row['id'] . "&status=0' class='btn btn-warning btn-sm'>Inactivate</a>";
                        }
                        if ($row['status'] == 0) {
                          echo "<a  href ='" . BASE_URL . "books?action=status&id=" . $row['id'] . "&status=1' class='btn btn-success btn-sm'>Activate</a>";
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