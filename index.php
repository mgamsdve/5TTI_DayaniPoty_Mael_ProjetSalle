<?php
// Ouvre la session pour suivre l'utilisateur connecté entre les requêtes HTTP.
session_start();
// Charge la connexion PDO commune à tout le projet.
require_once "Config/connectDatabase.php";
// Charge les contrôleurs qui décident quelle vue afficher selon l'URL.
require_once "Controllers/userController.php";
require_once "Controllers/salleController.php";
require_once "Controllers/reservationController.php";
require_once "Controllers/equipementController.php";
require_once "Controllers/adminController.php";
