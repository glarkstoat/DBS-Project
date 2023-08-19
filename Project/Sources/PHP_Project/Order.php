<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

if (isset($_GET['submit_search'])) {

    $order_ID = '';
    if (isset($_GET['order_ID'])) {
        $order_ID = $_GET['order_ID'];
    }
    $customer_ID = '';
    if (isset($_GET['customer_ID'])) {
        $customer_ID = $_GET['customer_ID'];
    }

    $e_ID = '';
    if (isset($_GET['e_ID'])) {
        $e_ID = $_GET['e_ID'];
    }

//Fetch data from database
    $order_array = $database->selectFromOrderDetails($order_ID, $e_ID, $customer_ID);
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

    <title>Orders</title>
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
            <a class="nav-item nav-link text-light" href="Subsidiary.php" style="font-size:15px">Subsidiaries</a>
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
                                <h1 class="main-title" style="color:black">Orders</h1>
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

<body>
<br>

<div id="content-wrapper">
    <section id="portfolio" class="white">
<div class="container">

    <div class="row justify-content-center mt-2 col-md-12">
        <div class="portfolio-item apps isotope-item mt-2 col-md-5">
            <h2><b>Add Order: </b></h2>
            <form method="post" action="addOrder.php">

                <div class="form-group">
                    <label for="e_ID">Employee ID:</label>
                    <input class="form-control" id="e_ID" name="e_ID" type="number" min="0">
                </div>

                <!-- First Name textbox:-->
                <div class="form-group">
                    <label for="car_ID">Car ID:</label>
                    <input class="form-control" id="car_ID" name="car_ID" type="number" maxlength="20">
                </div>

                <div class="form-group">
                    <label for="sub_ID">Subsidiary ID:</label>
                    <input class="form-control" id="sub_ID" name="sub_ID" type="number" maxlength="20">
                </div>

                <!-- Last Name textbox:-->
                <div class="form-group">
                    <label for="customer_ID">Customer ID:</label>
                    <input class="form-control" id="customer_ID" name="customer_ID" type="number" maxlength="20">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div><!--/.portfolio-item-->

        <div class="portfolio-item apps isotope-item mt-2 col-md-5">

            <h2><b>Order Search:</b></h2>
            <form method="get">
                <!-- ID textbox:-->
                <div class="form-group">
                    <label for="order_ID">Order ID:</label>
                    <input class="form-control" id="order_ID" name="order_ID" type="number" value='<?php echo $order_ID; ?>' min="0">
                </div>

                <!-- First Name textbox:-->
                <div class="form-group">
                    <label for="e_ID">Employee ID:</label>
                    <input class="form-control" id="e_ID" name="e_ID" type="number" value='<?php echo $e_ID; ?>'
                           maxlength="20">
                </div>

                <!-- Last Name textbox:-->
                <div class="form-group">
                    <label for="customer_ID">Customer ID:</label>
                    <input class="form-control" id="customer_ID" name="customer_ID" type="number"
                           value='<?php echo $customer_ID; ?>' maxlength="20">
                </div>
                <!-- Submit button -->
                <div>
                    <button name="submit_search" type="submit" class="btn btn-primary">Submit</button>

                </div>
            </form>
            <br>
            <hr>

            <h3><?php echo strval(count($order_array)) . " Results"; ?></h3>
            <br>

            <!-- Search result -->
            <h2><b>Order Search Result:</b></h2>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Price</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Car ID</th>
                    <th scope="col">Subsidiary ID</th>
                </tr>
                </thead>

                <?php foreach ($order_array as $order) : ?>
                    <tr>
                        <td><?php echo $order['ORDER_ID']; ?>  </td>
                        <td><?php echo $order['E_ID']; ?>  </td>
                        <td><?php echo $order['CUSTOMER_ID']; ?>  </td>
                        <td><?php echo $order['PRICE']; ?>  </td>
                        <td><?php echo $order['START_D']; ?>  </td>
                        <td><?php echo $order['END_D']; ?>  </td>
                        <td><?php echo $order['CAR_ID']; ?>  </td>
                        <td><?php echo $order['SUB_ID']; ?>  </td>
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