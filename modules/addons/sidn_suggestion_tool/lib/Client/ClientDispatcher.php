<?PHP
namespace WHMCS\Module\Addon\SidnSuggestionTool\Client;

/**
 * Simple Client Area Dispatch Handler
 */
class ClientDispatcher {

    public function dispatch($action)
    {
        if (!$action) {
            $action = 'fetch';
        }

        $controller = new Controller();

        if (is_callable(array($controller, $action))) {
            return $controller->$action();
        }
    }
}