<?php
// import.php
// Fetch participant data from a Google Sheet (CSV export) and insert/update the
// local MySQL `participants` table.  
//
// Usage: call this script manually or via cron/webhook.  You must publish your
// Google Sheet to the web and use the sheet ID below.

require_once 'config.php';

// --- configuration --------------------------------------------------------
// the ID of the spreadsheet that receives Google Form responses
$sheetId = 'https://docs.google.com/forms/d/1RWF07EkOJo3_6OnNWJF6gsjhGcjWszQ4XzSdKaH6BnE/edit';
// the gid of the specific tab (usually 0 for first sheet). adjust if you have
// multiple tabs.
$gid = '0';

$csvUrl = "https://docs.google.com/spreadsheets/d/$sheetId/export?format=csv&gid=$gid";

// column mapping: the header names that appear in the sheet must map to the
// columns in the participants table.  change these if your form uses different
// labels.
$map = [
    'Name'        => 'name',
    'Talent'      => 'talent',
    'Image Path'  => 'image_path',
    'Age'         => 'age',
    'Address'     => 'address',
    'Email'       => 'email',
    'Church'      => 'church',
    'Phone'       => 'phone',
    'Country'     => 'country',
];

// ---------------------------------------------------------------------------

echo "Fetching CSV from $csvUrl...\n";
$csvData = @file_get_contents($csvUrl);
if ($csvData === false) {
    die("Failed to fetch sheet. Make sure it is published to the web and the ID is correct.\n");
}

$lines = array_filter(explode("\n", $csvData));
$rows = array_map('str_getcsv', $lines);
if (count($rows) < 2) {
    die("Sheet appears empty\n");
}

$headers = array_shift($rows);
$indices = [];
foreach ($headers as $i => $h) {
    if (isset($map[$h])) {
        $indices[$map[$h]] = $i;
    }
}

if (empty($indices)) {
    die("No recognizable columns found in spreadsheet headers.\n");
}

$insertStmt = $pdo->prepare(
    'REPLACE INTO participants (name, talent, image_path, age, address, email, church, phone, country)
     VALUES (:name, :talent, :image_path, :age, :address, :email, :church, :phone, :country)'
);

$count = 0;
foreach ($rows as $row) {
    $data = [];
    foreach ($indices as $col => $idx) {
        $data[$col] = isset($row[$idx]) ? $row[$idx] : '';
    }
    $insertStmt->execute([
        ':name'        => $data['name'] ?? null,
        ':talent'      => $data['talent'] ?? null,
        ':image_path'  => $data['image_path'] ?? null,
        ':age'         => $data['age'] ?? null,
        ':address'     => $data['address'] ?? null,
        ':email'       => $data['email'] ?? null,
        ':church'      => $data['church'] ?? null,
        ':phone'       => $data['phone'] ?? null,
        ':country'     => $data['country'] ?? null,
    ]);
    $count++;
}

echo "Imported/updated $count participants.\n";
