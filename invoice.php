<?php
session_start();
include_once 'includes/config.php';

if(strlen($_SESSION['login']) == 0) {   
    header('location:login.php');
} else {
    $oid = intval($_GET['oid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="anuj.css" type="text/css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f7;
            color: #333;
        }
        .container {
            margin: 50px auto;
            padding: 20px;
            max-width: 800px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #00695c;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #004d40;
            color: white;
        }
        td {
            background-color: #e0f2f1;
        }
        tr:hover td {
            background-color: #b2dfdb;
        }
        button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px 0;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
            background-color: #00796b;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #004d40;
        }
        button:active {
            background-color: #00251a;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Universal Mart</h1>
    <h1>Invoice Details</h1>
    <table>
        <tr>
            <th>Order ID</th>
            <td><?php echo $oid; ?></td>
        </tr>
        <?php 
        $query = mysqli_query($con, "SELECT products.productName as pname, orders.quantity as qty, products.productPrice as pprice, products.shippingCharge as shippingcharge, orders.paymentMethod as paym, orders.orderDate as odate, orders.orderStatus as ostatus FROM orders JOIN products ON orders.productId = products.id WHERE orders.id = '$oid'");
        $row = mysqli_fetch_array($query);
        if($row) {
        ?>
        <tr>
            <th>Product Name</th>
            <td><?php echo $row['pname']; ?></td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td><?php echo $row['qty']; ?></td>
        </tr>
        <tr>
            <th>Price Per Unit</th>
            <td><?php echo $row['pprice']; ?></td>
        </tr>
        <tr>
            <th>Shipping Charge</th>
            <td><?php echo $row['shippingcharge']; ?></td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <td><?php echo ($row['qty'] * $row['pprice']) + $row['shippingcharge']; ?></td>
        </tr>
        <tr>
            <th>Payment Method</th>
            <td><?php echo $row['paym']; ?></td>
        </tr>
        <tr>
            <th>Order Date</th>
            <td><?php echo $row['odate']; ?></td>
        </tr>
        <tr>
            <th>Order Status</th>
            <td><?php echo $row['ostatus']; ?></td>
        </tr>
        <?php } else { ?>
        <tr>
            <td colspan="2">No details found for this order.</td>
        </tr>
        <?php } ?>
    </table>

    <div style="text-align: center;">
        <button onclick="window.print();">Print</button>
        <button onclick="window.close();">Close</button>
    </div>
</div>

</body>
</html>

<?php
}
?>
