<?php

/**
 * Description of XenForo
 *
 * @author Janno
 */

require_once __DIR__ . "./../config.php";

class XenApi extends Config
{
    public static function authenticate($username, $password)
    {
        $endpoint = "auth";
        $postFields = array("login" => $username, "password" => $password);
        $data = self::sendRequest($endpoint, null, $postFields, false);
        $data = json_decode($data, true);
        if (array_key_exists("errors", $data)) {
            return false;
        } else {
            return array("timezone" => $data["user"]["timezone"], "name" => $data['user']['username'], "member_id" => $data['user']['user_id'], "member_group_id" => $data['user']['user_group_id'], "forum_is_admin" => $data['user']['is_admin'], "forum_is_moderator" => $data['user']['is_moderator'], "forum_is_staff" => $data['user']['is_staff'], "forum_is_super_admin" => $data['user']['is_super_admin']);
        }
    }

    private static function sendRequest($endpoint, $user_id = null, $postFields = null, $bypass_permissions = true, $method = "POST", $return = true, $trailingSlash = "/")
    {
        $ch = curl_init(Config::$XF_API_URL . "/api/$endpoint" . "$trailingSlash");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($return) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }

        if ($bypass_permissions) {
            $postFields['api_bypass_permissions'] = 1;
        }

        //var_export(self::$XENFORO_API_URL . "/$endpoint" . "$trailingSlash");

        $postFields = http_build_query($postFields);

        $httpHeaders = null;
        curl_setopt($ch, CURLOPT_VERBOSE, 1);



        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        switch ($method) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                break;
            case "GET":
                break; //in url
            case "DELETE":
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

                break;

            default:
                return null;
        }

        if ($user_id !== null) {
            $httpHeaders = array("XF-Api-Key: " . Config::$XF_API_KEY, "XF-Api-User: " . intval($user_id));
        } else {
            $httpHeaders = array("XF-Api-Key: " . Config::$XF_API_KEY);
        }
        $httpHeaders[] = "Content-Type: application/x-www-form-urlencoded";

        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);



        $data = curl_exec($ch);
        if (curl_errno($ch) > 0) {
            throw new Exception("CURL error occured - " . curl_errno($ch) . " - " . curl_error($ch));
        }
        curl_close($ch);
        if ($return) {
            return $data;
        }
    }
}
