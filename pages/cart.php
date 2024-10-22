<?php Include "../connect.php";?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="../css/index.css">
  </head>
  <?php
  include '../Template/navbar.php';
  
  ?>
  <body>
    <div>
    <?php
                
                session_start();

                
	
                
		

                

                // เพิ่มสินค้า
                if ($_GET["action"] == "add") {

                    $pid = $_GET['Shoes_ID'];

                    // ตรวจสอบจำนวนสินค้าคงเหลือ
                    $stmt = $pdo->prepare("SELECT stock FROM Shoes WHERE Shoes_ID = :Shoes_ID");
                    $stmt->execute(['Shoes_ID' => $pid]);
                    $product = $stmt->fetch();
                    $stock = $product['stock'];

                    $qty = $_POST['qty'];

                    $cart_item = array(
                        'pid' => $pid,
                        'pname' => $_GET['name'],
                        'price' => $_GET['price'],
                        'qty' => $_POST['qty']
                    );

                    // ถ้ายังไม่มีสินค้าในรถเข็น
                    if (empty($_SESSION['cart'])) {
                        $_SESSION['cart'] = array();
                    }

                    // ถ้ามีสินค้านั้นอยู่แล้วในรถเข็นให้บวกเพิ่ม
                    if (array_key_exists($pid, $_SESSION['cart'])) {
                        $_SESSION['cart'][$pid]['qty'] += $_POST['qty'];

                        // ตรวจสอบจำนวนสินค้าที่เลือกหลังเพิ่ม
                        if ($_SESSION['cart'][$pid]['qty'] > $stock) {
                            echo "จำนวนสินค้าที่เลือกมากกว่าสินค้าคงเหลือ!";
                            exit();
                        }
                    } else {
                        $_SESSION['cart'][$pid] = $cart_item;
                    }
                }

                // ปรับปรุงจำนวนสินค้า
                else if ($_GET["action"] == "update") {
                    $pid = $_GET["Shoes_ID"];
                    $qty = $_GET["qty"];

                    // ตรวจสอบสินค้าคงเหลือก่อนอัปเดต
                    $stmt = $pdo->prepare("SELECT stock FROM Shoes WHERE Shoes_ID = :Shoes_ID");
                    $stmt->execute(['Shoes_ID' => $pid]);
                    $product = $stmt->fetch();
                    $stock = $product['stock'];

                    if ($qty > $stock) {
                        echo "จำนวนที่เลือกมากกว่าสินค้าคงเหลือ!";
                        exit();
                    }

                    $_SESSION['cart'][$pid]['qty'] = $qty;
                }

                // ลบสินค้า
                else if ($_GET["action"] == "delete") {
                    $pid = $_GET['Shoes_ID'];
                    unset($_SESSION['cart'][$pid]);
                }
                ?>
                <form>
            <table border="1">
            <?php
                $sum = 0;
                foreach ($_SESSION["cart"] as $item) {
                    $sum += $item["price"] * $item["qty"];

                    // ดึงข้อมูลสต็อกสินค้าปัจจุบัน
                    $stmt = $pdo->prepare("SELECT stock FROM Shoes WHERE Shoes_ID = :Shoes_ID");
                    $stmt->execute(['Shoes_ID' => $item['Shoes_ID']]);
                    $product = $stmt->fetch();
                    $stock = $product['stock'];
            ?>
                <tr>
                    <td><?= htmlspecialchars($item["name"]) ?></td>
                    <td><?= htmlspecialchars($item["price"]) ?> บาท</td>
                    <td>
                        <!-- จำกัดจำนวนสูงสุดเท่ากับจำนวนสินค้าคงเหลือ -->
                        <input type="number" id="<?= htmlspecialchars($item["Shoes_ID"]) ?>" value="<?= htmlspecialchars($item["qty"]) ?>" min="1" max="<?= htmlspecialchars($stock) ?>">
                        <a href="#" onclick="update(<?= htmlspecialchars($item["Shoes_ID"]) ?>)">แก้ไข</a>
                        <a href="?action=delete&pid=<?= htmlspecialchars($item["Shoes_ID"]) ?>">ลบ</a>
                    </td>
                </tr>
            <?php } ?>
            <tr><td colspan="3" align="right">รวม <?= $sum ?> บาท</td></tr>
            </table>
            </form>
    </div>
  
  
  </body>
  <?php include '../Template/footer.php'; ?>
</html>