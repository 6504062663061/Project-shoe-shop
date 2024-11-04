<?php include "../../connect.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Member - ChicFoot</title>
    <link rel="stylesheet" href="../../css/index.css">
</head>
<body>
<?php include '../../Template/navbar.php'; ?>

<div class="container">
    <?php
        if (isset($_GET['username'])) {
            $username = $_GET['username'];
            $stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = ?");
            $stmt->bindParam(1, $username);
            $stmt->execute();
            $row = $stmt->fetch();

            if (!$row) {
                echo "<p>Member not found.</p>";
                exit;
            }
        } else {
            echo "<p>No member specified.</p>";
            exit;
        }
    ?>

    <h2>Edit Member</h2>
    <form action="editM_update.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $row['Username']; ?>">
        
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $row['Name']; ?>" maxlength="50" required><br>

        <label for="address">Address:</label>
        <textarea name="address" maxlength="200" required><?php echo $row['Address']; ?></textarea><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo $row['Phone']; ?>" maxlength="12" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $row['Email']; ?>" maxlength="30" required><br>

        <label for="status">Status:</label>
        <input type="text" name="status" value="<?php echo $row['Status']; ?>" maxlength="10" required><br>

        <button type="submit">Update Member</button>
    </form>
</div>

<?php include '../../Template/footer.php'; ?>
</body>
</html>
