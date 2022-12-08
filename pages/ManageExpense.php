<?php

$msgBox='';
//Include Functions
include('includes/Functions.php');

//Include Notifications
include ('includes/notification.php');

//Get id expense to manage
if(isset($_GET['id'])){
    $ExpenseId = abs($_GET['id']);

//Select expense form to edit
    if($ExpenseId != ''){
        $EditExpense = "SELECT a.BillsId, a.Title, a.Dates, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from bills a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 2 AND a.UserId = $UserId AND a.BillsId = $ExpenseId";
        if($ExpenseEdit = mysqli_query($mysqli,$EditExpense)){
            $row = mysqli_fetch_assoc($ExpenseEdit);
        }
    }
}
else{exit;}


// Update new expense
if(isset($_POST['expense'])){
    $ExpenseId		= $row['BillsId'];
    $iuser			= $_SESSION['UserId'];
    $iname 			= $mysqli->real_escape_string($_POST["iname"]);
    $icategory		= $mysqli->real_escape_string($_POST["icategory"]);
    $iaccount		= $mysqli->real_escape_string($_POST["iaccount"]);
    $idescription	= $mysqli->real_escape_string($_POST["idescription"]);
    $idate			= $mysqli->real_escape_string($_POST["idate"]);
    $iamount		= $mysqli->real_escape_string(clean($_POST["iamount"]));


    $sql="UPDATE bills SET Title = ?, Dates = ?, CategoryId = ?, AccountId = ?, Amount = ?, Description = ? WHERE BillsId = $ExpenseId";
    if($statement = $mysqli->prepare($sql)){
        //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
        $statement->bind_param('ssiiss', $iname, $idate, $icategory, $iaccount, $iamount, $idescription);
        $statement->execute();

    }
    $msgBox = alertBox($UpdateMsgExpense);
}

// Get new data after update
$EditExpense = "SELECT a.BillsId, a.Title, a.Dates, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from bills a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 2 AND a.UserId = $UserId AND a.BillsId = $ExpenseId";
if($ExpenseEdit = mysqli_query($mysqli,$EditExpense)){
    $row = mysqli_fetch_assoc($ExpenseEdit);
}

?>