<?php include "../../connect.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot - Members</title>
    <link rel="stylesheet" href="../../css/index.css">
</head>
<body>
<?php include '../../Template/navbar.php'; ?>

<div class="container">
    <h1>Members</h1>
    <div>
    <?php
        $stmt = $pdo->prepare("SELECT * FROM shoemember");
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            echo "<div>";
            echo "<img src='./memphoto/" . $row["Username"] . ".jpg' width=100><br>";
            echo "ชื่อสมาชิก : " . $row["Name"] . "<br>";
            echo "ที่อยู่ : " . $row["Address"] . "<br>";
            echo "เบอร์โทรศัพท์ : " . $row["Phone"] . "<br>";
            echo "อีเมล์ : " . $row["Email"] . "<br>";
            echo "<a href='editM_form.php?username=" . $row["Username"] . "'>แก้ไข</a> | ";
            echo "<a href='delete_member.php?username=" . $row["Username"] . "'>ลบ</a>";
            echo "</div><hr>";
        }
    ?>
    </div>
</div>

<?php include '../../Template/footer.php'; ?>
</body>
</html>
