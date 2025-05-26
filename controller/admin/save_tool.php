<?php
// Connexion DB
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Vérifier si les champs sont bien envoyés
if (!isset($_FILES['image'])) {
    die("Fichier image non reçu.");
}
if (!isset($_POST['name'])) {
    die("Nom de l'outil non reçu.");
}
if (!isset($_POST['description'])) {
    die("Description non reçue.");
}


// Dossier de destination
$uploadDir = __DIR__ . '/../../../uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Crée le dossier si besoin
}

// Nettoyer et récupérer les données
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
$disabilityType = isset($_POST['toolDisabilityType']) ? trim($_POST['toolDisabilityType']) : '';

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$imageName = basename($_FILES['image']['name']);
$imagePath = $uploadDir . $imageName;
$imageDBPath = $imageName; // Ce qui sera stocké en DB

// Déplacer l'image
if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
    // Enregistrer dans la base
   $stmt = $conn->prepare("INSERT INTO tool (name, description, image, quantity, disabilityType) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssds", $name, $description, $imageDBPath, $quantity, $disabilityType);

    if ($stmt->execute()) {
        header("Location: ../../views/admin/tools/tools.php?success=added");
        exit();
    } else {
        die("Erreur SQL : " . $stmt->error);
    }
} else {
    die("Erreur lors de l'envoi de l'image.");
}
?>
