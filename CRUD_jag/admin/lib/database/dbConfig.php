<?php
if (!isset($_SESSION)) {
    session_start();
}

$root = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$constants['base_url'] = $root;
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'database_crud');


define('SITE_URL', $constants['base_url']);
class DBConnection
{
    private $dbConnection;
    public function __construct()
    {
        $this->dbConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->dbConnection->connect_error)
            die('Database error -> ' . $this->dbConnection->connect_error);
    }
    // return Connection
    function returnConnection()
    {
        return $this->dbConnection;
    }
}
?>