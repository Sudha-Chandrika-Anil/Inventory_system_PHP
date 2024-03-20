<?php
// Include database connection
include('db_conn.php');

// Check if product ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete product from the database
    $sql = "DELETE FROM products WHERE id=$product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    echo "Product ID not provided";
}

// Redirect back to manage_products page after deletion
header("Location: manage_products.php");
exit();
?>
