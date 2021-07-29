<?PHP
require_once(__DIR__ . "/vendor/autoload.php");
require_once(__DIR__ . "/Client/ClientDispatcher.php");
require_once(__DIR__ . "/Client/Controller.php");

$language_files = glob(__DIR__ . "/../lang/*.php");
foreach($language_files as $lf) {
    require_once($lf);
}

