<?php
session_start();
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

if(isset($_POST['login'])) {
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customer WHERE Contact='$contact'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Compare plain-text password with stored hash
        if ($password == $row['password']) {
            // Password is correct, set customer_id in session
            $_SESSION['customer_id'] = $row['Customer_ID'];
            header("Location: booking.php");
            exit(); // Ensure that code execution stops here
        } else {
            // Show an error message using JavaScript
            echo '<script>alert("Invalid contact number or password");</script>';
        }
    } else {
        // Show an error message using JavaScript
        echo '<script>alert("Invalid contact number or password");</script>';
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles6.css">
</head>
<body>
    <div class="form-container">
        <h2>Login to your account</h2>
        <form method="post">
            <label for="contact">Contact Number:</label><br>
            <input type="text" id="contact" name="contact" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" name="login" value="Login">
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</body>
</html>
