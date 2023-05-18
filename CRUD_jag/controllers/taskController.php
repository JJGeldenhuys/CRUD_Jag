<?php
require_once dirname(__FILE__, 2) . "/admin/modules/gamesModules.php";
require_once dirname(__FILE__, 2) . "/admin/modules/userModules.php";

class taskController
{

    public $gamesModule;
    public $userModule;

    public function __construct()
    {
        $this->gamesModule = new Games();
        $this->userModule = new User();
    }

    public function redirect($location)
    {
        header('Location: ' . $location);
    }



    // public function listTask()
    // {
    //     $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "name";
    //     if (isset($_GET["page"])) {
    //         $page = $_GET["page"];
    //     } else {
    //         $page = 1;
    //     }
    //     ;

    //     $games = $this->gamesModule->getGameInformation();
    //     include "Views/index.php";
    // }

    public function saveGameInformation()
    {

        $title = 'Add new Game';
        $form = 'new';
        $name = '';
        $email = '';
        $task = '';


        if (isset($_POST['form-submitted'])) {

            $name = isset($_POST['name']) ? $_POST['name'] : NULL;
            $category = isset($_POST['category']) ? $_POST['category'] : NULL;
            $price = isset($_POST['price']) ? $_POST['price'] : NULL;
            try {
                $this->gamesModule->createGameInformation();
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) {
                echo 'Error: ' . $exception->getMessage();
            }
        }
        include 'Views/task-form.php';
    }

    public function editGameInformation($id)
    {
        $title = 'Edit Game';
        $item = $this->gamesModule->getGameInformation($id);
        $name = $item['name'];
        $category = $item['email'];
        $price = $item['task'];

        if (isset($_POST['form-submitted'])) {
            $name = isset($_POST['name']) ? $_POST['name'] : NULL;
            $category = isset($_POST['email']) ? $_POST['email'] : NULL;
            $price = isset($_POST['task']) ? $_POST['task'] : NULL;
            try {
                $this->gamesModule->updateGameInformation($id, $name, $category, $price);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) {
                echo 'Error: ' . $exception->getMessage();
            }
        }
        if (isset($_SESSION['user_name'])) {
            include 'Views/task-form.php';
        } else {
            header("location: ../Views/login-form.php");
        }
    }
}
?>

<!-- if (isset($_POST['submit'])) {
    extract($_POST);
    //Get the values of our form fields.
    $username = isset($username) ? $username : null;
    $password = isset($password) ? $password : null;

    //Check the username and make sure that it isn't a blank/empty string.
    if (strlen(trim($username)) === 0) {
        //Blank string, add error to $errors array.
        $errors[] = "You must enter your username!";
    }
    if (strlen(trim($password)) === 0) {
        //Blank string, add error to $errors array.
        $errors[] = "You must enter your password!";
    }

    //If our $errors array is empty, we can assume that everything went fine.
    if (empty($errors)) {
        //insert data into database.
        $user->setUsername($username, $dbConnection);
        $user->setPassword($password, $dbConnection);
        $register = $user->Registration();
        if ($register) {
            $status = "<div class='alert alert-success' style='text-align:center'>Registration successful <a href='" . SITE_URL . "index.php'>Click here</a> to login</div>";
        } else {
            $status = "<div class='alert alert-danger' style='text-align:center'>Registration failed. Email or Username already exits please try again.</div>";
        }
    } -->