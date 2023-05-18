<?php
require_once dirname(__FILE__, 2) . "/lib/database/dbConfig.php";
class User
{
    protected $dbConnection;

    protected $_userID;
    protected $_username; // using protected so they can be accessed
    protected $_password; // and overidden if necessary



    public function __construct()
    {
        $this->dbConnection = new DBConnection();
        $this->dbConnection = $this->dbConnection->returnConnection();
    }

    public function setUserID($userID)
    {
        $this->_userID = $userID;
    }
    public function setUsername($userName, $dbConnection)
    {
        $this->_username = $dbConnection->real_escape_string($userName);
    }
    public function setPassword($password, $dbConnection)
    {
        $this->_password = $dbConnection->real_esacpe_string($password);
    }


    public function Registration()
    {
        $password = $this->hash($this->_password);
        $sqlquery = 'SELECT * FROM users WHERE user_name="' . $this->_username . '" OR email="';
        $res = $this->dbConnection->query($sqlquery) or die($this->dbConnection->error);
        $count_row = $res->num_rows;
        if ($count_row == 0) {
            $query = 'INSERT INTO users SET user_name="' . $this->_username . '", password="' . $password . '';
            $res = $this->dbConnection->query($query) or die($this->dbConnection->error);
            return true;
        } else {
            return false;

        }
    }
    public function login()
    {
        $sqlQuery = 'SELECT id,username,password,role FROM users WHERE username="' . $this->_username . '';
        $res = $this->dbConnection->query($sqlQuery) or die($this->dbConnection->error);
        $userData = $res->fetch_assoc();
        $count_row = $res->num_rows;
        if ($count_row == 1) {
            if (!empty($userData['password']) && $this->verifyHash($this->_password, $userData['password']) == TRUE) {
                $_SESSION['loggedIn'] = TRUE;
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['user_name'] = $userData['username'];
                $_SESSION['access_role'] = $userData['role'];
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function getUserInformation()
    {
        $sqlQuery = "SELECT id,username,role FROM users WHERE id=" . $this->_userID;
        $res = $this->dbConnection->query($sqlQuery) or die($this->dbConnection->error);
        $userData = $res->fetch_assoc();
        return $userData;
    }

    public function getSession()
    {
        if (!empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function logout()
    {
        $_SESSION['loggedIn'] = FALSE;
        unset($_SESSION);
        session_destroy();
    }
    public function hash($password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    public function verifyHash($password, $verifiedPassword)
    {
        if (password_verify($password, $verifiedPassword)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>