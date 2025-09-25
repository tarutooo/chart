<?php
// Simple API to save tasks as JSON and optionally CSV
// Environment: PHP 7+, shared hosting compatible (e.g., Lolipop)

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
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

// Ensure data dir is writable
if (!is_writable($DATA_DIR)) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Data directory not writable']);
  exit;
}

// Read raw input
$raw = file_get_contents('php://input');
if (!$raw) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Empty request body']);
  exit;
}

$payload = json_decode($raw, true);
if (!is_array($payload)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Invalid JSON']);
  exit;
}

// Validate basic shape
$tasks = $payload['tasks'] ?? null;
$meta = $payload['meta'] ?? [];

if (!is_array($tasks)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Missing tasks array']);
  exit;
}

// Multi-tenant key (optional)
$key = $payload['key'] ?? 'default';
$key = preg_replace('/[^a-zA-Z0-9_-]/', '_', (string)$key);

$jsonPath = $DATA_DIR . "/tasks_{$key}.json";
$csvPath  = $DATA_DIR . "/tasks_{$key}.csv";

// Save JSON (atomic write)
$tmpJson = $jsonPath . '.tmp';
$jsonData = json_encode([
  'meta' => [
    'updatedAt' => gmdate('c'),
    'source' => 'api/save.php',
  ] + $meta,
  'tasks' => $tasks
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

if (file_put_contents($tmpJson, $jsonData, LOCK_EX) === false || !rename($tmpJson, $jsonPath)) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Failed to write JSON']);
  exit;
}

// Save CSV (optional convenience)
$fp = fopen($csvPath, 'w');
if ($fp) {
  // header
  fputcsv($fp, ['id', 'name', 'start', 'end', 'color', 'memo']);
  foreach ($tasks as $t) {
    $row = [
      $t['id'] ?? '',
      $t['name'] ?? '',
      $t['start'] ?? '',
      $t['end'] ?? '',
      $t['color'] ?? '',
      isset($t['memo']) ? str_replace(["\r", "\n"], ' / ', (string)$t['memo']) : ''
    ];
    fputcsv($fp, $row);
  }
  fclose($fp);
}

http_response_code(200);
clearstatcache();
$size = @filesize($jsonPath);
echo json_encode(['ok' => true, 'file' => basename($jsonPath), 'bytes' => $size]);
