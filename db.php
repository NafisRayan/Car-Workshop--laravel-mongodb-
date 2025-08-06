<?php
require 'vendor/autoload.php'; // Composer MongoDB library

function getMongoClient() {
    $uri = getenv('MONGODB_URI') ?: "mongodb+srv://vaugheu:tempA@cluster0.yfpgp8o.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
    $client = new MongoDB\Client($uri);
    return $client;
}

function getWorkshopDB() {
    $client = getMongoClient();
    return $client->workshop; // Database name: workshop
}

function getMechanicsCollection() {
    $db = getWorkshopDB();
    return $db->mechanics;
}

function getAppointmentsCollection() {
    $db = getWorkshopDB();
    return $db->appointments;
}
?>