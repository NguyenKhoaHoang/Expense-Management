<?php


$msgBox = '';
//Include Functions
include('includes/Functions.php');

//Include Notifications
include('includes/notification.php');

//Get id income to manage
if (isset($_GET['id'])) {
    $IncomeId = abs($_GET['id']);

//Select income form to edit
    if ($IncomeId != '') {
        $EditIncome = "SELECT a.AssetsId, a.Title, a.Date, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from assets a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 1 AND a.UserId = $UserId AND a.AssetsId = $IncomeId";
        if ($IncomeEdit = mysqli_query($mysqli, $EditIncome)) {
            $row = mysqli_fetch_assoc($IncomeEdit);
        }
    }
} else {
    exit;
}


// Update new Income
if (isset($_POST['income'])) {
    $IncomeId = $row['AssetsId'];
    $iuser = $_SESSION['UserId'];
    $iname = $mysqli->real_escape_string($_POST["iname"]);
    $icategory = $mysqli->real_escape_string($_POST["icategory"]);
    $iaccount = $mysqli->real_escape_string($_POST["iaccount"]);
    $idescription = $mysqli->real_escape_string($_POST["idescription"]);
    $idate = $mysqli->real_escape_string($_POST["idate"]);
    $iamount = $mysqli->real_escape_string(clean($_POST["iamount"]));


    $sql = "UPDATE assets SET Title = ?, Date = ?, CategoryId = ?, AccountId = ?, Amount = ?, Description = ? WHERE AssetsId = $IncomeId";
    if ($statement = $mysqli->prepare($sql)) {
        //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
        $statement->bind_param('ssiiss', $iname, $idate, $icategory, $iaccount, $iamount, $idescription);
        $statement->execute();

    }
    $msgBox = alertBox($UpdateMsgIncome);
}

// Get new data after update
$EditIncome = "SELECT a.AssetsId, a.Title, a.Date, a.Amount, a.Description, c.CategoryName, c.CategoryId, ac.AccountId, ac.AccountName from assets a, category c, account ac where a.CategoryId = c.CategoryId 
					AND a.AccountId = ac.AccountId AND c.Level = 1 AND a.UserId = $UserId AND a.AssetsId = $IncomeId";
if ($IncomeEdit = mysqli_query($mysqli, $EditIncome)) {
    $row = mysqli_fetch_assoc($IncomeEdit);
}




