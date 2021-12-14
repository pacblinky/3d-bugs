<?php
require_once "Database.php";

class Comment
{
    private $comment_id;
    private $report_id;
    private $user_id;
    private $action;
    private $message;
    private $creation_date;

    function __construct($comment_id = null, $report_id, $user_id, $action, $message, $creation_date)
    {
        $this->comment_id = $comment_id;
        $this->report_id = $report_id;
        $this->user_id = $user_id;
        $this->action = $action;
        $this->message = $message;
        $this->creation_date = $creation_date;
    }

    public function create()
    {
        Database::connect()->query("INSERT INTO comments (report_id, user_id, action, message, creation_date) VALUES (?,?,?,?,?)", array($this->report_id, $this->user_id, $this->action, $this->message, $this->creation_date));
    }

    public function edit()
    {
        Database::connect()->query("UPDATE comments SET action=?, message=? WHERE comment_id=?", array($this->action, $this->message, $this->comment_id));
    }

    public function delete()
    {
        Database::connect()->query("DELETE * FROM comments WHERE comment_id=?", array($this->comment_id));
    }

    public static function getComments($report_id)
    {
        $objects = array();
        $comments = Database::connect()->query("SELECT * FROM comments WHERE report_id=?", array($report_id));
        if ($comments !== false && sizeof($comments) >= 1) {
            foreach ($comments as $comment) {
                $objects[] = new static($comment["comment_id"], $comment["report_id"], $comment["user_id"], $comment["user_name"], $comment["action"], $comment["message"], $comment["creation_date"]);
            }
            return $objects;
        } else {
            return false;
        }
    }

    public function getComment_id()
    {
        return $this->comment_id;
    }

    public function getReport_id()
    {
        return $this->report_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getCreation_date()
    {
        return $this->creation_date;
    }
}
