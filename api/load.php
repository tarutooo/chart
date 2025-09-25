<?php
// API to load tasks JSON (and optional CSV export parameter)
// Environment: PHP 7+, shared hosting compatible (e.g., Lolipop)

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

$DATA_DIR = realpath(__DIR__ . '/../data');
if ($DATA_DIR === false) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Data directory not found']);
  exit;
}

$key = isset($_GET['key']) ? $_GET['key'] : 'default';
$key = preg_replace('/[^a-zA-Z0-9_-]/', '_', (string)$key);

$jsonPath = $DATA_DIR . "/tasks_{$key}.json";

if (!file_exists($jsonPath)) {
  // Return empty tasks and create file lazily on save
  echo json_encode(['ok' => true, 'tasks' => [], 'meta' => ['created' => false]]);
  exit;
}

$data = file_get_contents($jsonPath);
if ($data === false) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Failed to read JSON']);
  exit;
}

// Pass-through JSON (validate basic structure)
$decoded = json_decode($data, true);
if (!is_array($decoded)) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Invalid JSON format on server']);
  exit;
}

$tasks = $decoded['tasks'] ?? [];
$meta = $decoded['meta'] ?? [];

echo json_encode(['ok' => true, 'tasks' => $tasks, 'meta' => $meta], JSON_UNESCAPED_UNICODE);
