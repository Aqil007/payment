<?php
session_start();
error_reporting(0);
include('includes/config.php');

$find = "%{$_POST['product']}%";

if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $sql_p = "SELECT * FROM products WHERE id={$id}";
        $query_p = mysqli_query($con, $sql_p);
        if (mysqli_num_rows($query_p) != 0) {
            $row_p = mysqli_fetch_array($query_p);
            $_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
            echo "<script>alert('Product has been added to the cart')</script>";
            echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
        } else {
            $message = "Product ID is invalid";
        }
    }
}

// Code for Wishlist
if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
    if (strlen($_SESSION['login']) == 0) {   
        header('location:login.php');
    } else {
        mysqli_query($con, "INSERT INTO wishlist(userId, productId) VALUES ('" . $_SESSION['id'] . "', '" . $_GET['pid'] . "')");
        echo "<script>alert('Product added to wishlist');</script>";
        header('location:my-wishlist.php');
    }
}

// Handling filters
$min_price = isset($_POST['price_min']) ? intval($_POST['price_min']) : 0;
$max_price = isset($_POST['price_max']) ? intval($_POST['price_max']) : PHP_INT_MAX;
$brand = isset($_POST['brand']) ? $_POST['brand'] : '';
$quality = isset($_POST['quality']) ? $_POST['quality'] : '';

$filter_query = "SELECT * FROM products WHERE productName LIKE '$find'";

if ($min_price > 0) {
    $filter_query .= " AND productPrice >= $min_price";
}
if ($max_price < PHP_INT_MAX) {
    $filter_query .= " AND productPrice <= $max_price";
}
if ($brand != '') {
    $filter_query .= " AND brand = '$brand'";
}
if ($quality != '') {
    $filter_query .= " AND quality = '$quality'";
}

$result = mysqli_query($con, $filter_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <title>Product Category</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Customizable CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/green.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <link href="assets/css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/rateit.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

    <!-- Demo Purpose Only. Should be removed in production -->
    <link rel="stylesheet" href="assets/css/config.css">
    <link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
    <link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
    <link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
    <link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
    <link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Fonts --> 
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- Google Translate -->
    <style type="text/css">
        /* Hide Google Translate Toolbar */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        } 
        body {
            top: 0px !important; 
        }
    </style>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>
<body class="cnt-home">
    <!-- Google Translate Widget -->
    <div id="google_translate_element" style="position: absolute; top: 0; right: 0; z-index: 9999;"></div>
    
    <header class="header-style-1">
        <!-- ============================================== TOP MENU ============================================== -->
        <?php include('includes/top-header.php');?>
        <!-- ============================================== TOP MENU : END ============================================== -->
        <?php include('includes/main-header.php');?>
        <!-- ============================================== NAVBAR ============================================== -->
        <?php include('includes/menu-bar.php');?>
        <!-- ============================================== NAVBAR : END ============================================== -->
    </header>
    <!-- ============================================== HEADER : END ============================================== -->
    
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row outer-bottom-sm'>
                <div class='col-md-3 sidebar'>
                    <!-- ================================== TOP NAVIGATION ================================== -->
                    <div class="side-menu animate-dropdown outer-bottom-xs">
                        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Sub Categories</div>        
                        <nav class="yamm megamenu-horizontal" role="navigation">
                            <ul class="nav">
                                <li class="dropdown menu-item">
                                    <?php 
                                    $sql = mysqli_query($con, "SELECT id, subcategory FROM subcategory");
                                    while ($row = mysqli_fetch_array($sql)) {
                                    ?>
                                    <a href="sub-category.php?scid=<?php echo $row['id'];?>" class="dropdown-toggle">
                                        <i class="icon fa fa-desktop fa-fw"></i>
                                        <?php echo $row['subcategory'];?>
                                    </a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </nav>
                    </div><!-- /.side-menu -->

                    <!-- ================================== TOP NAVIGATION : END ================================== -->
                    <div class="sidebar-module-container">
                        <h3 class="section-title">shop by</h3>
                        <div class="sidebar-filter">
                            <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                            <div class="sidebar-widget wow fadeInUp outer-bottom-xs">
                                <div class="widget-header m-t-20">
                                    <h4 class="widget-title">Category</h4>
                                </div>
                                <div class="sidebar-widget-body m-t-10">
                                    <?php 
                                    $sql = mysqli_query($con, "SELECT id, categoryName FROM category");
                                    while ($row = mysqli_fetch_array($sql)) {
                                    ?>
                                    <div class="accordion">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a href="category.php?cid=<?php echo $row['id'];?>" class="accordion-toggle collapsed">
                                                   <?php echo $row['categoryName'];?>
                                                </a>
                                            </div>  
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div><!-- /.sidebar-widget-body -->
                            </div><!-- /.sidebar-widget -->

                            <!-- ============================================== COLOR: END ============================================== -->
                        </div><!-- /.sidebar-filter -->
                    </div><!-- /.sidebar-module-container -->
                </div><!-- /.sidebar -->
                
                <div class='col-md-9'>
                    <!-- ========================================== SECTION – HERO ========================================= -->
                    <div id="category" class="category-carousel hidden-xs">
                        <div class="item">    
                            <div class="image">
                                <img src="assets/images/banners/cat-banner-3.jpg" alt="" class="img-responsive">
                            </div>
                            <div class="container-fluid">
                                <div class="caption vertical-top text-left">
                                    <div class="big-text">
                                        <br />
                                    </div>
                                </div><!-- /.caption -->
                            </div><!-- /.container-fluid -->
                        </div>
                    </div>

                    <!-- Search and Filter Form -->
                    <form method="POST" action="category.php">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="price_min">Min Price:</label>
                                <input type="number" id="price_min" name="price_min" class="form-control" value="<?php echo $min_price; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="price_max">Max Price:</label>
                                <input type="number" id="price_max" name="price_max" class="form-control" value="<?php echo $max_price; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="brand">Brand:</label>
                                <input type="text" id="brand" name="brand" class="form-control" value="<?php echo $brand; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="quality">Quality:</label>
                                <input type="text" id="quality" name="quality" class="form-control" value="<?php echo $quality; ?>">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </form>

                    <div class="search-result-container">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane active" id="grid-container">
                                <div class="category-product inner-top-vs">
                                    <div class="row">                                    
                                        <?php
                                        $num = mysqli_num_rows($result);
                                        if ($num > 0) {
                                            while ($row = mysqli_fetch_array($result)) { ?>                            
                                            <div class="col-sm-6 col-md-4 wow fadeInUp">
                                                <div class="products">                
                                                    <div class="product">        
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                                    <img src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" width="200" height="300">
                                                                </a>
                                                            </div><!-- /.image -->                               
                                                        </div><!-- /.product-image -->
                                                        
                                                        <div class="product-info text-left">
                                                            <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="description"></div>
                                                            <div class="product-price">    
                                                                <span class="price">
                                                                    Rs. <?php echo htmlentities($row['productPrice']);?>
                                                                </span>
                                                                <span class="price-before-discount">Rs. <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                                                            </div><!-- /.product-price -->
                                                        </div><!-- /.product-info -->
                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    <li class="add-cart-button btn-group">
                                                                        <?php if ($row['productAvailability'] == 'In Stock') { ?>
                                                                            <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                                                                <i class="fa fa-shopping-cart"></i>                                                
                                                                            </button>
                                                                            <a href="category.php?page=product&action=add&id=<?php echo $row['id']; ?>">
                                                                                <button class="btn btn-primary" type="button">Add to cart</button>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <div class="action" style="color:red">Out of Stock</div>
                                                                        <?php } ?>
                                                                    </li>
                                                                    <li class="lnk wishlist">
                                                                        <a class="add-to-cart" href="category.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="Wishlist">
                                                                            <i class="icon fa fa-heart"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div><!-- /.action -->
                                                        </div><!-- /.cart -->
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } 
                                        } else { ?>
                                            <div class="col-sm-6 col-md-4 wow fadeInUp">
                                                <h3>No Product Found</h3>
                                            </div>
                                        <?php } ?>  
                                    </div><!-- /.row -->
                                </div><!-- /.category-product -->
                            </div><!-- /.tab-pane -->
                        </div><!-- /.search-result-container -->
                    </div><!-- /.col -->
                </div>
            </div>
            <?php include('includes/brands-slider.php');?>
        </div>
    </div>
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/echo.min.js"></script>
    <script src="assets/js/jquery.easing-1.3.min.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- For demo purposes – can be removed on production -->
    <script src="switchstylesheet/switchstylesheet.js"></script>
    <script>
        $(document).ready(function() { 
            $(".changecolor").switchstylesheet({ seperator:"color" });
            $('.show-theme-options').click(function(){
                $(this).parent().toggleClass('open');
                return false;
            });
        });

        $(window).bind("load", function() {
            $('.show-theme-options').delay(2000).trigger('click');
        });
    </script>
    <!-- For demo purposes – can be removed on production : End -->
</body>
</html>
