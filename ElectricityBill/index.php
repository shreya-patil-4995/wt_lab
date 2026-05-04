<?php
$bill = 0;
$units = 0;
$name = "";
$error = "";
$calculated = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $units = trim($_POST["units"]);

    if (empty($name)) {
        $error = "Please enter customer name.";
    } elseif (!is_numeric($units) || $units < 0) {
        $error = "Please enter a valid number of units.";
    } else {
        $units = floatval($units);

        if ($units <= 50) {
            $bill = $units * 3.50;
        } elseif ($units <= 150) {
            $bill = (50 * 3.50) + (($units - 50) * 4.00);
        } elseif ($units <= 250) {
            $bill = (50 * 3.50) + (100 * 4.00) + (($units - 150) * 5.20);
        } else {
            $bill = (50 * 3.50) + (100 * 4.00) + (100 * 5.20) + (($units - 250) * 6.50);
        }

        $calculated = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bill Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 5px;
        }

        p.subtitle {
            text-align: center;
            color: #666;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 9px;
            margin-bottom: 16px;
            border: 1px solid #bbb;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #2c7be5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #1a5ec4;
        }

        .error {
            color: red;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .result {
            margin-top: 20px;
            background-color: #eaf3ff;
            border: 1px solid #b3d1f7;
            padding: 15px 20px;
            border-radius: 5px;
        }

        .result h3 {
            margin-top: 0;
            color: #2c7be5;
        }

        .result table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .result table td {
            padding: 6px 4px;
            color: #333;
        }

        .result table td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .total-row td {
            border-top: 1px solid #b3d1f7;
            padding-top: 10px;
            font-size: 16px;
            color: #1a5ec4;
        }

        .rate-table {
            margin-top: 30px;
            font-size: 13px;
        }

        .rate-table h4 {
            color: #555;
            margin-bottom: 6px;
        }

        .rate-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .rate-table th, .rate-table td {
            border: 1px solid #ddd;
            padding: 7px 10px;
            text-align: left;
        }

        .rate-table th {
            background-color: #e8eef6;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>⚡ Electricity Bill Calculator</h2>
    <p class="subtitle">Enter details below to calculate your electricity bill</p>

    <form method="POST" action="">
        <label for="name">Customer Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter customer name"
               value="<?php echo htmlspecialchars($name); ?>">

        <label for="units">Units Consumed:</label>
        <input type="number" id="units" name="units" placeholder="Enter units consumed"
               value="<?php echo htmlspecialchars($units > 0 ? $units : ''); ?>" min="0" step="0.01">

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <input type="submit" value="Calculate Bill">
    </form>

    <?php if ($calculated): ?>
        <div class="result">
            <h3>Bill Summary</h3>
            <table>
                <tr>
                    <td>Customer Name</td>
                    <td><?php echo htmlspecialchars($name); ?></td>
                </tr>
                <tr>
                    <td>Units Consumed</td>
                    <td><?php echo $units; ?> units</td>
                </tr>
                <?php if ($units <= 50): ?>
                    <tr><td>First <?php echo $units; ?> units × ₹3.50</td><td>₹<?php echo number_format($units * 3.50, 2); ?></td></tr>
                <?php elseif ($units <= 150): ?>
                    <tr><td>First 50 units × ₹3.50</td><td>₹<?php echo number_format(50 * 3.50, 2); ?></td></tr>
                    <tr><td>Next <?php echo ($units - 50); ?> units × ₹4.00</td><td>₹<?php echo number_format(($units - 50) * 4.00, 2); ?></td></tr>
                <?php elseif ($units <= 250): ?>
                    <tr><td>First 50 units × ₹3.50</td><td>₹<?php echo number_format(50 * 3.50, 2); ?></td></tr>
                    <tr><td>Next 100 units × ₹4.00</td><td>₹<?php echo number_format(100 * 4.00, 2); ?></td></tr>
                    <tr><td>Next <?php echo ($units - 150); ?> units × ₹5.20</td><td>₹<?php echo number_format(($units - 150) * 5.20, 2); ?></td></tr>
                <?php else: ?>
                    <tr><td>First 50 units × ₹3.50</td><td>₹<?php echo number_format(50 * 3.50, 2); ?></td></tr>
                    <tr><td>Next 100 units × ₹4.00</td><td>₹<?php echo number_format(100 * 4.00, 2); ?></td></tr>
                    <tr><td>Next 100 units × ₹5.20</td><td>₹<?php echo number_format(100 * 5.20, 2); ?></td></tr>
                    <tr><td>Above 250: <?php echo ($units - 250); ?> units × ₹6.50</td><td>₹<?php echo number_format(($units - 250) * 6.50, 2); ?></td></tr>
                <?php endif; ?>
                <tr class="total-row">
                    <td>Total Bill Amount</td>
                    <td>₹<?php echo number_format($bill, 2); ?></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>

    <div class="rate-table">
        <h4>Rate Chart:</h4>
        <table>
            <tr>
                <th>Units</th>
                <th>Rate (per unit)</th>
            </tr>
            <tr><td>First 50 units</td><td>₹3.50</td></tr>
            <tr><td>51 – 150 units</td><td>₹4.00</td></tr>
            <tr><td>151 – 250 units</td><td>₹5.20</td></tr>
            <tr><td>Above 250 units</td><td>₹6.50</td></tr>
        </table>
    </div>
</div>

</body>
</html>
