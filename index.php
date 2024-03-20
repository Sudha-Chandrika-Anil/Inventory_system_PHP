<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #45a049;
        }
        .button-secondary {
            background-color: #008CBA;
        }
        .button-secondary:hover {
            background-color: #0077a3;
        }
        .button-warning {
            background-color: #f44336;
        }
        .button-warning:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Inventory Management System</h1>
    <div style="text-align: center;">
        <a href="place_order.php" class="button button-warning">Place Order</a>
        <a href="login.php" class="button">Login</a>
    </div>

    <hr>

    <h2>Recent Product Additions</h2>
    <ul>
        <?php
        // Include database connection
        include('db_conn.php');
        
        // Retrieve recent products from the database
        $sql = "SELECT name FROM products ORDER BY id DESC LIMIT 4"; // Assuming 'name' is the column for product name
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<li>" . $row["name"] . "</li>";
            }
        } else {
            echo "No recent products";
        }
        ?>
    </ul>

    <hr>

    
</div>

</body>
</html>
