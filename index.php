<?php
// Optional: index.php to allow direct folder access on shared hosting
?><!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>API Endpoints</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; margin: 2rem; }
    code { background: #f4f4f4; padding: 0.2rem 0.4rem; border-radius: 4px; }
    ul { line-height: 1.8; }
  </style>
</head>
<body>
  <h1>API</h1>
  <ul>
    <li>GET <code>api/load.php?key=default</code></li>
    <li>POST <code>api/save.php</code> (JSON: { tasks: [...], key?: "default" })</li>
  </ul>
</body>
</html>