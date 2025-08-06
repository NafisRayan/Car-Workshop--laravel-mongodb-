<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    die('Invalid appointment ID.');
}

$appointments = getAppointmentsCollection();
$result = $appointments->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if ($result->getDeletedCount() > 0) {
    echo 'Appointment deleted successfully.';
} else {
    echo 'Appointment not found or could not be deleted.';
}
?>