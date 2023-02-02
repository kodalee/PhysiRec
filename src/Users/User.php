<?php

namespace Physler\User;

use DateTime;
use Physler\Config;
use Physler\Db\DbClient_S;
use Physler\User\Exception;
use stdClass;

const activity_emojis = [
    "MOVEMENT" => "🏃‍♂️",
    "LIFTING" => "🏋️‍♂️",
    "OTHER" => "❓"
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

        $qry = $db->Query("SELECT preference_data FROM `physler_user_preferences` WHERE `user_id` = '{$this->id}'");
        if ($qry->num_rows == 1) {   
            $this->preferences = json_decode($qry->fetch_row()[0], true);
        }

        $qry = $db->Query("SELECT * FROM `physler_activity_logs` WHERE user_id = {$this->id}");
        if ($qry->num_rows > 0) {
            $activities = [];
            for ($i=0; $i < $qry->num_rows; $i++) { 
                $dat = $qry->fetch_row();
                array_push($activities, [
                    "activity_id" => $dat[0],
                    "user_id" => $dat[1],
                    "catagory" => $dat[2],
                    "description" => $dat[3],
                    "duration" => $dat[4],
                    "timestamp" => $dat[5]
                ]);
            }

            $this->activity_list = $activities;
        }
    }

    public function GetHtmlActivityList() {
        $activityEmojis = activity_emojis;
        if (COUNT( $this->activity_list ) > 0) {
            $ar = "<ul class='my-0 latest-activity'>";
            for ($i=0; $i < COUNT( $this->activity_list ); $i++) { 
                $act = $this->activity_list[$i];
                $currentDay = date("d/m/Y");
                $activityDay = date("d/m/Y", strtotime($act["duration"]));
                if ($currentDay == $activityDay) {
                    $ar = $ar . "<li>{$activityEmojis[$act["catagory"]]} {$act["description"]}</li>";
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

    public function AddActivity($activity, $explaination, $duration) {
        $db = DbClient_S::Default();
        $db->Query("INSERT INTO `physler_activity_logs` (`activity_id`, `user_id`, `activity_catagory`, `activity_description`, `activity_duration`, `timestamp`) VALUES (NULL, '{$this->id}', '$activity', '$explaination', '$duration', '".time()."');");
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
                throw new Exception\UserNotFoundException($email_address, "Failure to get a mysql row from the results.");
            }
            return null;
        }
        // throw new Exception\UserNotFoundException($email_address, PHYS_E_USER_SESSION);
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
        return IN_ARRAY( '99', $this->GetUserGroups() );
    }

    public function IsTeacher() {
        return IN_ARRAY( '1', $this->GetUserGroups() );
    }

    public function IsStudent() {
        return IN_ARRAY( '0', $this->GetUserGroups() );
    }    
}