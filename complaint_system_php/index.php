<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Complaint System</title>
    <style>
        body { font-family: Arial; text-align: center; }
        form { width: 300px; margin: auto; }
        input, textarea, select {
            width: 100%; padding: 8px; margin: 5px;
        }
        button { padding: 8px 15px; }
    </style>
</head>

<body>

<h2>Register Complaint</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Email" required>

    <select name="org">
        <option>PMC</option>
        <option>PMT</option>
        <option>Other</option>
    </select>

    <textarea name="complaint" placeholder="Write complaint" required></textarea>

    <button type="submit" name="submit">Submit</button>
</form>

<br>
<a href="view.php">View Complaints</a>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $org = $_POST['org'];
    $comp = $_POST['complaint'];

    mysqli_query($conn, "INSERT INTO complaints (name, email, organization, complaint)
    VALUES ('$name','$email','$org','$comp')");

    echo "<p>Complaint Submitted!</p>";
}
?>

</body>
</html>