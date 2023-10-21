<?php
namespace Controllers;

include_once "dao/user.php";
use DAO\UserDAO;

class User {
    private $userDAO;

    public function __construct($conn = null) {
        $this->userDAO = new UserDAO($conn);
    }

    public function index() {
        
    }

    public function register() {
        include_once 'views/register.php';
    }

    public function doRegister() {
        $uploadDir = 'assets/images/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $this->userDAO->insert($_POST['username'], $_POST['email'], $_POST['password']);
            header('location:/user/showAll');
        } else {
            echo "Error uploading the image, please try again.";
        }
    }

    public function login() {
        include_once 'views/login.php';
    }

    public function doLogin() {
        $user = $this->userDAO->login($_POST['username'], $_POST['password']);
        if($user == null) {
            header('location:/user/login');
        }
        else {
            include_once 'views/user.php';
        }
    }

    public function showAll() {
        $users = $this->userDAO->getAll();
        include_once 'views/users.php';
    }
}
?>