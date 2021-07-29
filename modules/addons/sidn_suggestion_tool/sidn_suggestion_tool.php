<?PHP
require_once(__DIR__ . "/lib/load.php");

use \WHMCS\Module\Addon\SidnSuggestionTool\Client\ClientDispatcher;


if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function sidn_suggestion_tool_config()
{
    return [
        "name" => "SIDN Suggestion Tool",
        "description" => "This module allows you to show accurate .nl domain suggestions to your customers",
        "author" => "MijnPartnerGroep.nl",
        "language" => "english",
        "version" => "1.0",

        'fields' => [
            'SIDN_CLIENT_ID' => [
                'FriendlyName' => 'Client ID',
                'Type' => 'text',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Client ID as provided by SIDN',
            ],
            'SIDN_CLIENT_SECRET' => [
                'FriendlyName' => 'Client Secret',
                'Type' => 'password',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Client Secret as provided by SIDN',
            ],
            'SIDN_RESULT_AMOUNT' => [
                'FriendlyName' => 'Result amount',
                'Type' => 'text',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Amount of results to show back to the client',
            ]
        ]
    ];
}

function sidn_suggestion_tool_clientarea() {

    $action = isset($_REQUEST['a']) ? $_REQUEST['a'] : '';

    $dispatcher = new ClientDispatcher();
    $dispatcher->dispatch($action);
}