<?php
session_start();

if (isset($_SESSION['userID'])) {
    header("Location: ../../views/user/user 1 page/user1page.php");
    exit();
}
if (isset($_SESSION['adminID'])) {
    header("Location: ../../views/admin/users/users.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pwd = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($email) || empty($pwd)) {
    header("Location: ../../views/guest/log_in/index2.php?error=Veuillez remplir tous les champs");
    exit();
}

// LOGIN UTILISATEUR
$sqlUser = "SELECT Visitor.id AS visitorID, User.password 
            FROM Visitor 
            JOIN User ON Visitor.id = User.userID 
            WHERE Visitor.email = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $email);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
    if (password_verify($pwd, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['userID'] = $user['visitorID'];
        header("Location: ../../views/user/user 1 page/user1page.php");
        exit();
    }
}

// LOGIN ADMIN
$sqlAdmin = "SELECT adminID, password FROM Admin WHERE email = ?";
$stmtAdmin = $conn->prepare($sqlAdmin);
$stmtAdmin->bind_param("s", $email);
$stmtAdmin->execute();
$resultAdmin = $stmtAdmin->get_result();

if ($resultAdmin->num_rows > 0) {
    $admin = $resultAdmin->fetch_assoc();
    if (password_verify($pwd, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['adminID'] = $admin['adminID'];
        header("Location: ../../views/admin/users/users.php");
        exit();
    }
}

// ECHEC
header("Location: ../../views/guest/log_in/index2.php?error=Email ou mot de passe incorrect");
exit();
?>
