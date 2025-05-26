<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../guest/log_in/index2.php");
    exit();
}

$userID = $_SESSION['userID'];
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT v.id, v.fullName, v.phoneNumber, v.email, 
               u.registrationDate, u.disabilityPercentage, u.disabilityType
        FROM visitor v
        JOIN user u ON v.id = u.userID
        WHERE v.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="myprofile.css">
    <title>ONAAPH Access</title>
</head>
<body>
<header id="home">
    <nav class="fade-in">
        <button class="menu-toggle">☰</button>
        <div class="logo fade-in">
            <img src="../../../public/images/shared/logo.png" alt="Logo" loading="lazy">
        </div>
        <div class="menu fade-in">
            <a href="../user tools/usertools.php">Tools</a>
            <a href="../requests status/requests-status.php">Requests status</a>
            <div class="menu-container">
                <a href="#" id="settings-btn" class="active">Settings</a>
                <div id="dropdown-menu" class="dropdown">
                    <a href="myprofile.php">👤My profile</a>
                    <a href="../../../controller/shared/logouat.php">⬅ Log out</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <h4 class="section-title">Settings</h4>
    <div class="card">
        <div class="settings-layout">
            <div class="settings-sidebar">
                <div class="settings-links">
                    <a class="settings-link active" data-tab="account-personal-info">Personal Information</a>
                    <a class="settings-link" data-tab="account-change-password">Change password</a>
                </div>
            </div>
            <div class="settings-content">
                <!-- Formulaire infos personnelles -->
                <form method="POST" action="../../../controller/user/update_profile.php">
                    <div class="tab-content active" id="account-personal-info">
                        
                        <hr>
                        <div class="form-content">
                            <div class="form-group"><label>ID</label>
                                <input type="text" class="form-control" value="<?= $user['id'] ?>" readonly>
                            </div>
                            <div class="form-group"><label>Full Name</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($user['fullName']) ?>" readonly>
                            </div>
                            <div class="form-group"><label>E-mail Address</label>
                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                            </div>
                            <div class="form-group"><label>Phone Number</label>
                                <input type="text" class="form-control" name="phoneNumber" value="<?= htmlspecialchars($user['phoneNumber']) ?>">
                            </div>
                            <div class="form-group"><label>Type of Illness</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($user['disabilityType']) ?>" readonly>
                            </div>
                            <div class="form-group"><label>Percentage</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($user['disabilityPercentage']) ?>%" readonly>
                            </div>
                            <div class="form-group"><label>Registration Date</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($user['registrationDate']) ?>" readonly>
                            </div>
                        </div>
                        <div class="buttons-container">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="reset" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </form>

                <!-- Formulaire mot de passe -->
                <div class="tab-content" id="account-change-password" style="display:none;">
                    <form method="POST" action="../../../controller/user/update_password.php">
                        <div class="form-content">
                            <div class="form-group">
                                <label>Current password</label>
                                <input type="password" name="current_password" class="form-control" autocomplete="current-password" required>
                            </div>
                            <div class="form-group">
                                <label>New password</label>
                                <input type="password" name="new_password" class="form-control" autocomplete="new-password" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm  password</label>
                                <input type="password" name="repeat_password" class="form-control" autocomplete="new-password" required>
                            </div>
                        </div>
                        <div class="buttons-container">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="reset" class="btn btn-default">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="../../../public/js/user/myprofile.js"></script>
</body>
</html>
