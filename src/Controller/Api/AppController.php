<?php

namespace Physler\Controller\Api;

use DateTime;
use JShrink\Minifier;
use Physler\Db\DbClient_S;
use Physler\Session\SessionVisitor;
use function Physler\HandlePlaceholders;
use function Physler\StrTimeElapsed;

$sesh = SessionVisitor::GetActive();

class AppController extends BaseController {
    /**
     * Handle placeholders
     *
     * @return string
     */
    protected function __assign($page) {
        $user = SessionVisitor::GetActive()->GetVisitorUser();

        // $page = str_replace("%:");
        return HandlePlaceholders($page, [
            ["name", $user->display_name],
            ["latest_activity", $user->GetHtmlActivityList()],
            ["activity_last_update_time", "Last activity was ".StrTimeElapsed($user->getActivityList()[array_key_last($user->getActivityList())]->timestamp ?? "0")],
            ["heartbeat_log", $user->GetHtmlHeartbeatLogs()],
            // ["heartbeat_last_update_time", "Last tested: ".StrTimeElapsed($user->getHeartbeatLogs()[array_key_last($user->getHeartbeatLogs())]->timestamp ?? "0")],
            ["daily_goal_item", "Nothing yet..."],
            ["weekly_goal_item", "Nothing yet..."],
            ["monthly_goal_item", "Nothing yet..."]
        ]);
    }
    /**
     * "/app/page" Endpoint
     * - Get a page template
     */
    public function page() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $argq = $this->getQuery();
        $segments = $this->getSegments();

        $pagePath = __ROOT__."/common/pages/%s";
        
        $pageNames = [];
        for ($i=4; $i < count($segments); $i++) { 
            array_push($pageNames, $segments[$i]);
        }

        $pageName = str_replace(".json", "", join("/", $pageNames));
        $pageLocation = sprintf($pagePath, $pageName);

        if (!is_dir($pageLocation)) {
            if (!file_exists($pageLocation . ".php")) {
                $pageLocation = PAGE_SYSMSG_NOT_FOUND;
            }
            else {
                $pageLocation = $pageLocation . ".php";
            }
        }
        else {
            if (!file_exists($pageLocation . "/index.php")) {
                $pageLocation = PAGE_SYSMSG_NOT_FOUND;
            }
            else {
                $pageLocation = $pageLocation . "/index.php";
            }
        }

        ob_start();
        extract(get_defined_vars());
        include $pageLocation;
        $pageContents = ob_get_clean();

        /**
        * Terrible method of variable implementation. Ignore! 
        */
        // $pageContents = file_get_contents($pageLocation);
        // $pageScript = null;
        // extract(get_defined_vars());
        // $pageContents = preg_replace('/\{\$(\w+)\}/', ${'$$1'}, $pageContents);

        if (strstr($pageContents, "<script>")) {            
            $pageParts = explode("<script>", $pageContents);
            $pageScript = Minifier::minify(str_replace("</script>", "", $pageParts[1]), array('flaggedComments' => false));
        }
        else {
            $pageParts = [$pageContents];
        }

        if ($method == 'GET') {
            $this->outputJson([
                "pageHtml" => $this->__assign($pageParts[0]),
                "script" => $pageScript ?? null
            ]);
        }
    }

    public function motd() {
        global $sesh;
        $strErrorDesc = '';
        $method = $this->getMethod();
        $argq = $this->getQuery();
        $segments = $this->getSegments();

        $day = $argq["day"];

        if ($method == 'GET') {
            $db = DbClient_S::Default();
            $response = $db->QueryJson("SELECT * FROM `physler_daily_messages` WHERE day = %d", [$day], true);
            $this->outputJson($response[rand(0, count($response) - 1)]);
        }
    }

}