<?php

namespace Physler\User;

use Physler\Config;
use Physler\Db\DbClient;
use Physler\User\Exception;
use stdClass;

class User {
    /** @var int */
    public $id;
    /** @var string */
    public $display_name;
    /** @var string */
    public $real_name;
    /** @var string */
    public $profile_picture;
    /** @var string */
    public $email;
    /** @var string */
    protected $user_groups;
    /** @var array */
    protected $activity_list;

    public function __construct($userInfo) {
        $this->id = $userInfo["id"];
        $this->display_name = $userInfo["display_name"];
        $this->real_name = $userInfo["real_name"];
        $this->profile_picture = $userInfo["profile_picture"];
        $this->email = $userInfo["email"];
        $this->user_groups = $userInfo["user_groups"];
        $this->activity_list = [
            "1 hour of yoga",
            "Walked my dog around the block",
            "Played basketball"
        ];
    }

    public function GetHtmlActivityList() {
        $ar = "<ul class='my-0'>";
        for ($i=0; $i < COUNT( $this->activity_list ); $i++) { 
            $ar = $ar . "<li>" . $this->activity_list[$i] . "</li>";
        }
        $ar = $ar . "</ul>";
        return $ar;
    }

    public function AddActivity($activity, $explaination, $duration) {
        $db = DbClient::Default();
        $db->Query("INSERT INTO `physler_activity_logs` (`activity_id`, `user_id`, `activity_catagory`, `activity_description`, `activity_duration`, `timestamp`) VALUES (NULL, '{$this->id}', '$activity', '$explaination', '$duration', '".time()."');");
        return true;
    }

    public static function MakeUser($email, $profile_picture, $names, $locale) {
        $db = DbClient::Default();

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
        $db = DbClient::Default();

        $qry = $db->Query("SELECT * FROM `physler_user` WHERE `email` = '$email_address'");
        if ($qry->num_rows == 1) {   
            $ordered_row = $qry->fetch_row();
            
            $catagorized_data = [
                "id" => $ordered_row[0],
                "display_name" => $ordered_row[1],
                "real_name" => $ordered_row[2],
                "email" => $ordered_row[3],
                "profile_picture" => $ordered_row[4],
                "user_groups" => $ordered_row[5]
            ];

            if ( $catagorized_data["display_name"] == null && $on_login == false ) {
                throw new Exception\UserNotFoundException($email_address, "Failure to catch a display name.");
            }

            return new User($catagorized_data);
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