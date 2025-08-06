<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$newDate = $data['date'] ?? null;
$newMechanicId = $data['mechanicId'] ?? null;

if (!$id) {
    die('Invalid appointment ID.');
}

$appointments = getAppointmentsCollection();
$mechanics = getMechanicsCollection();

// Fetch appointment
$app = $appointments->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
if (!$app) {
    die('Appointment not found.');
}

// If changing mechanic, check slot
if ($newMechanicId) {
    $count = $appointments->countDocuments([
        'mechanicId' => new MongoDB\BSON\ObjectId($newMechanicId),
        'appointmentDate' => $app['appointmentDate']
    ]);
    if ($count >= 4) {
        die('Selected mechanic is fully booked for this date.');
    }
    $mechanic = $mechanics->findOne(['_id' => new MongoDB\BSON\ObjectId($newMechanicId)]);
    if (!$mechanic) {
        die('Mechanic not found.');
    }
    $appointments->updateOne(
        ['_id' => $app['_id']],
        ['$set' => ['mechanicId' => $mechanic['_id'], 'mechanicName' => $mechanic['name']]]
    );
    echo 'Mechanic updated successfully.';
    exit;
}

// If changing date, check slot for current mechanic
if ($newDate) {
    $count = $appointments->countDocuments([
        'mechanicId' => $app['mechanicId'],
        'appointmentDate' => $newDate
    ]);
    if ($count >= 4) {
        die('Mechanic is fully booked for the new date.');
    }
    $appointments->updateOne(
        ['_id' => $app['_id']],
        ['$set' => ['appointmentDate' => $newDate]]
    );
    echo 'Date updated successfully.';
    exit;
}

echo 'No changes made.';
?>