<?PHP
namespace WHMCS\Module\Addon\SidnSuggestionTool\Client;

use WHMCS\Database\Capsule as DB;
use \Sidn\Suggestion\Api\Exceptions\ApiException;
use \Sidn\Suggestion\Api\SidnSuggestionApiClient;


/**
 * Client Area Controller: Implementation for the SIDN Suggestion Api
 */
class Controller {

    /**
     * Action called from the JavaScript to fetch the suggested domains.
     *
     * @return array json encoded array
     */
    public function fetch()
    {
        header("Content-Type: application/json", true);

        $client_id = DB::table('tbladdonmodules')->select('value')->where('module', 'sidn_suggestion_tool')->where('setting', 'SIDN_CLIENT_ID')->first();
        $client_secret = DB::table('tbladdonmodules')->select('value')->where('module', 'sidn_suggestion_tool')->where('setting', 'SIDN_CLIENT_SECRET')->first();
        $result_amount = DB::table('tbladdonmodules')->select('value')->where('module', 'sidn_suggestion_tool')->where('setting', 'SIDN_RESULT_AMOUNT')->first();
        
        if(isset($client_id->value) && isset($client_secret->value) && isset($result_amount->value) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
           $domainprice = DB::table('tblpricing')
            ->join("tbldomainpricing", "tbldomainpricing.id", "=", "tblpricing.relid")
            ->select('msetupfee')
            ->where('tbldomainpricing.extension', '.nl')
            ->where('tblpricing.type', 'domainregister')->first();

            try {
                $data = json_decode(file_get_contents("php://input"), true);
                if(is_array($data) && isset($data["lookupTerm"])) {
                    $sidnApi = new SidnSuggestionApiClient();
                    
                    $auth = $sidnApi->authenticate->Authenticate($client_id->value, $client_secret->value);
                    $sidnApi->setAccessToken($auth->access_token);
                    
                    $suggestions = [];
                    $data = $sidnApi->suggestion->Search($data["lookupTerm"], $result_amount->value);
                    foreach($data->suggestions as $s) {
                        array_push($suggestions, [
                            "domain" => $s["domain"],
                            "price" => $domainprice->msetupfee,
                            "extension" => ".nl"
                        ]);
                    }
                    $result = [
                        "suggestions" => $suggestions,
                    ];
                } else {
                    $result = false;
                }
            } catch(ApiException $ae) {
                $result = [
                    "message" => $ae->getMessage()
                ];
            }
        } else {
            $result = [
                "message" => "AddOn not correctly configured!"
            ];
        }
        echo json_encode($result);
        exit;
    }

    /**
     * Action used as a script src to load the static content of a JavaScript file
     *
     * @return string Content of JavaScript file
     */
    public function static()
    {
        header("Content-type: text/javascript", true);
        echo file_get_contents(__DIR__."/static/script.js");
        exit;
    }
}