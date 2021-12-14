<?php
require_once "Database.php";

class Logger
{
    private $log_id;
    private $user_id;
    private $action;
    private $reason;
    private $creation_date;

    function __construct($log_id, $user_id, $action, $reason, $creation_date)
    {
        $this->log_id = $log_id;
        $this->user_id = $user_id;
        $this->action = $action;
        $this->reason = $reason;
        $this->creation_date = $creation_date;
    }

    public function add()
    {
        Database::connect()->query("INSERT INTO logs (user_id,action,reason) VALUES (?,?,?)", array($this->user_id, $this->action, $this->reason));
    }

    public static function getLogs()
    {
        $objects = array();
        $logs = Database::connect()->query("SELECT * FROM logs");
        if (sizeof($logs) >= 1 && $logs !== false) {
            foreach ($logs as $log) {
                $objects[] = new static($log["log_id"], $log["user_id"], $log["action"], $log["reason"], $log["creation_date"]);
            }
            return $objects;
        } else {
            return false;
        }
    }

    public function getLog_id()
    {
        return $this->log_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function getCreation_date()
    {
        return $this->creation_date;
    }
}
