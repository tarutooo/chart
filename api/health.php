<?php
header('Content-Type: application/json; charset=UTF-8');
$DATA_DIR = realpath(__DIR__ . '/../data');
$info = [
  'phpVersion' => PHP_VERSION,
  'dataDir' => $DATA_DIR,
  'exists' => $DATA_DIR !== false && file_exists($DATA_DIR),
  'isWritable' => $DATA_DIR !== false ? is_writable($DATA_DIR) : false,
  'owner' => $DATA_DIR !== false ? @fileowner($DATA_DIR) : null,
  'perms' => $DATA_DIR !== false ? substr(sprintf('%o', @fileperms($DATA_DIR)), -4) : null,
];
echo json_encode(['ok' => true, 'health' => $info], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
