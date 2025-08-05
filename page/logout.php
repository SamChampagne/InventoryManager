<?php
/*
 * Page de déconnexion
 * Détruit la session et redirige vers la page d'accueil
 */
session_start();
session_unset();   
session_destroy();  
header('Location: ../index.php');  
exit;
?>