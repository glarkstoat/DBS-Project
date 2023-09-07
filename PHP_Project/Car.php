<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

$car_array = [];
$feature_array = [];

if (isset($_GET['submit_search'])) {
    $make = '';
    if (isset($_GET['make'])) {
        $make = $_GET['make'];
    }

    $model = '';
    if (isset($_GET['model'])) {
        $model = $_GET['model'];
    }

    $type_name = '';
    if (isset($_GET['type_name'])) {
        $type_name = $_GET['type_name'];
    }

//Fetch data from database
    $car_array = $database->selectFromCarWhere($make, $model, $type_name);
}

if (isset($_GET['submit_search_feat'])) {

    $make_feat = '';
    if (isset($_GET['make_feat'])) {
        $make_feat = $_GET['make_feat'];
    }

    $model_feat = '';
    if (isset($_GET['model_feat'])) {
        $model_feat = $_GET['model_feat'];
    }

//Fetch data from database
    $feature_array = $database->selectFromFeatureWhere($make_feat, $model_feat);
}

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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="index.php" style="font-size:15px">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link text-light" href="Subsidiary.php" style="font-size:15px">Subsidiaries</a>
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
                                <h1 class="main-title" style="color:black">Cars</h1>
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
                    <!-- Delete Car Type -->
                    <h2><b>Delete Car Type: </b></h2>
                    <form method="post" action="delType.php">

                        <div class="form-group">
                            <label for="type_name">Type Name</label>
                            <input id="type_name" class="form-control" name="type_name" type="text" maxlength="30">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div><!--/.portfolio-item-->

                <div class="portfolio-item apps isotope-item mt-2 col-md-5">

                    <!-- Add Location -->
                    <h2><b>Delete Make/Model: </b></h2>
                    <form method="post" action="delMakeModel.php">

                        <div class="form-group">
                            <label for="make">Make</label>
                            <input id="make" class="form-control" name="make" type="text" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" name="model" id="model">
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
                <div class="portfolio-item apps isotope-item mt-2 col-md-5">

                    <h2><b>Car Search:</b></h2>
                    <form method="get">

                        <div class="form-group">
                            <label for="make">Make</label>
                            <input class="form-control" id="make" name="make" type="text" value='<?php echo $make; ?>' min="0">
                        </div>

                        <div class="form-group">
                            <label for="model">Model</label>
                            <input class="form-control" id="model" name="model" type="text" value='<?php echo $model; ?>'
                                   maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="type_name">Type Name</label>
                            <input class="form-control" id="type_name" name="type_name" type="text"
                                   value='<?php echo $type_name; ?>' maxlength="20">
                        </div>

                        <!-- Submit button -->
                        <div>
                            <button name="submit_search" type="submit" class="btn btn-primary">Submit</button>

                        </div>
                    </form>
                    <br>
                    <hr>

                    <h3><?php echo strval(count($car_array)) . " Results"; ?></h3>
                    <br>

                    <!-- Search result -->
                    <h2>Car Search Result:</h2>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Make</th>
                            <th scope="col">Model</th>
                            <th scope="col">Type</th>
                            <th scope="col">Price/Day[€]</th>
                            <th scope="col">Car ID</th>
                            <th scope="col">Sub ID</th>
                            <th scope="col">Mileage [km]</th>
                            <th scope="col">Consumption [L/100km]</th>
                        </tr>
                        </thead>

                        <?php foreach ($car_array as $car) : ?>
                            <tr>
                                <td><?php echo $car['MAKE']; ?>  </td>
                                <td><?php echo $car['MODEL']; ?>  </td>
                                <td><?php echo $car['TYPE_NAME']; ?>  </td>
                                <td><?php echo $car['PRICE_PER_DAY']; ?>  </td>
                                <td><?php echo $car['CAR_ID']; ?>  </td>
                                <td><?php echo $car['SUB_ID']; ?>  </td>
                                <td><?php echo $car['MILEAGE']; ?>  </td>
                                <td><?php echo $car['CONSUMPTION']; ?>  </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </div>


            <div class="portfolio-item apps isotope-item mt-2 col-md-5">

                <h2><b>Feature Search:</b></h2>
                    <form method="get">

                        <div class="form-group">
                            <label for="make_feat">Make</label>
                            <input class="form-control" id="make_feat" name="make_feat" type="text" value='<?php echo $make_feat; ?>' min="0">
                        </div>

                        <div class="form-group">
                            <label for="model_feat">Model</label>
                            <input class="form-control" id="model_feat" name="model_feat" type="text" value='<?php echo $model_feat; ?>'
                                   maxlength="20">
                        </div>

                        <!-- Submit button -->
                        <div>
                            <button name="submit_search_feat" type="submit" class="btn btn-primary">Submit</button>

                        </div>
                    </form>
                    <br>
                    <hr>

                    <h3><?php echo strval(count($feature_array)) . " Results"; ?></h3>
                    <br>

                    <!-- Search result -->
                    <h2>Feature Search Result:</h2>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Make</th>
                            <th scope="col">Model</th>
                            <th scope="col">Feature</th>
                        </tr>
                        </thead>

                        <?php foreach ($feature_array as $feat) : ?>
                            <tr>
                                <td><?php echo $feat['MAKE']; ?>  </td>
                                <td><?php echo $feat['MODEL']; ?>  </td>
                                <td><?php echo $feat['DESCRIPTION']; ?>  </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

            </div>
        </div>
    </div>


</section>
</div>
</body>


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