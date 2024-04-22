<?php
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

if(isset($_POST['submit'])) {
    // Retrieve phone number from the form
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Retrieve customer ID using the phone number
    $customer_id = null;
    $get_customer_id_sql = "SELECT Customer_ID FROM customer WHERE Contact = '$phone'";
    $result = $conn->query($get_customer_id_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_id = $row["Customer_ID"];
    }

    // Generate a random order number
    $order_no = rand(1000, 9999);

    // Insert order data into the orders table
    $insert_order_sql = "INSERT INTO orders (Order_no, Date, Amount, Status) VALUES ($order_no, CURDATE(), 0, 'Pending')";
    if ($conn->query($insert_order_sql) === TRUE) {
        // Insert order data into the customer_order table using customer ID and order number
        if ($customer_id !== null) {
            $insert_customer_order_sql = "INSERT INTO customer_order (Customer_ID, Order_no) VALUES ($customer_id, $order_no)";
            if ($conn->query($insert_customer_order_sql) === TRUE) {
                echo "Order placed successfully!";
            } else {
                echo "Error inserting data into customer_order table: " . $conn->error;
            }
        } else {
            echo "Customer not found!";
        }
    } else {
        echo "Error inserting data into orders table: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Contact</title>
    <link rel="stylesheet" type="text/css" href="styles4.css">
</head>
<body>
    <div class="form-container">
        <h1>Add Contact</h1>
        <form action="place_order.php" method="POST">
            <label for="phone">Phone Number:</label><br>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required><br><br>
            
            <input type="submit" name="submit" value="Place Order" class="place-order-btn" formaction="place_order.php">
        </form>
        <a href="cart.php" class="back-btn">Back</a>
    </div>
</body>
</html>



