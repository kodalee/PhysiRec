<?php

namespace Physler\User;

use DateTime;
use Physler\Config;
use Physler\Db\DbClient_S;
use Physler\User\Exception;
use stdClass;

const activity_emojis = [
    "movement" => '<i class="fad fa-person-running"></i>',
    "muscles" => '<i class="fad fa-dumbbell"></i>',
    "other" => '<i class="fad fa-comment-dots"></i>'
];

class User extends \Physler\Entity\User {
    public function __construct($userInfo) {
        $db = DbClient_S::Default();

        $this->id = $userInfo->id;
        $this->display_name = $userInfo->display_name;
        $this->real_name = $userInfo->real_name;
        $this->profile_picture = $userInfo->profile_picture;
        $this->email = $userInfo->email;
        $this->user_groups = $userInfo->user_groups;
        $this->activity_list = [];

        $qry = $db->QueryJson("SELECT preference_data FROM `physler_user_preferences` WHERE `user_id` = '{$this->id}'");
        $this->preferences = $qry;

        $this->activity_list = $db->QueryJson("SELECT * FROM `physler_activity_logs` WHERE user_id = {$this->id}");
        $this->heartbeat_logs = $db->QueryJson("SELECT * FROM `physler_heartbeat_logs` WHERE user_id = {$this->id}");
        // if ($qry->num_rows > 0) {
        //     $activities = [];
        //     for ($i=0; $i < $qry->num_rows; $i++) { 
        //         $dat = $qry->fetch_row();
        //         array_push($activities, [
        //             "activity_id" => $dat[0],
        //             "user_id" => $dat[1],
        //             "catagory" => $dat[2],
        //             "description" => $dat[3],
        //             "duration" => $dat[4],
        //             "timestamp" => $dat[5]
        //         ]);
        //     }

        //     $this->activity_list = $activities;
        // }
    }
    public static function HumanTime ($time)
    {
    
        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
    
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    
    }
    public function GetHtmlActivityList($all = false) {
        $activityEmojis = activity_emojis;
        if (COUNT( $this->activity_list ) > 0) {
            $ar = "<ul class='my-0 latest-activity'>";
            for ($i=0; $i < COUNT( $this->activity_list ); $i++) { 
                $act = $this->activity_list[$i];
                $currentDay = date("d/m/Y", time()); 
                $activityDay = date("d/m/Y", intval($act->timestamp));
                $duration = User::HumanTime(time() - $act->activity_duration);
                if ($currentDay == $activityDay) {
                    $ar = $ar . "<li>$activityDay, for ~$duration: {$activityEmojis[$act->activity_catagory]} {$act->activity_description}</li>";
                }
            }
            $ar = $ar . "</ul>";
            if (strpos($ar, "<li>") !== false) {
                return $ar;
            }
            else {
                return "<p>It looks like you don't have any activities logged today.</p>";
            }
        }
        else {
            return "<p>It looks like you don't have any activities logged today.</p>";
        }
    }

    public function GetHtmlHeartbeatLogs() {
        if (COUNT( $this->heartbeat_logs ) > 0) {
            $ar = "<ul class='my-0 heartbeat-logs'>";
            for ($i=0; $i < COUNT( $this->heartbeat_logs ); $i++) { 
                $act = $this->heartbeat_logs[$i];
                $ar = $ar . "<li>On ".date("m/d/Y", time()).", you tested {$act->heartbeat_bpm}bpm while {$act->activity_catagory}</li>";
            }
            $ar = $ar . "</ul>";
            if (strpos($ar, "<li>") !== false) {
                return $ar;
            }
            else {
                return "<p>It looks like you don't have any heartbeats logs</p>";
            }
        }
        else {
            return "<p>It looks like you don't have any heartbeats logs.</p>";
        }
    }

    public function getHeartbeatLogs() {
        return $this->heartbeat_logs;
    }
    public function getActivityList() {
        return $this->activity_list;
    }

    public function AddActivity($activity, $explaination, $duration, $time) {
        $db = DbClient_S::Default();
        $db->Query("INSERT INTO `physler_activity_logs` (`activity_id`, `user_id`, `activity_catagory`, `activity_description`, `activity_duration`, `timestamp`) VALUES (NULL, '%d', '%s', '%s', '%s', '%s');", [
            $this->id,
            $activity,
            $explaination,
            $duration,
            $time
        ]);
        return true;
    }

    public function LogHeartbeat($activity, $bpm) {
        $db = DbClient_S::Default();
        $db->Query("INSERT INTO `physler_heartbeat_logs` (`heartbeat_id`, `user_id`, `activity_catagory`, `heartbeat_bpm`, `timestamp`) VALUES (NULL, '%d', '%s', '%s', '%s');", [
            $this->id,
            $activity,
            $bpm,
            time()
        ]);
        return true;
    }

    public function ChangeSetting($setting, $new_value) {
        $db = DbClient_S::Default();
        $preferences = (array) $this->preferences;
        $preferences[$setting] = $new_value;

        $this->preferences = (object) $preferences;

        return $db->Query('UPDATE `physler_user_preferences` SET `preference_data` = \''.json_encode($preferences).'\' WHERE `physler_user_preferences`.`user_id` = '.$this->id.'};');
    }

    public static function MakeUser($email, $profile_picture, $names, $locale) {
        $db = DbClient_S::Default();

        return $db->Query("INSERT INTO `physler_user` (`id`, `display_name`, `real_name`, `email`, `profile_picture`, `user_groups`) VALUES (NULL, '{$names["first"]}', '{$names["first"]} {$names["last"]}', '{$email}', '{$profile_picture}', '0');");
    }

    /**
     * Get a user's information from guser email
     *
     * @param string $email_address The GUser's Email
     * @param boolean $on_login If false, this will throw the following exception.
     * @throws Exception\UserNotFoundException If the user doesn't exist and this is not on logon
     * @return User
     */
    public static function GetByEmail($email_address, $on_login) {
        $db = DbClient_S::Default();

        $qry = $db->QueryJson("SELECT * FROM `physler_user` WHERE `email` = '%s'", [$email_address]);
        if (count($qry) > 0) {
            $usrobj = $qry[0];

            if ( $usrobj->display_name == null && $on_login == false ) {
                throw new Exception\UserNotFoundException($email_address, "Failure to catch a display name.");
            }

            return new User($usrobj);
        }
        else {
            if ($on_login == false) {
                throw new Exception\UserNotFoundException($email_address, "No user found on required login.");
            }
            return null;
        }
        // throw new Exception\UserNotFoundException($email_address, PHYS_E_USER_SESSION);
    }

    /**
     * Get a user's information from a numeric unique ID
     * @param int $id The user's ID
     * @return User|false
     */
    public static function GetById($id) {
        $db = DbClient_S::Default();

        $qry = $db->QueryJson("SELECT * FROM `physler_user` WHERE `id` = '%d'", [$id]);
        if (count($qry) > 0) {
            $usrobj = $qry[0];
            return new User($usrobj);
        }
        else {
            return false;
        }
    }

    /**
     * Very unneeded function because
     * gauth is going to be used.
     * public function ValidatePasswd($input) {
     *
     * }
    */

    public function GetUserGroups() {
        $groups = EXPLODE( '+', $this->user_groups );
        return $groups;
    }

    public function IsSuperuser() {
        return IN_ARRAY( '20', $this->GetUserGroups() );
    }

    public function IsTeacher() {
        return IN_ARRAY( '10', $this->GetUserGroups() );
    }

    public function IsStudent() {
        return IN_ARRAY( '0', $this->GetUserGroups() );
    }

    public function GetUserRole() {
        if ($this->IsSuperuser()) {
            return 20;
        }
        else if ($this->IsTeacher()) {
            return 10;
        }
        else if ($this->IsStudent()) {
            return 0;
        }
        else {
            return null;
        }
    }
     
    public function CheckPermission($permission_min) {
        $g = $this->user_groups;
        if ($g >= $permission_min) {
            return true;
        }
        else {
            return false;
        }
    }

    public function GetStudents() {
        $db = DbClient_S::Default();
        $qry = $db->QueryJson("SELECT * FROM `physler_user` WHERE `teacher` = %d;", [$this->id]);
        return $qry;
    }
}