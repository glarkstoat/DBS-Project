<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

if (isset($_GET['submit_search'])) {

    $e_ID = '';
    if (isset($_GET['e_ID'])) {
        $e_ID = $_GET['e_ID'];
    }

    $sub_ID = '';
    if (isset($_GET['sub_ID'])) {
        $sub_ID = $_GET['sub_ID'];
    }

    $first_name = '';
    if (isset($_GET['first_name'])) {
        $first_name = $_GET['first_name'];
    }

    $last_name = '';
    if (isset($_GET['last_name'])) {
        $last_name = $_GET['last_name'];
    }


//Fetch data from database
    $employee_array = $database->selectFromEmployeeWhere($e_ID, $sub_ID, $first_name, $last_name);
}
else {
    $employee_array = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Employees</title>
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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="index.php" style="font-size:15px">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link text-light" href="Car.php" style="font-size:15px">Cars</a>
            <a class="nav-item nav-link text-light" href="Customer.php" style="font-size:15px">Customers</a>
            <a class="nav-item nav-link text-light" href="Order.php" style="font-size:15px">Orders</a>
            <a class="nav-item nav-link text-light" href="Subsidiary.php" style="font-size:15px">Subsidiaries</a>
        </div>
    </div>
</nav>


<section id="single-page-slider" class="no-margin">
    <div class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="center gap fade-down section-heading">
                                <h1 class="main-title" style="color:black">Employees</h1>
                                <hr>
                                <h2 style="color:black">Database Access Point</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
        </div><!--/.carousel-inner-->
    </div><!--/.carousel-->
</section><!--/#main-slider-->

<div id="content-wrapper">
    <section id="portfolio" class="white">
        <div class="container">

            <div class="row justify-content-center mt-2 col-md-12">
                <div class="portfolio-item apps isotope-item mt-2 col-md-4">
                    <h2><b>Add Employee: </b></h2>
                    <form method="post" action="addEmployee.php">

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input id="first_name" class="form-control" name="first_name" type="text" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="phone_nr">Phone Number</label>
                            <input id="phone_nr" name="phone_nr" class="form-control" type="text" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="sub_ID">Sub ID</label>
                            <input id="sub_ID" name="sub_ID" class="form-control" type="number" maxlength="30">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>


                </div><!--/.portfolio-item-->

                <div class="portfolio-item apps isotope-item mt-2 col-md-4">

                    <!-- Delete Car Type -->
                    <h2><b>Update Employee: </b></h2>
                    <form method="post" action="updateEmployee.php">

                        <!-- ID textbox -->
                        <div class="form-group">
                            <label for="e_ID">Employee ID</label>
                            <input type="number" class="form-control" name="e_ID" id="e_ID">
                        </div>

                        <div class="form-group">
                            <label for="new_phone_nr">Phone Number</label>
                            <input type="text" class="form-control" name="new_phone_nr" id="new_phone_nr">
                        </div>

                        <div class="form-group">
                            <label for="new_sub_ID">Subsidiary ID</label>
                            <input type="number" class="form-control" name="new_sub_ID" id="new_sub_ID">
                        </div>
                        <!-- Submit button -->
                        <div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>

                <div class="portfolio-item apps isotope-item mt-2 col-md-4">

                    <!-- Add Location -->
                    <h2><b>Delete Employee: </b></h2>
                    <form method="post" action="delEmployee.php">

                        <div class="form-group">
                            <label for="e_ID">Employee ID</label>
                            <input id="e_ID" class="form-control" name="e_ID" type="number" maxlength="30">
                        </div>
                        <!-- Submit button -->
                        <div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div><!--/.portfolio-item-->

            </div>
        </div>
        <br>
        <hr>
        <div class="container">

            <div class="row justify-content-center mt-2 col-md-12">
                <div class="portfolio-item apps isotope-item mt-2 col-md-6">

                    <h2><b>Employee Search:</b></h2>
                    <form method="get">
                        <!-- ID textbox:-->
                        <div class="form-group">
                            <label for="e_ID">Employee ID</label>
                            <input class="form-control" id="e_ID" name="e_ID" type="number" value='<?php echo $e_ID; ?>' min="0">
                        </div>

                        <div class="form-group">
                            <label for="sub_ID">Subsidiary ID</label>
                            <input class="form-control" id="sub_ID" name="sub_ID" type="number" value='<?php echo $sub_ID; ?>' min="0">
                        </div>

                        <!-- First Name textbox:-->
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input class="form-control" id="first_name" name="first_name" type="text" value='<?php echo $first_name; ?>'
                                   maxlength="20">
                        </div>

                        <!-- Last Name textbox:-->
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input class="form-control" id="last_name" name="last_name" type="text"
                                   value='<?php echo $last_name; ?>' maxlength="20">
                        </div>
                        <!-- Submit button -->
                        <div>
                            <button name="submit_search" type="submit" class="btn btn-primary">Submit</button>

                        </div>
                    </form>
                    <br>
                    <hr>

                    <h3><?php echo strval(count($employee_array)) . " Results"; ?></h3>
                    <br>

                    <!-- Search result -->
                    <h2>Employee Search Result:</h2>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Sub ID</th>
                            <th scope="col">Turnover</th>
                        </tr>
                        </thead>


                        <?php foreach ($employee_array as $employee) : ?>
                            <tr>
                                <td><?php echo $employee['E_ID']; ?>  </td>
                                <td><?php echo $employee['FIRST_NAME']; ?>  </td>
                                <td><?php echo $employee['LAST_NAME']; ?>  </td>
                                <td><?php echo $employee['PHONE_NR']; ?>  </td>
                                <td><?php echo $employee['SUB_ID']; ?>  </td>
                                <td><?php echo $employee['TURNOVER']; ?>  </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
        </div>


</div>
</section>
</div>


<!-- Footer -->
<footer class="page-footer font-small blue bg-dark text-white">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3 bg-dark text-white">WISKOTT & SONS:
        <a href="http://wwwlab.cs.univie.ac.at/~wiskottc95/Project/index.php"> Home</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>