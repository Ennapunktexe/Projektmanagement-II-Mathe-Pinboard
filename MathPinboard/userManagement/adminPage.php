<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        select {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database1";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["apply_role"])) {
    // Check if ID and role are provided
    if (isset($_POST['user_id'], $_POST['new_role'])) {
        $userId = $_POST['user_id'];
        $newRole = $_POST['new_role'];

        // Prevent changing the role for the admin user
        if ($userId == 1) {
            echo "Cannot change the role for the admin user.";
        } else {
            // Update the user's role
            $sqlUpdateRole = "UPDATE users SET role='$newRole' WHERE id=$userId";

            if ($conn->query($sqlUpdateRole) === TRUE) {
                echo "User role updated successfully.";
            } else {
                echo "Error updating user role: " . $conn->error;
            }
        }
    } else {
        echo "Invalid parameters.";
    }
}

// SQL query to fetch users
$sqlSelectUsers = "SELECT id, username, role FROM users";
$result = $conn->query($sqlSelectUsers);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Change Role to</th>
                <th>Reset user password</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['role']}</td>
                <td>";
        // Display dropdown for changing role
        echo "<form method='post' action='{$_SERVER["PHP_SELF"]}'>
                <input type='hidden' name='user_id' value='{$row['id']}'>
                <select name='new_role'>";
        // Define role options
        $roleOptions = ["user", "moderator"];
        foreach ($roleOptions as $option) {
            $selected = ($row['role'] == $option) ? 'selected' : '';
            echo "<option value='$option' $selected>$option</option>";
        }
        echo "</select>
                <button type='submit' name='apply_role'>Apply</button>
              </form>";
        echo "</td>
        <td><a href='reset_password.php?id={$row['id']}'>Reset Password</a></td>
        </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>

</body>
</html>
