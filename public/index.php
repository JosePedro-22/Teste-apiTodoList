<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
header('Content-type: application/json');
date_default_timezone_set("America/Sao_Paulo");

require "../vendor/autoload.php";
require "../routes/web.php";

$GLOBALS['secretJWT'] = 'dwlkdjwejlkdwekjldwjkledjwkledjwkfnerjkgrjk5gio434534053op4rj34rj3jrkejklfjkler';

new routes\web();

