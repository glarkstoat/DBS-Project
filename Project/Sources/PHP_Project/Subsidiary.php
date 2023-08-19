<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

if (isset($_GET['submit_search'])) {
    $street_name = '';
    if (isset($_GET['street_name'])) {
        $street_name = $_GET['street_name'];
    }

    $street_nr = '';
    if (isset($_GET['street_nr'])) {
        $street_nr = $_GET['street_nr'];
    }

    $zip_code = '';
    if (isset($_GET['zip_code'])) {
        $zip_code = $_GET['zip_code'];
    }

    $city = '';
    if (isset($_GET['city'])) {
        $city = $_GET['city'];
    }

//Fetch data from database
    $sub_array = $database->selectFromSubWhere($street_name, $street_nr, $zip_code, $city);
}
else {
    $sub_array = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Subsidiaries</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/pe-icons.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="js/jquery.js"></script>

</head><!--/head-->
<body<body class="container-fluid">

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
            <a class="nav-item nav-link text-light" href="Employee.php" style="font-size:15px">Employees</a>
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
                                <h1 class="main-title" style="color:black">Subsidiaries</h1>
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
                <div class="portfolio-item apps isotope-item mt-2 col-md-5">
                    <h2><b>Add Subsidiary: </b></h2>
                        <form method="post" action="addSubsidiary.php">

                        <div class="form-group">
                            <label for="street_name">Street Name</label>
                            <input id="street_name" class="form-control" name="street_name" type="text" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="street_nr">Street Number</label>
                            <input type="number" class="form-control" name="street_nr" id="street_nr">
                        </div>
                            <div class="form-group">
                                <label for="zip_code">Zip Code:</label>
                                <input id="zip_code" name="zip_code" class="form-control" type="number" maxlength="30">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                </div>

                <div class="portfolio-item apps isotope-item mt-2 col-md-5">

                <!-- Add Location -->
                    <h2><b>Add Location: </b></h2>
                    <form method="post" action="addLocation.php">

                        <div class="form-group">
                            <label for="city">City</label>
                            <input id="city" class="form-control" name="city" type="text" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="zip_code">Zip Code</label>
                            <input type="number" class="form-control" name="zip_code" id="zip_code">
                        </div>

                        <!-- Submit button -->
                        <div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>


                <div class="portfolio-item apps isotope-item mt-2 col-md-5">


                <!-- Delete Car Type -->
                <h2><b> Delete Subsidiary: </b></h2>
                    <form method="post" action="delSubsidiary.php">
                        <!-- ID textbox -->
                        <div class="form-group">
                            <label for="street_name">Street Name</label>
                            <input id="street_name" class="form-control" name="street_name" type="text" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="street_nr">Street Number</label>
                            <input type="number" class="form-control" name="street_nr" id="street_nr">
                        </div>

                        <!-- Submit button -->
                        <div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>


                </div>

                <div class="portfolio-item apps isotope-item mt-2 col-md-5">

                <!-- Delete Car Type -->
                <h2><b>Update Subsidiary: </b></h2>
                    <form method="post" action="updateSubsidiary.php">
                        <!-- ID textbox -->

                        <div class="form-group">
                            <label for="sub_ID">Subsidiary ID</label>
                            <input type="number" class="form-control" name="sub_ID" id="sub_ID">
                        </div>

                        <div class="form-group">
                            <label for="new_street_name">New Street Name</label>
                            <input id="new_street_name" class="form-control" name="new_street_name" type="text" min="0">
                        </div>

                        <div class="form-group">
                            <label for="new_street_nr">New Street Number</label>
                            <input id="new_street_nr" class="form-control" name="new_street_nr" type="number" min="0">
                        </div>

                        <div class="form-group">
                            <label for="new_zip_code">New Zip Code</label>
                            <input id="new_zip_code" class="form-control" name="new_zip_code" type="number" min="0">
                        </div>
                        <br>

                        <!-- Submit button -->
                        <div>
                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
            <br>
            <hr>
        <div class="container">
            <div class="row justify-content-center mt-2 col-md-12">
                <div class="portfolio-item apps isotope-item mt-2 col-md-5">

                <h2><b>Subsidiary Search:</b></h2>
        <form method="get">
            <!-- ID textbox:-->
            <div class="form-group">
                <label for="street_name">Street Name:</label>
                <input class="form-control" id="street_name" name="street_name" type="text" value='<?php echo $street_name; ?>' min="0">
            </div>

            <!-- First Name textbox:-->
            <div class="form-group">
                <label for="street_nr">Street Number:</label>
                <input class="form-control" id="street_nr" name="street_nr" type="number" value='<?php echo $street_nr; ?>'
                       maxlength="20">
            </div>

            <!-- Last Name textbox:-->
            <div class="form-group">
                <label for="zip_code">Zip Code:</label>
                <input class="form-control" id="zip_code" name="zip_code" type="number"
                       value='<?php echo $zip_code; ?>' maxlength="20">
            </div>

            <!-- Last Name textbox:-->
            <div class="form-group">
                <label for="city">City:</label>
                <input class="form-control" id="city" name="city" type="text"
                       value='<?php echo $city; ?>' maxlength="30">
            </div>

            <!-- Submit button -->
            <div>
                <button name="submit_search" type="submit" class="btn btn-primary">Submit</button>

            </div>
        </form>
        <br>
        <hr>

                    <h3><?php echo strval(count($sub_array)) . " Results"; ?></h3>
                    <br>


                    <!-- Search result -->
                    <h2><b>Subsidiary Search Result:</b></h2>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Subsidiary ID</th>
                <th scope="col">Street Name</th>
                <th scope="col">Street Number</th>
                <th scope="col">Zip Code</th>
                <th scope="col">City</th>
                <th scope="col">Employees</th>
                <th scope="col">Cars in Inventory</th>
                <th scope="col">Cars rended at the moment</th>
                <th scope="col">Turnover [€]</th>
            </tr>
            </thead>


            <?php foreach ($sub_array as $sub) : ?>
                <tr>
                    <td><?php echo $sub['SUB_ID']; ?>  </td>
                    <td><?php echo $sub['STREET_NAME']; ?>  </td>
                    <td><?php echo $sub['STREET_NR']; ?>  </td>
                    <td><?php echo $sub['ZIP_CODE']; ?>  </td>
                    <td><?php echo $sub['CITY']; ?>  </td>
                    <td><?php echo $sub['EMPLOYEES']; ?>  </td>
                    <td><?php echo $sub['CARS_IN_INVENTORY']; ?>  </td>
                    <td><?php echo $sub['RENTED_CARS_ATM']; ?>  </td>
                    <td><?php echo $sub['TURNOVER']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>


        </div>
        </div>
        </div>
    </section>




    <!-- Footer -->
    <footer class="page-footer font-small blue bg-dark text-white">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3 bg-dark text-white">WISKOTT & SONS:
            <a href="http://wwwlab.cs.univie.ac.at/~wiskottc95/Project/index.php"> Home</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>