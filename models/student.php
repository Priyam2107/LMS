<?php

//Function to create student
function create($conn, $param)
{
    extract($param);

    // Validation start
    if (empty($name)) {
        $result = array("error" => "Name is required");
        return $result;
    } else if (empty($email)) {
        $result = array("error" => "email is required");
        return $result;
    }else if (empty($phone_no)) {
        $result = array("error" => "Phone Number  is required");
        return $result;
    } else if (empty($address)) {
        $result = array("error" => "Address is required");
        return $result;
    }else if (isPhoneValid($phone_no)){
        $result = array("error" => "Invalid Phone Number");
        return $result;
    } 
    else if (isPhoneUnique($conn, $phone_no)) {
        $result = array("error" => "Phone Number is already registered");
        return $result;
    } else if (isEmailUnique($conn, $email)) {
        $result = array("error" => "Email is already registered");
        return $result;
    } 
    //Validation end

    $datetime = date("Y-m-d H:i:s");
    $sql = "insert into students (name,phone_no,email,address,created_at) values ('$name' , '$phone_no', '$email' , '$address',  '$datetime')";
    $result['success'] =  $conn->query($sql);
    return $result;
}


//Function to update a Student's data

function updateStudent($conn, $param)
{
    extract($param);
    // Validation start
    if (empty($name)) {
        $result = array("error" => "Name is required");
        return $result;
    } else if (empty($email)) {
        $result = array("error" => "email is required");
        return $result;
    }else if (empty($phone_no)) {
        $result = array("error" => "Phone Number  is required");
        return $result;
    } else if (empty($address)) {
        $result = array("error" => "Address is required");
        return $result;
    }else if (isPhoneValid($phone_no)){
        $result = array("error" => "Invalid Phone Number");
        return $result;
    } 
    else if (isPhoneUnique($conn, $phone_no,$id)) {
        $result = array("error" => "Phone Number is already registered");
        return $result;
    } else if (isEmailUnique($conn, $email,$id)) {
        $result = array("error" => "Email is already registered");
        return $result;
    } 
    //Validation end

    $datetime = date("Y-m-d H:i:s");
    $sql = "update students set name = '$name', email = '$email', phone_no = '$phone_no' , address = '$address' , updated_at = '$datetime' where id = $id";
    $result['success'] =  $conn->query($sql);
    return $result;
}

//Function to get all Students
function getStudents($conn)
{
    $sql = "select * from students order by id desc";
    $result = $conn->query($sql);
    return $result;
}

//Function to get a Student by ID
function getStudentByID($conn, $id)
{
    $sql = "select * from students where id=$id";
    $result = $conn->query($sql);
    return $result;
}

//Function to delete a student
function deleteStudent($conn, $id)
{
    $sql = "delete from students where id = $id";
    $result = $conn->query($sql);
    return $result;
}

//Function to update a student's status
function updateStudentStatus($conn, $id, $status)
{
    $sql = "update students set status = $status where id = $id";
    $result = $conn->query($sql);
    return $result;
}



//Function to check Email
function isEmailUnique($conn, $email, $id = NULL)
{
    $sql = "select id from students where email = '$email' ";
    if ($id) {
        $sql .= " and id != $id";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    return true;
    return false;
}

//Function to check Phone Number
function isPhoneUnique($conn, $phone_no, $id = NULL)
{
    $sql = "select id from students where phone_no = '$phone_no' ";
    if ($id) {
        $sql .= " and id != $id";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
        return true;
    return false;
}

//Function to check valid Phone Number
function isPhoneValid($phone_no)
{
    if (is_numeric($phone_no) && strlen($phone_no) == 10)
        return false;
    return true;
}
