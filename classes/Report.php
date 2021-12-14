<?php
require_once "Database.php";

class Report
{
    private $report_id;
    private $user_id;
    private $map_name;
    private $entity_id;
    private $title;
    private $steps;
    private $expected;
    private $actual;
    private $attachments;
    private $status;
    private $creation_date;

    static $report_status = array(
        0 => array("Pending", "#6C757D", "#D3D3D3"),
        1 => array("Approved", "#198754", "#0FFF50"),
        2 => array("Denied", "#DC3545", "#FF3131"),
        3 => array("Fixed", "#2577B1", "#00FFF"),
    );

    function __construct($report_id, $user_id, $map_name, $entity_id, $title, $steps, $expected, $actual, $attachments, $status, $creation_date)
    {
        $this->report_id = $report_id;
        $this->user_id = $user_id;
        $this->map_name = $map_name;
        $this->entity_id = $entity_id;
        $this->title = $title;
        $this->steps = $steps;
        $this->expected = $expected;
        $this->actual = $actual;
        $this->attachments = $attachments;
        $this->status = $status;
        $this->creation_date = $creation_date;
    }

    public function create()
    {
        $query = Database::connect()->query("INSERT INTO reports (user_id, map_name, entity_id, title, steps, expected, actual, status) VALUES (?,?,?,?,?,?,?,?)", array($this->user_id, $this->map_name, $this->entity_id, $this->title, $this->steps, $this->expected, $this->actual, $this->status));
        foreach ($this->attachments as $attachment) {
            Database::connect()->query("INSERT INTO attachments (report_id, link) VALUES (?,?)", array($query["last_insert_id"], $attachment));
        }
        $this->report_id = $query["last_insert_id"];
    }

    public function edit()
    {
        Database::connect()->query("UPDATE reports SET map_name=?,entity_id=?,title=?,steps=?,expected=?,actual=? WHERE report_id=?", array($this->map_name, $this->entity_id, $this->title, $this->steps, $this->expected, $this->actual, $this->report_id));
        Database::connect()->query("DELETE FROM attachments WHERE report_id=?", array($this->report_id));
        if ($this->attachments !== null) {
            foreach ($this->attachments as $attachment) {
                Database::connect()->query("INSERT INTO attachments (report_id, link) VALUES(?,?)", array($this->report_id, $attachment));
            }
        }
    }

    public function delete()
    {
        Database::connect()->query("DELETE FROM reports WHERE report_id=?", array($this->report_id));
    }

    public function move($status)
    {
        Database::connect()->query("UPDATE reports SET status=? WHERE report_id=?", array($status, $this->report_id));
    }

    public function validateReport()
    {
        $valid = false;
        if (empty($this->map_name) || empty($this->entity_id) || empty($this->title) || empty($this->steps) || empty($this->expected) || empty($this->actual) || !is_numeric($this->entity_id)) {
            $valid = false;
        } elseif (strlen($this->attachments) >= 7) {
            $this->attachments = preg_split("/[\s|\n]+/", strtolower($this->attachments));
            foreach ($this->attachments as $link) {
                if (filter_var($link, FILTER_VALIDATE_URL) === false) {
                    $valid = false;
                    break;
                } else {
                    $valid = true;
                }
            }
        } else {
            $valid = true;
        }
        return $valid;
    }

    public static function generateFromSQLRow($report)
    {
        return new static($report["report_id"], $report["user_id"], $report["map_name"], $report["entity_id"], $report["title"], $report["steps"], $report["expected"], $report["actual"], self::attachments($report["report_id"]), $report["status"], $report["creation_date"]);
    }

    public static function getReport($report_id)
    {
        $report = Database::connect()->query("SELECT * FROM reports WHERE report_id=?", array($report_id));
        if (sizeof($report) === 1 && $report !== false) {
            $report = $report[0];
            return self::generateFromSQLRow($report);
        } else {
            return false;
        }
    }

    public static function getReports($status)
    {
        $objects = array();
        $reports = Database::connect()->query("SELECT * FROM reports WHERE status=?", array($status));
        if (sizeof($reports) >= 1 && $reports !== false) {
            foreach ($reports as $report) {
                $objects[] = self::generateFromSQLRow($report);
            }
            return $objects;
        } else {
            return false;
        }
    }

    public static function attachments($report_id)
    {
        $attachments = array();
        $query = Database::connect()->query("SELECT link FROM attachments WHERE report_id=?", array($report_id));
        if (sizeof($query) >= 1 && $query !== false) {
            foreach ($query as $attachment) {
                $attachments[] = $attachment["link"];
            }
        } else {
            $attachments = "";
        }
        return $attachments;
    }

    public function anchors()
    {
        foreach ($this->attachments as $link) {
            echo "<a class='text-decoration-none' target='_blank' href='$link'>$link</a>\n";
        }
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getReport_id()
    {
        return $this->report_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function getMap_name()
    {
        return $this->map_name;
    }

    public function setMap_name($map_name)
    {
        $this->map_name = $map_name;

        return $this;
    }

    public function getEntity_id()
    {
        return $this->entity_id;
    }

    public function setEntity_id($entity_id)
    {
        $this->entity_id = $entity_id;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getSteps()
    {
        return $this->steps;
    }

    public function setSteps($steps)
    {
        $this->steps = $steps;
        return $this;
    }

    public function getExpected()
    {
        return $this->expected;
    }

    public function setExpected($expected)
    {
        $this->expected = $expected;
        return $this;
    }

    public function getActual()
    {
        return $this->actual;
    }

    public function setActual($actual)
    {
        $this->actual = $actual;

        return $this;
    }

    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getCreation_date()
    {
        return $this->creation_date;
    }
}
