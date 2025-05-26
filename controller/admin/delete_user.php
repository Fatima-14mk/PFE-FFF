<?php
if (!isset($_GET['id'])) {
    header("Location: ../../views/admin/users/users.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "onaaph");
$id = intval($_GET['id']);


$conn->query("DELETE FROM User WHERE userID = $id");


$conn->query("DELETE FROM Visitor WHERE id = $id");

header("Location: ../../views/admin/users/users.php?deleted=1");
exit();
?>
