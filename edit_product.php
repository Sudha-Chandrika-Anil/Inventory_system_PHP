<?php
// Include database connection and product retrieval function
include('db_conn.php');

// Function to retrieve product details by ID
function getProductById($id) {
    global $conn;
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

// Check if product ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Retrieve product details by ID
    $product = getProductById($product_id);

    // If product not found, redirect to manage products page
    if (!$product) {
        header("Location: manage_products.php");
        exit();
    }
} else {
    // If product ID is not provided in the URL, redirect to manage products page
    header("Location: manage_products.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    // Update product details in the database
    $sql = "UPDATE products SET name='$name', description='$description', quantity=$quantity, price=$price, category='$category' WHERE id=$product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
        // Redirect to manage products page after updating
        header("Location: manage_products.php");
        exit(); // This is important to stop further execution of the script
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Edit Product</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $product_id); ?>">
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
    <input type="text" name="description" value="<?php echo $product['description']; ?>" required>
    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>
    <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
    <input type="text" name="category" value="<?php echo $product['category']; ?>" required>
    <input type="submit" value="Update Product">
</form>

</body>
</html>
