<?PHP
namespace WHMCS\Module\Addon\SidnSuggestionTool\Client;

/**
 * Simple Client Area Dispatch Handler
 */
class ClientDispatcher {

    /**
     * Dispatch request.
     *
     * @param string $action The action to be called
     *
     * @return string Result from the called action
     */

    public function dispatch($action)
    {
        if (!$action) {
            $action = 'fetch';
        }

        $controller = new Controller();

        if (is_callable([$controller, $action])) {
            return $controller->$action();
        }
    }
}