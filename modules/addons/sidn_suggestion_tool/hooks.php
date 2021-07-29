<?PHP
require_once(__DIR__ . "/lib/load.php");

use WHMCS\Database\Capsule as DB;

use \Sidn\Suggestion\Api\Exceptions\ApiException;
use  \Sidn\Suggestion\Api\SidnSuggestionApiClient;

function sidnSuggestionToolClientAreaPageCartHook($vars) {
    if(strpos($_SERVER["SCRIPT_NAME"], "cart.php") !== false && isset($_GET["domain"]) && isset($_GET["query"])) {
        $path = $_SERVER["SCRIPT_NAME"];
        $script_path = str_replace("cart.php", "?m=sidn_suggestion_tool&a=static", $path);
        $result = [
            "sidnscriptpath" => $script_path,
            "suggestiontool_title" => _SIDN_SUGGESTION_TOOL_LANG[$vars["language"]]["suggestiontool_title"]
        ];
    }
    return $result;
}

add_hook('ClientAreaPageCart', 1, 'sidnSuggestionToolClientAreaPageCartHook');