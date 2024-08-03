<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
} else {
    if (isset($_POST['submit'])) {
        $paymentMethod = $_POST['paymethod'];
        mysqli_query($con, "UPDATE orders SET paymentMethod='$paymentMethod' WHERE userId='".$_SESSION['id']."' AND paymentMethod IS NULL");
        unset($_SESSION['cart']);
        header('location:order-history.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and CSS links here -->
    <title>Universal Mart | Payment Method</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- Other stylesheets -->
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
        <?php include('includes/top-header.php');?>
        <?php include('includes/main-header.php');?>
        <?php include('includes/menu-bar.php');?>
    </header>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="home.html">Home</a></li>
                    <li class='active'>Payment Method</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-bd">
        <div class="container">
            <div class="checkout-box faq-page inner-bottom-sm">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Choose Payment Method</h2>
                        <div class="panel-group checkout-steps" id="accordion">
                            <div class="panel panel-default checkout-step-01">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                            Select your Payment Method
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <form name="payment" method="post" id="payment-form">
                                            <input type="radio" name="paymethod" value="COD" checked="checked"> COD
                                            <input type="radio" name="paymethod" value="UPI" id="upi-option"> UPI Payment
                                            <input type="radio" name="paymethod" value="NETBANKING" id="netbanking-option"> Net Banking
                                            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/brands-slider.php');?>
        </div>
    </div>
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Other scripts -->
    <script>
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            var upiOption = document.getElementById('upi-option');
            var netbankingOption = document.getElementById('netbanking-option');
            
            if (upiOption.checked) {
                e.preventDefault();
                var upiId = 'm.kirkat-1@okicici';
                var amount = '10.00'; // The amount to be paid
                var upiUrl = 'upi://pay?pa=' + upiId + '&pn=YourName&am=' + amount + '&cu=INR';
                window.location.href = upiUrl;
            } else if (netbankingOption.checked) {
                e.preventDefault();
                // Redirect or show relevant Net Banking page
                window.location.href = 'netbanking.html'; // Adjust URL as necessary
            }
        });
    </script>
</body>
</html>
<?php } ?>
