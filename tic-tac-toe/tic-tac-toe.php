<?php
session_start();

// Initialize board
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, "");
    $_SESSION['turn'] = "X";
}

// Handle move
if (isset($_POST['cell'])) {
    $i = $_POST['cell'];

    if ($_SESSION['board'][$i] == "") {
        $_SESSION['board'][$i] = $_SESSION['turn'];
        $_SESSION['turn'] = ($_SESSION['turn'] == "X") ? "O" : "X";
    }
}

// Reset game
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: tic-tac-toe.php");
    exit();
}

// Check winner
function checkWinner($b) {
    $wins = [
        [0,1,2],[3,4,5],[6,7,8],
        [0,3,6],[1,4,7],[2,5,8],
        [0,4,8],[2,4,6]
    ];

    foreach ($wins as $w) {
        if ($b[$w[0]] && $b[$w[0]] == $b[$w[1]] && $b[$w[1]] == $b[$w[2]]) {
            return $b[$w[0]];
        }
    }
    return "";
}

$winner = checkWinner($_SESSION['board']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tic Tac Toe</title>
    <style>
        body { text-align: center; font-family: Arial; }
        table { margin: auto; border-collapse: collapse; }
        td {
            width: 80px;
            height: 80px;
            border: 2px solid black;
            font-size: 30px;
        }
        button {
            width: 100%;
            height: 100%;
            font-size: 25px;
            border: none;
            background: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Tic Tac Toe</h2>

<h3>
<?php
if ($winner) {
    echo "Winner: $winner 🎉";
} else {
    echo "Turn: " . $_SESSION['turn'];
}
?>
</h3>

<form method="POST">
<table>
<?php
for ($i = 0; $i < 9; $i++) {
    if ($i % 3 == 0) echo "<tr>";

    echo "<td>";
    echo "<button name='cell' value='$i'>" . $_SESSION['board'][$i] . "</button>";
    echo "</td>";

    if ($i % 3 == 2) echo "</tr>";
}
?>
</table>

<br>
<button name="reset">Reset Game</button>
</form>

</body>
</html>