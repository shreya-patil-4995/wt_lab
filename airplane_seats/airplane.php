<?php
session_start();

// Initialize seats (5 rows × 4 seats)
if (!isset($_SESSION['seats'])) {
    $_SESSION['seats'] = [];

    $rows = 5;
    $cols = ['A','B','C','D'];

    foreach ($cols as $c) {
        for ($r = 1; $r <= $rows; $r++) {
            $_SESSION['seats'][$c.$r] = "available";
        }
    }
}

// Handle booking
if (isset($_POST['seat'])) {
    $seat = $_POST['seat'];

    if ($_SESSION['seats'][$seat] == "available") {
        $_SESSION['seats'][$seat] = "booked";
    }
}

// Reset
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Airplane Seat Booking</title>

    <style>
        body {
            text-align: center;
            font-family: Arial;
        }

        table {
            margin: auto;
            border-spacing: 10px;
        }

        td {
            width: 60px;
            height: 60px;
        }

        button {
            width: 100%;
            height: 100%;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .available {
            background-color: green;
            color: white;
        }

        .booked {
            background-color: red;
            color: white;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

<h2>Airplane Seat Booking</h2>

<form method="POST">
<table>

<?php
$cols = ['A','B','C','D'];
$rows = 5;

for ($r = 1; $r <= $rows; $r++) {
    echo "<tr>";

    foreach ($cols as $c) {
        $seat = $c.$r;
        $status = $_SESSION['seats'][$seat];

        echo "<td>";

        if ($status == "available") {
            echo "<button class='available' name='seat' value='$seat'>$seat</button>";
        } else {
            echo "<button class='booked' disabled>$seat</button>";
        }

        echo "</td>";
    }

    echo "</tr>";
}
?>

</table>

<br>
<button name="reset">Reset All</button>
</form>

</body>
</html>