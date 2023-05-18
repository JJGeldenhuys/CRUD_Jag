<?php
class Dashboard
{
    function __construct()
    {

    }

    function init()
    {
        echo "HI";

        $this->getTools();

    }

    function getTools()
    {
        if (isset($_SESSION['loggedIn']) && isset($_SESSION['access_role'])) {
            echo "<form method='post'>
                    <input type='submit' name='edit' id='edit' value='Edit' class='btn btn-warning'>
                    <input type='submit' name='delete' id ='delete' value='Delete' class='btn btn-warning'>
                  </form>";
        }

    }
}
?>