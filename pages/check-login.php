<?php
  include "../connect.php";
  
  session_start();

  $stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = ? AND password = ?");
  $stmt->bindParam(1, $_POST["username"]);
  $stmt->bindParam(2, $_POST["password"]);
  $stmt->execute();
  $row = $stmt->fetch();

  
  if (!empty($row)) { 
    
    $_SESSION["fullname"] = $row["Name"];   
    $_SESSION["username"] = $row["Username"];
    $_SESSION["usertype"] = $row["Status"];

    
    echo "เข้าสู่ระบบสำเร็จ<br>";
    header("location: ../index.php"); 

  
  } else {
    echo "ไม่สำเร็จ ชื่อหรือรหัสผ่านไม่ถูกต้อง";
    echo "<a href='login-form.php'>เข้าสู่ระบบอีกครัง</a>"; 
  }
?>
