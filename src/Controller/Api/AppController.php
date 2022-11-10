<?php

namespace Physler\Controller\Api;

use DateTime;
use Physler\Db\DbClient;
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
    protected function __placeholders($page) {
        $user = SessionVisitor::GetActive()->GetVisitorUser();

        // $page = str_replace("%:");
        return HandlePlaceholders($page, [
            ["name", $user->display_name],
            ["latest_activity", $user->GetHtmlActivityList()],
            ["activity_last_update_time", "Last updated: ".StrTimeElapsed(time())],
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

        $pagePath = "common/pages/%s.xhtml";
        $pageName = str_replace(".json", "", $segments[4]);

        $pageLocation = sprintf($pagePath, $pageName);
        if (!file_exists($pageLocation)) {
            $pageLocation = sprintf($pagePath, PAGE_SYSMSG_NOT_FOUND);
        }

        $pageContents = file_get_contents($pageLocation);
        $pageScript = null;

        if (strstr($pageContents, "<script>")) {            
            $pageParts = explode("<script>", $pageContents);
            $pageScript = str_replace("</script>", "", $pageParts[1]);
        }
        else {
            $pageParts = [$pageContents];
        }

        if ($method == 'GET') {
            $this->outputJson([
                "pageHtml" => $this->__placeholders($pageParts[0]),
                "script" => $pageScript
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
            $db = DbClient::Default();
            $response = $db->Query("SELECT * FROM `physler_daily_messages` WHERE day='$day';");

            $ret = $db->Handle($response, "physler_daily_messages", EXPECT_ANYTHING);            
            $this->outputJson($ret);
        }
    }
}