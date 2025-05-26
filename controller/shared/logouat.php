<?php
session_start();
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session

// Redirige vers la page de login (ou accueil)
header("Location: ../../views/guest/log_in/index2.php");
exit();
?>
