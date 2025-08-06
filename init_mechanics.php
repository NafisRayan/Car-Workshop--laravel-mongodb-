<?php
require 'db.php';

$mechanics = getMechanicsCollection();

$sampleMechanics = [
    ['name' => 'Mr. Rahim'],
    ['name' => 'Mr. Karim'],
    ['name' => 'Mr. Salam'],
    ['name' => 'Mr. Akbar'],
    ['name' => 'Mr. Hasan']
];

foreach ($sampleMechanics as $m) {
    $mechanics->insertOne($m);
}

echo "Sample mechanics inserted.";
?>