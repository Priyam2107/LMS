<?php

//Function to get system counts
function getCounts($conn)
{
    $counts = array(
        'total_books' >= 0,
        'total_students' >= 0,
        'total_loans' >= 0,
        'total_revenue' >= 0
    );

    //Get books count
    $sql = "select count(id) as total_books from books";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $books = $result->fetch_assoc();
        $counts['total_books'] = $books['total_books'];
    }
    

    //Get students count
    $sql = "select count(id) as total_students from students";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $students = $result->fetch_assoc();
        $counts['total_students'] = $students['total_students'];
    }

    //Get loans count
    $sql = "select count(id) as total_loans from book_loans";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $loans = $result->fetch_assoc();
        $counts['total_loans'] = $loans['total_loans'];
    }

    //Get total amount
    $sql = "select sum(amount) as total_revenue from subscriptions";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $amount = $result->fetch_assoc();
        $counts['total_revenue'] = $amount['total_revenue'];
    }

    return $counts;
   
}


//Function to get system data
function getTabData($conn)
{
    $tabs = array(
        'loans' => array(),
        'students' => array(),
        'subscriptions' => array()
    );

    //Get students 
    $sql = "select * from  students order by id desc limit 5";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        $tabs['students'][] = $row;
    }
}

    //Get loans
    $sql = "select l.*, b.title as book_title, s.name as student_name
     from  book_loans l
     inner join books b on b.id = l.book_id
     inner join students s on s.id = l.student_id
     order by l.id desc limit 5";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        $tabs['loans'][] = $row;
    }
}


    //Get subscription
    $sql = "select s.*, p.title as plan_name, st.name as student_name from subscriptions s
    inner join subscription_plans p on p.id = s.plan_id
    inner join students st on st.id = s.student_id order by s.id  desc limit 5";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        $tabs['subscriptions'][] = $row;
    }
}

    return $tabs;
   
}




