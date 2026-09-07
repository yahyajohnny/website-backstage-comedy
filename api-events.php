<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/events.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=60');

$payload = bcn_api_events_payload();
echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
