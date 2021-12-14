<?php
session_start();
require __DIR__ . "./classes/Report.php";
require __DIR__ . "./classes/Comment.php";
require __DIR__ . "./classes/Logger.php";

if ($_POST["action"] === "new_report") {
    $report = new Report(null, $_SESSION["user_id"], trim($_POST["map_name"]), trim($_POST["entity_id"]), trim($_POST["title"]), trim($_POST["steps"]), trim($_POST["expected"]), trim($_POST["actual"]), trim($_POST["attachments"]), 0, null);
    if ($report->validateReport()) {
        $report->create();
        echo json_encode(array("report_id" => $report->getReport_id()));
    }
}

if ($_POST["action"] === "get_report" && Report::getReport(intval($_POST["report_id"])) == true) {
    $report = Report::getReport(intval($_POST["report_id"]));
    if (is_array($report->getAttachments())) {
        $report->setAttachments(implode("\n", $report->getAttachments()));
    }
    echo json_encode(array(
        "map_name"   => $report->getMap_name(),
        "entity_id" => $report->getEntity_id(),
        "title" => $report->getTitle(),
        "steps" => $report->getSteps(),
        "expected" => $report->getExpected(),
        "actual" => $report->getActual(),
        "attachments" => $report->getAttachments(),
        "report_id" => $report->getReport_id(),
    ));
}

if ($_POST["action"] === "edit_report" && Report::getReport(intval($_POST["report_id"])) == true) {
    $report = Report::getReport(intval($_POST["report_id"]));
    if ($_SESSION["user_id"] == $report->getUser_id()) {
        $report->setActual(trim($_POST["actual"]));
        $report->setEntity_id(trim($_POST["entity_id"]));
        $report->setMap_name(trim($_POST["map_name"]));
        $report->setSteps(trim($_POST["steps"]));
        $report->setTitle(trim($_POST["title"]));
        $report->setExpected(trim($_POST["expected"]));
        $report->setAttachments(trim($_POST["attachments"]));
        if ($report->validateReport()) {
            $report->edit();
        }
    }
}

if ($_POST["action"] === "delete_report" && Report::getReport(intval($_POST["report_id"])) == true) {
    $report = Report::getReport(intval($_POST["report_id"]));
    if ($_SESSION["access_level"] === 3) {
        $report->delete();
        if ($_SESSION["user_id"] != $report->getUser_id() || $report->getStatus() !== 0) {
            $log = new Logger(null, $_SESSION["user_id"], "Deleted report #" . $report->getReport_id(), $_POST["reason"], null);
            $log->add();
        }
    } else if ($_SESSION["user_id"] == $report->getUser_id() && $report->getStatus() === 0) {
        $report->delete();
    }
}

if ($_POST["action"] === "new_comment" && Report::getReport(intval($_POST["report_id"])) == true) {
}
