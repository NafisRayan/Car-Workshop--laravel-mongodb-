<?php
require 'db.php';

$mechanics = getMechanicsCollection();
$appointments = getAppointmentsCollection();

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get all mechanics
$allMechanics = $mechanics->find()->toArray();

// For each mechanic, count appointments for the selected date
$result = [];
foreach ($allMechanics as $m) {
    $count = $appointments->countDocuments([
        'mechanicId' => $m->_id,
        'appointmentDate' => $date
    ]);
    $result[] = [
        '_id' => (string)$m->_id,
        'name' => $m->name,
        'count' => $count
    ];
}

header('Content-Type: application/json');
echo json_encode($result);
?>