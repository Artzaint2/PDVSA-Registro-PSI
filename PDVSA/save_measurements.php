<?php
$file = 'measurements.txt';
$data = file_get_contents('php://input');
$jsonData = json_decode($data, true);
$measurements = [];

if (file_exists($file)) {
    $measurements = json_decode(file_get_contents($file), true);
}

$jsonData['datetime'] = date('Y-m-d H:i:s');
$measurements[] = $jsonData;
file_put_contents($file, json_encode($measurements));

$response = ['status' => 'success', 'message' => 'Registro guardado correctamente'];
echo json_encode($response);
?>
