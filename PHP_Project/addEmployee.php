<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$first_name = '';
if(isset($_POST['first_name'])){
    $first_name = $_POST['first_name'];
}

$last_name = '';
if(isset($_POST['last_name'])){
    $last_name = $_POST['last_name'];
}

$phone_nr = '';
if(isset($_POST['phone_nr'])){
    $phone_nr = $_POST['phone_nr'];
}

$sub_ID = '';
if(isset($_POST['sub_ID'])){
    $sub_ID = $_POST['sub_ID'];
}

// Insert method
$success = $database->insertIntoEmployee($first_name, $last_name, $phone_nr, $sub_ID);
$success1 = $database->updateSubsidiaryTOTAL();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Cars</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/pe-icons.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="js/jquery.js"></script>

</head><!--/head-->
<body class="container-fluid">




<section id="single-page-slider" class="no-margin">
    <div class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="center gap fade-down section-heading">
                                <h2 class="main-title" style="color:black">Add Employee</h2>
                                <hr>
                                <h2 style="color:black">
                                    <?php
                                    if ($success){
                                        echo "Employee <b>{$first_name} {$last_name}, {$phone_nr}</b> was successfully added to Subsidiary <b>{$sub_ID}</b>!";
                                    }
                                    else{
                                        echo "Error can't insert Employee {$first_name} {$last_name}, {$phone_nr} working in Subsidiary: {$sub_ID}!";
                                    }
                                    ?>
                                </h2>
                                <br>
                                <a href="Employee.php" class="btn btn-primary">Go back to Employee Site</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
        </div><!--/.carousel-inner-->
    </div><!--/.carousel-->
</section><!--/#main-slider-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
