<?php
session_start();
require_once "config.php"; // Include database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnDelete'])) {
    // Handle deletion logic here
    $asset_number = $_POST['asset_number'];
    $delete_sql = "DELETE FROM tblEquipment WHERE asset_number = ?";
    if ($stmt = mysqli_prepare($link, $delete_sql)) {
        mysqli_stmt_bind_param($stmt, "s", $asset_number);
        mysqli_stmt_execute($stmt);
        // Optionally handle the result (success/failure)
    }
}

// Fetch equipment for display
$sql = "SELECT * FROM tblEquipment";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://thumbs.dreamstime.com/b/database-concept-database-digital-data-paper-background-database-concept-painted-multicolor-text-database-digital-data-paper-107428790.jpg');
            background-size: cover;
            color: #006400; /* Dark green text */
            text-align: center;
        }
        h1 {
            font-weight: bold;
            color: #004d00; /* Darker green for headings */
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 90%;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border: 2px solid #006400;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #006400;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
        th {
            background-color: #006400; /* Green header */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #e0f8e0; /* Light green for even rows */
        }
        tr:hover {
            background-color: #c1f0c1; /* Lighter green on hover */
        }
        input[type="text"], input[type="submit"], button {
            margin: 10px;
            padding: 10px;
            border: 2px solid #006400;
            border-radius: 5px;
            font-weight: bold;
        }
        input[type="submit"], button {
            background-color: #006400; /* Green button */
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #005700; /* Darker green on hover */
        }
        a {
            font-weight: bold;
            color: #004d00;
            text-decoration: none;
            margin: 10px;
        }
    </style>
</head>
<body>
    <h1>Equipment Management</h1>
    <form method="POST">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" name="btnsearch" value="Search">
        <a href="add-equipment.php">Add Equipment</a>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Asset Number</th>
                <th>Serial Number</th>
                <th>Type</th>
                <th>Department</th>
                <th>Status</th>
                <?php if ($user_role == 'ADMIN' || $user_role == 'TECHNICAL'): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($equipment = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($equipment['asset_number']) ?></td>
                    <td><?= htmlspecialchars($equipment['serial_number']) ?></td>
                    <td><?= htmlspecialchars($equipment['type']) ?></td>
                    <td><?= htmlspecialchars($equipment['department']) ?></td>
                    <td><?= htmlspecialchars($equipment['status']) ?></td>
                    <?php if ($user_role == 'ADMIN' || $user_role == 'TECHNICAL'): ?>
                        <td>
                            <a href='update-equipment.php?asset_number=<?= urlencode($equipment['asset_number']) ?>'>Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="asset_number" value="<?= htmlspecialchars($equipment['asset_number']) ?>">
                                <input type="submit" name="btnDelete" value="Delete">
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>