<?php
require_once __DIR__ . '/../src/JsonMapper.php';
require_once 'Contact.php';
require_once 'Address.php';

$jsonData = @file_get_contents(__DIR__ . '/single.json');
if ($jsonData === false) {
    die("Error: Could not read single.json\n");
}

$json = json_decode($jsonData);
if ($json === null) {
    die("Error: Invalid JSON in single.json\n");
}

$mapper = new JsonMapper();
$contact = $mapper->map($json, new Contact());

if ($contact->address === null) {
    die("Error: Contact has no address\n");
}

try {
    $coords = $contact->address->getGeoCoords();
    echo $contact->name . ' lives at coordinates '
        . $coords['lat'] . ',' . $coords['lon'] . "\n";
} catch (Exception $e) {
    die("Error getting coordinates: " . $e->getMessage() . "\n");
}
?>