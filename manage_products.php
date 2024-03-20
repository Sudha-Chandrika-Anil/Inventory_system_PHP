<?php
// Include database connection
include('db_conn.php');

// Function to retrieve all products
function getProducts() {
    global $conn;
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}

// Check if form is submitted for adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    // Add product to database
    $sql = "INSERT INTO products (name, description, quantity, price, category) 
            VALUES ('$name', '$description', $quantity, $price, '$category')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
        // Redirect to prevent form resubmission
        header("Location: manage_products.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve updated product list
$products = getProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .add-product-form {
            margin-bottom: 20px;
        }
        .add-product-form input[type="text"], 
        .add-product-form input[type="number"] {
            padding: 8px;
            width: 200px;
            margin-right: 10px;
        }
        .add-product-form input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-product-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Manage Products</h2>

<div class="add-product-form">
    <form action="" method="post">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="submit" value="Add Product">
    </form>
</div>

<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Category</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['description']; ?></td>
            <td><?php echo $product['quantity']; ?></td>
            <td>₹<?php echo $product['price']; ?></td>
            <td><?php echo $product['category']; ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
        <br>
        <a href="index.php">BACK</a>
</body>
</html>
