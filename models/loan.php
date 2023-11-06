<?php 

//Function to store book loan
function createLoan($conn, $param)
{
    extract($param);

    // Validation start
    if(empty($book_id))
    {
        $result = array("error"=>"Please Select a book ");
        return $result;
    }else if(empty($student_id)) {
        $result = array("error"=>"Please Select a student");
        return $result;
    }
    
    //Validation end

    $datetime = date("Y-m-d H:i:s");
    $sql = "insert into book_loans (book_id,student_id,loan_date,return_date,created_at) values ($book_id, $student_id, '$loan_date' , '$return_date', '$datetime')";
    $result['success'] =  $conn->query($sql);
    return $result;
}


//Function to update a book's loan data

function updateBookLoan($conn, $param)
{
    extract($param);
    
    // Validation start
    if(empty($book_id))
    {
        $result = array("error"=>"Please Select a book ");
        return $result;
    }else if(empty($student_id)) {
        $result = array("error"=>"Please Select a student");
        return $result;
    }
    

    $datetime = date("Y-m-d H:i:s");
    $sql = "update book_loans set book_id = '$book_id', student_id = '$student_id', loan_date = '$loan_date' , return_date = '$return_date' , is_return = 0, updated_at = '$datetime' where id = $id ";
    $result['success'] =  $conn->query($sql);
    return $result;
}

//Function to get all loans

function getLoans($conn)
{
    $sql = "select l.*, b.title as book_title, s.name as student_name from book_loans l inner join books b on b.id = l.book_id inner join students s on s.id = l.student_id order by l.id desc";
    $result = $conn->query($sql);
    return $result;
}

//Function to get a loan by ID

function getLoanByID($conn, $id)
{
    $sql = "select * from book_loans where id=$id";
    $result = $conn->query($sql);
    return $result; 
}

//Function to delete a loan

function deleteLoan($conn,$id)
{
    $sql = "delete from book_loans where id = $id";
    $result = $conn->query($sql);
    return $result;
}

//Function to update a book's status

function updateLoanStatus($conn,$id,$status)
{
    $sql = "update book_loans set is_return = $status where id = $id";
    $result = $conn->query($sql);
    return $result;
}

//Function to get categories
function getStudents($conn) 
{
    $sql = "select id,name from students";
    $result = $conn->query($sql);
    return $result;
}

function getBooks($conn) 
{
    $sql = "select id,title from books";
    $result = $conn->query($sql);
    return $result;
}

//Function to check ISBN Number
function isIsbnUnique($conn, $isbn,$id = NULL)
{
    $sql = "select id from books where isbn = '$isbn' ";
    if($id) {
        $sql.=" and id != $id";
    }
    $result = $conn->query($sql);
    if($result->num_rows >0)
        return true;
    return false;
}