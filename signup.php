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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if password and confirm password match
    if ($_POST['password'] !== $_POST['confirm_password']) {
        echo "Passwords do not match";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO customer (Name, Address_city, Address_state, Address_pincode, Contact, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $city, $state, $pincode, $contact, $password);

        // Set parameters and execute
        $name = $_POST['name'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $pincode = $_POST['pincode'];
        $contact = $_POST['contact'];
        $password = $_POST['password']; // No hashing
        $stmt->execute();

        echo "New record created successfully";

        $stmt->close();

        header("Location: booking.php");
        exit();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Customer Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Registration</h1>
        <form action="" method="POST">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="city">City:</label><br>
            <input type="text" id="city" name="city" required><br><br>
            
            <label for="state">State:</label><br>
            <input type="text" id="state" name="state" required><br><br>
            
            <label for="pincode">Pincode:</label><br>
            <input type="text" id="pincode" name="pincode" required><br><br>
            
            <label for="contact">Contact:</label><br>
            <input type="text" id="contact" name="contact" required><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            
            <input type="submit" value="Sign-up">
        </form>
    </div>
</body>
</html>