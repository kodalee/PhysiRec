<?php
namespace Physler\Entity;

class User {
    public int $id;
    public string $display_name;
    public string $real_name;
    public string $profile_picture;
    public string $email;
    protected string $user_groups;
    protected array $activity_list;
    protected array $heartbeat_logs;
    public array $preferences;
}