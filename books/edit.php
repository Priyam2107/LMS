<?php


include_once("../config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "./include/middleware.php");
include_once(DIR_URL . "./models/book.php");


if(isset($_GET['id']) && $_GET['id'] > 0)
{
    $book = getBookByID($conn, $_GET['id']);
    if($book->num_rows > 0) {
        $book = $book->fetch_assoc(); 
    }else{
        header("LOCATION: ".BASE_URL."book");
        exit;
    }
}

//Update Book Functionality 
if (isset($_POST['update'])) {
    $res = updateBook($conn, $_POST);
    if (isset($res['success'])) {
        $_SESSION['success'] = "Book has been updated successfully";
        header("LOCATION:" . BASE_URL . "books");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
        header("LOCATION:" . BASE_URL . "books");
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
                <h4 class="fw-bold text-uppercase">Edit Book</h4>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Fill the Form
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL; ?>books/edit.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Book Title</label>
                                        <input type="hidden" value="<?php echo $book['id'] ?>" name="id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        <input type="text" value="<?php echo $book['title'] ?>" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">ISBN Number</label>
                                        <input type="text" value =  "<?php echo $book['isbn'] ?>" name="isbn" class="form-control" id="exampleInputPassword1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Publiser Name</label>
                                        <input type="text" value =  "<?php echo $book['author'] ?>" name="author" class="form-control" id="exampleInputPassword1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Publication Year</label>
                                        <input type="number" value = "<?php echo $book['publication_year'] ?>" name="publication_year" class="form-control" id="exampleInputPassword1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Category</label>
                                        <?php
                                        $cats = getCategories($conn);
                                        ?>
                                        <select name="category_id" class="form-control">
                                            <?php while ($row = $cats->fetch_assoc()) {
                                                $selected = "";
                                                if($book['category_id'] == $row['id']) {
                                                    $selected = "selected";
                                                }
                                                echo "<option ".$selected." value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                    <a href="<?php echo BASE_URL?>books" class="btn btn-secondary">Back</a>
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