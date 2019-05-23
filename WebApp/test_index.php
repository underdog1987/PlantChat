<?php
date_default_timezone_set('America/Mexico_City');


if (php_sapi_name() == 'cli') {
  // if run from console, set or delete webhook
  // apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
  error_log("CLI mode disabled");
  exit();
}

$ee=$_GET['c'];

$content = file_get_contents("php://input");


die($ee.'---'.$content);





die;
$update = json_decode($content, true);

if (!$update) {
  // receive wrong update, must not happen
  error_log("Error en update");
  exit;
}

if (isset($update["message"])) {
  $tb->processMessage($update["message"]);
}