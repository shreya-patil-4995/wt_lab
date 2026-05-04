<?php
include 'db.php';

$message = "";

// INSERT
if (isset($_POST['insert'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($name) && !empty($email)) {
        $sql = "INSERT INTO students (name, email) VALUES ('$name', '$email')";
        if (mysqli_query($conn, $sql)) {
            $message = "Record inserted successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    } else {
        $message = "Please fill all fields.";
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id  = intval($_GET['delete']);
    $sql = "DELETE FROM students WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        $message = "Record deleted successfully!";
    }
}

// FETCH record for editing
$edit_record = null;
if (isset($_GET['edit'])) {
    $id  = intval($_GET['edit']);
    $res = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
    $edit_record = mysqli_fetch_assoc($res);
}

// UPDATE
if (isset($_POST['update'])) {
    $id    = intval($_POST['id']);
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE students SET name='$name', email='$email' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $message = "Record updated successfully!";
        $edit_record = null;
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// FETCH all records
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student DB Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #aaa;
            padding-bottom: 5px;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
            background: #fff;
            padding: 25px 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 70px;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"] {
            padding: 6px 10px;
            width: 250px;
            border: 1px solid #bbb;
            border-radius: 3px;
            font-size: 14px;
            margin-bottom: 8px;
        }

        input[type="submit"] {
            padding: 7px 18px;
            background-color: #4a7fcb;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #3a6ab5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        th {
            background-color: #4a7fcb;
            color: white;
            padding: 9px 12px;
            text-align: left;
        }

        td {
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f0f4ff;
        }

        a {
            text-decoration: none;
            color: #4a7fcb;
            margin-right: 8px;
            font-size: 13px;
        }

        a.del-link {
            color: #c0392b;
        }

        a:hover {
            text-decoration: underline;
        }

        .no-records {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Database Operations (PHP + MySQL)</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- INSERT / UPDATE Form -->
    <h2><?= $edit_record ? "Update Record" : "Insert Record" ?></h2>
    <form method="POST" action="index.php">
        <?php if ($edit_record): ?>
            <input type="hidden" name="id" value="<?= $edit_record['id'] ?>">
        <?php endif; ?>

        <label>Name:</label>
        <input type="text" name="name" required
            value="<?= $edit_record ? htmlspecialchars($edit_record['name']) : '' ?>">
        <br>

        <label>Email:</label>
        <input type="email" name="email" required
            value="<?= $edit_record ? htmlspecialchars($edit_record['email']) : '' ?>">
        <br><br>

        <?php if ($edit_record): ?>
            <input type="submit" name="update" value="Update Record">
            <a href="index.php" style="margin-left:10px;">Cancel</a>
        <?php else: ?>
            <input type="submit" name="insert" value="Insert Record">
        <?php endif; ?>
    </form>

    <!-- DISPLAY Records -->
    <h2>All Students</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <a href="index.php?edit=<?= $row['id'] ?>">Edit</a>
                        <a class="del-link"
                           href="index.php?delete=<?= $row['id'] ?>"
                           onclick="return confirm('Delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-records">No records found. Insert a record above.</p>
    <?php endif; ?>

</div>

</body>
</html>
