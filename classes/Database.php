<?php
require_once "Config.php";

class Database extends Config
{
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name, Config::$db_username, Config::$db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return false;
        }
    }

    public static function connect()
    {
        return new self();
    }

    public function query($statement, $params = null)
    {
        $stmt = $this->pdo->prepare($statement);
        if ($params !== null && is_array($params) && sizeof($params) === 0) {
            $params = null;
        }
        $stmt->execute($params);
        $queryType = substr(trim(strtoupper($statement)), 0, 6);
        if ($queryType === "SELECT") {
            return $stmt->fetchAll();
        } else {
            return array("rows_affected" => $stmt->rowCount(), "last_insert_id" => $this->pdo->lastInsertId());
        }
    }

    public static function getUsername($id)
    {
        try {
            $xenforo = new PDO("mysql:host=" . Config::$db_host . ";dbname=" . Config::$XF_SQLdatabase, Config::$XF_SQLusername, Config::$XF_SQLpassword);
            $xenforo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $xenforo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $stmt = $xenforo->query("SELECT username FROM xf_users WHERE user_id = $id");
            return $stmt->fetchAll()[0]["username"];
        } catch (PDOException $error) {
            return false;
        }
    }
}
