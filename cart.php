<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="styles3.css">
</head>
<body>
    <div class="cart-container">
        <h1>Cart</h1>
        <div class="cart-items">
            <?php
            // Retrieve cart items from session or database
            $cartItems = [
                ["name" => "Product 1", "price" => 10.99, "quantity" => 2],
                ["name" => "Product 2", "price" => 20.49, "quantity" => 1]
            ];

            // Display cart items
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $subtotal = $item["price"] * $item["quantity"];
                $totalAmount += $subtotal;
                echo '<div class="cart-item">';
                echo '<span>' . $item["name"] . '</span>';
                echo '<span>Quantity: ' . $item["quantity"] . '</span>';
                echo '<span>Subtotal: $' . number_format($subtotal, 2) . '</span>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="total">
            <span>Total: $<?php echo number_format($totalAmount, 2); ?></span>
        </div>
        <div class="buttons">
            <a href="booking.php" class="back-btn">Back</a>
            <a href="add_contact.php" class="buy-now-btn">Buy Now</a>
        </div>
    </div>
</body>
</html>

