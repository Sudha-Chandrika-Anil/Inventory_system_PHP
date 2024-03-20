<?php

// Function to add a product
function addProduct($name, $description, $quantity, $price, $category) {
    global $conn;
    $sql = "INSERT INTO products (name, description, quantity, price, category) 
            VALUES ('$name', '$description', $quantity, $price, '$category')";
            
    include('db_conn.php');
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    // Add product to database
    addProduct($name, $description, $quantity, $price, $category);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Add Product</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="description">Description:</label>
    <input type="text" id="description" name="description"><br>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" required><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" min="0.01" step="0.01" required><br>

    <label for="category">Category:</label>
    <select id="category" name="category" required>
        <option value="Electronics">Electronics</option>
        <option value="Clothing">Clothing</option>
        <option value="Books">Books</option>
        <!-- Add more categories as needed -->
    </select><br>

    <input type="submit" value="Add Product">
</form>

</body>
</html>

<?php
$conn->close();
?>
