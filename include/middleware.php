<?php if (isset($_SESSION['is_user_login'])) { 
    return true;
}
    else {
        header("LOCATION:" . BASE_URL);
    }
 ?>