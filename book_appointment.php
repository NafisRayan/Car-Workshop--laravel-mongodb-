<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientName = $_POST['clientName'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $carLicense = $_POST['carLicense'];
    $carEngine = $_POST['carEngine'];
    $appointmentDate = $_POST['appointmentDate'];
    $mechanicId = $_POST['mechanicId'];

    // Basic validation
    if (!preg_match('/^\d+$/', $phone) || !preg_match('/^\d+$/', $carEngine)) {
        die('Phone and Engine Number must be numeric.');
    }

    $appointments = getAppointmentsCollection();
    $mechanics = getMechanicsCollection();

    // Check duplicate appointment for client on date
    $existing = $appointments->findOne([
        'clientName' => $clientName,
        'appointmentDate' => $appointmentDate
    ]);
    if ($existing) {
        die('You have already booked an appointment on this date.');
    }

    // Check mechanic slots
    $count = $appointments->countDocuments([
        'mechanicId' => new MongoDB\BSON\ObjectId($mechanicId),
        'appointmentDate' => $appointmentDate
    ]);
    if ($count >= 4) {
        die('Selected mechanic is fully booked for this date.');
    }

    // Get mechanic name
    $mechanic = $mechanics->findOne(['_id' => new MongoDB\BSON\ObjectId($mechanicId)]);
    if (!$mechanic) {
        die('Mechanic not found.');
    }

    // Insert appointment
    $appointments->insertOne([
        'clientName' => $clientName,
        'address' => $address,
        'phone' => $phone,
        'carLicense' => $carLicense,
        'carEngine' => $carEngine,
        'appointmentDate' => $appointmentDate,
        'mechanicId' => $mechanic->_id,
        'mechanicName' => $mechanic->name
    ]);
    echo 'Appointment booked successfully!';
} else {
    die('Invalid request.');
}
?>