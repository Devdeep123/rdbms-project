<?php
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

if(isset($_POST['add_to_cart'])) {
    // Check if user is logged in
    if(isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $sql_insert_cart = "INSERT INTO cart (customer_id, product_id, quantity) VALUES ('$customer_id', '$product_id', '$quantity')";
        if ($conn->query($sql_insert_cart) === TRUE) {
            echo "Product added to cart successfully";
        } else {
            echo "Error adding product to cart: " . $conn->error;
        }
    } else {
        // Redirect to index.php if user is not logged in or signed up
        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <a href="cart.php" class="cart-btn">Cart</a>
    <a href="profile.php" class="profile-btn">Profile</a>
    <h1>Welcome to the Inventory Management System</h1>

    <?php
    // Display categories
    $sql_categories = "SELECT * FROM Category";
    $result_categories = $conn->query($sql_categories);

    if ($result_categories === false) {
        echo "Error retrieving categories: " . $conn->error;
    } elseif ($result_categories->num_rows > 0) {
        while($row = $result_categories->fetch_assoc()) {
            echo '<div class="category">' . $row["Name"] . '</div>';
            
            // Display products under each category
            $sql_products_category = "SELECT * FROM Product WHERE Category_id = " . $row["Category_id"];
            $result_products_category = $conn->query($sql_products_category);

            if ($result_products_category->num_rows > 0) {
                while($product = $result_products_category->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<span>' . $product["Name"] . ' - $' . $product["Price"] . '</span>';
                    echo '<form method="post">';
                    echo '<input type="hidden" name="product_id" value="' . $product["Product_id"] . '">';
                    echo '<input type="hidden" name="quantity" value="1">';
                    echo '<input type="submit" name="add_to_cart" value="Add to Cart">';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "No products in this category.";
            }
        }
    } else {
        echo "No categories found.";
    }

    $conn->close();
    ?>
</body>
</html>