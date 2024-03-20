<?php
// Include database connection
include('db_conn.php');

$order_details = array(); // Initialize array to store order details

// Process order when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_id = $_POST["product"];
    $quantity = $_POST["quantity"];
    $customer_name = $_POST["customer_name"];

    // Fetch products from the database
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    // Check if products exist
    if ($result->num_rows > 0) {
        $products = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $products = array(); // If no products found, initialize an empty array
    }

    // Check if the selected product exists
    $selected_product = null;
    foreach ($products as $product) {
        if ($product['id'] == $product_id) {
            $selected_product = $product;
            break;
        }
    }

    if ($selected_product) {
        // Calculate total price
        $total_price = $selected_product['price'] * $quantity;

        // Insert order into the database
        $sql = "INSERT INTO orders (product_id, quantity, customer_name, total_price, order_date) 
                VALUES ($product_id, $quantity, '$customer_name', $total_price, NOW())";

        if ($conn->query($sql) === TRUE) {
            // Fetch the details of the inserted order
            $order_id = $conn->insert_id;
            $sql = "SELECT * FROM orders WHERE order_id = $order_id";
            $result = $conn->query($sql);
            
            if ($result->num_rows == 1) {
                $order_details = $result->fetch_assoc();
            }
        } else {
            echo "Error placing order: " . $conn->error;
        }
    } else {
        echo "Selected product not found";
    }
}

// Fetch products from the database (again, to display in the form)
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if products exist
if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = array(); // If no products found, initialize an empty array
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
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
        .order-details {
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<h2>Place Order</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="product">Select Product:</label>
    <select id="product" name="product" required>
        <option value="">Select Product</option>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" required><br>

    <label for="customer_name">Customer Name:</label>
    <input type="text" id="customer_name" name="customer_name" required><br>

    <input type="submit" value="Place Order">
</form>

<?php if (!empty($order_details)): ?>
    <div class="order-details">
        <h3>Order Details</h3>
        <p><strong>Order ID:</strong> <?php echo $order_details['order_id']; ?></p>
        <p><strong>Product:</strong> <?php echo $selected_product['name']; ?></p>
        <p><strong>Quantity:</strong> <?php echo $order_details['quantity']; ?></p>
        <p><strong>Total Price:</strong> $<?php echo $order_details['total_price']; ?></p>
        <p><strong>Customer Name:</strong> <?php echo $order_details['customer_name']; ?></p>
        <p><strong>Order Date:</strong> <?php echo $order_details['order_date']; ?></p>
    </div>
    <br>  <h3><font color="green">!!! Order placed !!!</font><h3>
<?php endif; ?>
        <br>
        <a href="index.php">BACK</a>
</body>
</html>
