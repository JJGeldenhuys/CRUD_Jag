<?php

require_once dirname(__FILE__, 2) . "/lib/database/dbConfig.php";

class Games
{
    protected $dbConnection;

    public $_id;
    public $_name;
    public $_category;
    public $_price;

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
        $this->dbConnection = $this->dbConnection->returnConnection();
    }

    public function setGameID($id)
    {
        $this->_id = $id;
    }
    public function setName($name, $dbConnection)
    {
        $this->_name = $dbConnection->real_escape_string($name);
    }

    public function setCategory($category, $dbConnection)
    {
        $this->_category = $dbConnection->real_escape_string($category);
    }

    public function setPrice($price, $dbConnection)
    {
        $this->_price = $dbConnection->real_escape_string($price);
    }

    public function getAllGameInformation()
    {
        try {
            $sqlQuery = ("SELECT * FROM games ORDER BY 'name' ASC");
            $res = $this->dbConnection->query($sqlQuery) or die($this->dbConnection->error);
            $allGameInformation = $res->fetch_assoc();
        } catch (Exception $e) {
            echo "Error: " . $e;
        }
        return $allGameInformation;
    }
    public function getGameInformation($id)
    {
        try {
            $sqlQuery = "SELECT * FROM games WHERE id=$id";
            $res = $this->dbConnection->query($sqlQuery) or die($this->dbConnection->error);
            $gameInformation = $res->fetch_assoc();
        } catch (Exception $e) {
            echo "Error" . $e;
        }
        return $gameInformation;
    }

    public function createGameInformation()
    {
        try {
            $sqlQuery = "INSERT INTO games(gameName,gameCategory,gamePrice) VALUES ($this->_name, $this->_category, $this->_price)";
            $res = $this->dbConnection->query($sqlQuery) or die($this->dbConnection->error);
            $gameData = $res->fetch_assoc();
        } catch (Exception $e) {
            echo "Error" . $e;
        }
        return $gameData;
    }

    public function deleteGameInformation($id)
    {
        try {
            $sqlstatement = "DELETE from games where id=$id";
            $sqlQuery = $this->dbConnection->query($sqlstatement);
        } catch (Exception $e) {
            echo "Error" . $e;
        }
        if ($sqlQuery) {
            return true;
        } else {
            return false;
        }
    }

    public function updateGameInformation($id, $name, $category, $price)
    {
        try {
            $sqlstatement = "UPDATE games SET gameName='$name',gameCategory='$category',price='$price' WHERE id=$id";
            $sqlQuery = $this->dbConnection->query($sqlstatement);
        } catch (Exception $e) {
            echo "Error" . $e;
        }
        if ($sqlQuery) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>