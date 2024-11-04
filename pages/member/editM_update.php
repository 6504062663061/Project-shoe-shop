<?php
include "../../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $status = $_POST["status"];

    $stmt = $pdo->prepare("UPDATE shoemember SET Name=?, Address=?, Phone=?, Email=?, Status=? WHERE Username=?");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $address);
    $stmt->bindParam(3, $phone);
    $stmt->bindParam(4, $email);
    $stmt->bindParam(5, $status);
    $stmt->bindParam(6, $username);

    if ($stmt->execute()) {
        echo "<p>Member updated successfully!</p>";
        header("Location: editM.php");
        exit;
    } else {
        echo "<p>Error updating member.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
