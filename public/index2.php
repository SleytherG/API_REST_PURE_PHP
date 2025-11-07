<?php

require_once __DIR__ . '/../src/Util/Helpers.php';
require_once __DIR__ . '/../src/Model/Entity/PatientEntity.php';

allowCors();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$path = '/'.ltrim(substr($uri, strlen($basePath)), '/');
$parts = array_values(array_filter(explode('/', $path), fn($part) => $part !== ''));

$model = new PatientEntity();

try {
    if ($method == 'GET' && count($parts) === 1 && $parts[0] === 'patients') {
        $items = $model -> findAll();
        sendJson($items);
    } elseif($method === 'GET' && count($parts) === 2 && $parts[0] === 'patients') {
        $id = (int)$parts[1];
        $item = $model -> findById($id);
        if (!$item) {
            sendJson(['error' => 'Patient not found'], 404);
            exit;
        }
        sendJson($item);
    }  elseif($method === 'POST' && count($parts) === 1 && $parts[0] === 'patients') {
        $input = getJsonInput();
        if ( empty($input['dni']) || empty($input['nombre']) ) {
            sendJson(['error' => 'DNI y Nombre son requeridos'], 400);
            exit;
        }
        $newId = $model -> createPatient($input);
        $created = $model -> findById($newId);
        sendJson($created, 201);
    }
} catch(Exception $e) {
    sendJson(['error' => 'Server error: ' . $e->getMessage()], 500);
    exit;
}
