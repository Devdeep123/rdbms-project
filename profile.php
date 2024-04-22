<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Enable output buffering
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session
$servername = "localhost";
$username = "root";
$password = "Dmdgd24552423+";
$dbname = "InventoryManagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if(isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];

    // Get customer details
    $sql_customer = "SELECT * FROM customer WHERE Customer_ID = '$customer_id'";
    $result_customer = $conn->query($sql_customer);
    $customer = $result_customer->fetch_assoc();

    // Get order information
    $sql_orders = "SELECT * FROM customer_order WHERE Customer_ID = '$customer_id'";
    $result_orders = $conn->query($sql_orders);
} else {
    // Redirect to login if not logged in
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="styles7.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .profile-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h1>Welcome to your Profile</h1>
    <div class="profile-details">
        <h2>Customer Details</h2>
        <p><strong>Name:</strong> <?php echo $customer['Name']; ?></p>
        <p><strong>Contact:</strong> <?php echo $customer['Contact']; ?></p>
        <p><strong>Address:</strong> <?php echo $customer['Address_city'] . ', ' . $customer['Address_state'] . ' - ' . $customer['Address_pincode']; ?></p>
    </div>
    <h2>Order Information</h2>
    <table>
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_orders->num_rows > 0) {
                while($order = $result_orders->fetch_assoc()) {
                    $order_no = $order['Order_no'];
                    $sql_order_info = "SELECT * FROM orders WHERE Order_no = '$order_no'";
                    $result_order_info = $conn->query($sql_order_info);
                    $order_info = $result_order_info->fetch_assoc();
                    echo "<tr>";
                    echo "<td>" . $order_no . "</td>";
                    echo "<td>" . $order_info['Date'] . "</td>";
                    echo "<td>$" . $order_info['Amount'] . "</td>";
                    echo "<td>" . $order_info['Status'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
