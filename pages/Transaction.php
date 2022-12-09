<?php

$msgBoxExpense='';
//Include Functions
include('includes/Functions.php');

//Include Notifications
include ('includes/notification.php');


//save income form
if(isset($_POST['income'])){
    $iuser			= $_SESSION['UserId'];
    $iname 			= $mysqli->real_escape_string($_POST["iname"]);
    $icategory		= $mysqli->real_escape_string($_POST["icategory"]);
    $iaccount		= $mysqli->real_escape_string($_POST["iaccount"]);
    $idescription	= $mysqli->real_escape_string($_POST["idescription"]);
    $idate			= $mysqli->real_escape_string($_POST["idate"]);
    $iamount		= $mysqli->real_escape_string(clean($_POST["iamount"]));

    if($iuser == '' OR $iamount == '' ) {
        $msgBox = alertBox($MessageEmpty);
    } else{

        if($iamount < 0){
            $msgBox = alertBox($NegativeAmount);
        }else{
            //add new income
            $sql="INSERT INTO assets (UserId, Title, Date, CategoryId, AccountId, Amount, Description) VALUES (?,?,?,?,?,?,?)";
            if($statement = $mysqli->prepare($sql)){
                //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
                $statement->bind_param('issiiss',$iuser, $iname, $idate, $icategory, $iaccount, $iamount, $idescription);
                $statement->execute();
            }
            $msgBox = alertBox($SaveMsgIncome);
        }
    }
}

//save Expense form
if(isset($_POST['expense'])){
    $euser			= $_SESSION['UserId'];
    $ename 			= $mysqli->real_escape_string($_POST["ename"]);
    $ecategory		= $mysqli->real_escape_string($_POST["ecategory"]);
    $eaccount		= $mysqli->real_escape_string($_POST["eaccount"]);
    $edescription	= $mysqli->real_escape_string($_POST["edescription"]);
    $edate			= $mysqli->real_escape_string($_POST["edate"]);
    $eamount		= $mysqli->real_escape_string(clean($_POST["eamount"]));

    if($ename == '' OR $eamount == '' ) {
        $msgBox = alertBox($MessageEmpty);
    } else{

        if($eamount < 0){
            $msgBoxExpense = alertBox($NegativeAmount);
        }else{

            //add new expense
            $sql="INSERT INTO bills (UserId, Title, Dates, CategoryId, AccountId, Amount, Description) VALUES (?,?,?,?,?,?,?)";
            if($statement = $mysqli->prepare($sql)){
                //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
                $statement->bind_param('issiiss',$euser, $ename, $edate, $ecategory, $eaccount, $eamount, $edescription);
                $statement->execute();
            }
            $msgBoxExpense = alertBox($SaveMsgExpense);
        }
    }

}

?>