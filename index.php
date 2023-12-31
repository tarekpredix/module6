<?php
// Replace with your database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "business_model";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Task 1: Retrieve customer information with the total number of orders
$query_task1 = "
    SELECT Customers.name AS customer_name, COUNT(Orders.order_id) AS total_orders
    FROM Customers
    LEFT JOIN Orders ON Customers.customer_id = Orders.customer_id
    GROUP BY Customers.customer_id, Customers.name
    ORDER BY total_orders DESC;
";

$result_task1 = $conn->query($query_task1);

// Task 2: Retrieve product name, quantity, and total amount for each order item
$query_task2 = "
    SELECT OI.order_id, P.name AS product_name, OI.quantity, (OI.quantity * OI.unit_price) AS total_amount
    FROM Order_Items OI
    JOIN Products P ON OI.product_id = P.product_id
    ORDER BY OI.order_id ASC;

";

$result_task2 = $conn->query($query_task2);

// Task 3: Retrieve total revenue generated by each product category
$query_task3 = "
    SELECT Categories.name AS category_name, SUM(Order_Items.quantity * Order_Items.unit_price) AS total_revenue
    FROM Categories
    LEFT JOIN Products ON Categories.category_id = Products.category_id
    LEFT JOIN Order_Items ON Products.product_id = Order_Items.product_id
    GROUP BY Categories.category_id, Categories.name
    ORDER BY total_revenue DESC;
";

$result_task3 = $conn->query($query_task3);

// Task 4: Retrieve the top 5 customers with the highest total purchase amount
$query_task4 = "
    SELECT Customers.name AS customer_name, SUM(Order_Items.quantity * Order_Items.unit_price) AS total_purchase_amount
    FROM Customers
    LEFT JOIN Orders ON Customers.customer_id = Orders.customer_id
    LEFT JOIN Order_Items ON Orders.order_id = Order_Items.order_id
    GROUP BY Customers.customer_id, Customers.name
    ORDER BY total_purchase_amount DESC
    LIMIT 5;
";

$result_task4 = $conn->query($query_task4);

// Close the database connection when done
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Results</title>
    <!-- Include Bootstrap CSS styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-info mb-4">Task 1: Customer Information with Total Orders</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_task1->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['customer_name'] ?></td>
                        <td><?= $row['total_orders'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-4">
        <h2 class="text-info mb-4">Task 2: Product Information for Order Items</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_task2->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['order_id'] ?></td>
                        <td><?= $row['product_name'] ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= $row['total_amount'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-4">
        <h2 class="text-info mb-4">Task 3: Total Revenue by Product Category</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_task3->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['category_name'] ?></td>
                        <td><?= $row['total_revenue'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-4">
        <h2 class="text-info mb-4">Task 4: Top 5 Customers by Total Purchase Amount</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Total Purchase Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_task4->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['customer_name'] ?></td>
                        <td><?= $row['total_purchase_amount'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>


