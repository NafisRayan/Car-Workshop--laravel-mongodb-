<?php
require 'db.php';

$appointments = getAppointmentsCollection();
$mechanics = getMechanicsCollection();

// Get all appointments
$allAppointments = $appointments->find()->toArray();

// Get all mechanics for dropdowns
$allMechanics = $mechanics->find()->toArray();

function mechanicSlots($mechanicId, $date, $appointments) {
    $count = 0;
    foreach ($appointments as $app) {
        if ((string)$app['mechanicId'] === (string)$mechanicId && $app['appointmentDate'] === $date) {
            $count++;
        }
    }
    return $count;
}

$result = [];
foreach ($allAppointments as $app) {
    $mechanicsList = [];
    foreach ($allMechanics as $m) {
        $mechanicsList[] = [
            '_id' => (string)$m->_id,
            'name' => $m->name,
            'count' => mechanicSlots($m->_id, $app['appointmentDate'], $allAppointments)
        ];
    }
    $result[] = [
        '_id' => (string)$app['_id'],
        'clientName' => $app['clientName'],
        'phone' => $app['phone'],
        'carLicense' => $app['carLicense'],
        'appointmentDate' => $app['appointmentDate'],
        'mechanicId' => (string)$app['mechanicId'],
        'mechanics' => $mechanicsList
    ];
}

header('Content-Type: application/json');
echo json_encode($result);
?>