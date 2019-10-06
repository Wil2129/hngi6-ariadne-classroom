<?php
declare(strict_types=1);
session_start();
require_once 'utils/Auth.php';
require_once 'utils/utils.php';
require_once 'models/User.php';
require_once 'models/Teacher.php';
require_once 'models/Student.php';
require_once 'models/Classroom.php';
require_once 'models/Item.php';

$currentUser = NULL;

if (isset($_COOKIE["CurrentUser"])) {
    $currentUser = unserialize($_COOKIE["CurrentUser"], ["allowed_classes" => ["Teacher", "Student"]]);
} elseif (isset($_SESSION['current_user'])) {
    $currentUser = &$_SESSION['current_user'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sign-in'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $type = $_POST['type'];
        if (Auth::validateEmail($email) and Auth::validatePassword($password)) {
            $currentUser = Auth::signIn($email, md5($password), $type);
            if (isset($currentUser)) {
                if($_POST['remember']){
                    setcookie("CurrentUser", serialize($currentUser), time()+60*60*24*30);
                }
                $_SESSION['current_user'] = &$currentUser;
                header('Location: ../index.php');
                exit;
            } else {

            }
        }
    } elseif (isset($_POST['sign-up'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $type = $_POST['type'];
        if (Auth::validateName($name) and Auth::validateEmail($email) and Auth::confirmPasswords($password1, $password2)) {
            $signUp = Auth::signUp($name,$email, md5($password1), $type);
            if ($signUp) {
                header('Location: ../signin.php');
                exit;
            } else {

            }
        }
    } elseif (isset($_POST['create-classroom'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        if (Auth::validateInput($name)) {
            Auth::validateInput($description);
            $classroom = createClassroom($_SESSION['current_user'], $name, $description);
            if ($signUp) {
                header('Location: ../home.php');
                exit;
            } else {

            }
        }
    } elseif (isset($_POST['add-item'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $classroom = getClassroom($_POST['classroom_id']);
        $fileUrl = NULL;
        if(isset($_FILES['files'])){
            $fileUrl = '../uploads/' . basename($_FILES['files']['name']);
            move_uploaded_file($_FILES['userfile']['tmp_name'], $fileUrl);
        }
        if (Auth::validateInput($title)) {
            Auth::validateInput($content);
            $item = addItemToClassroom($_SESSION['current_user'], $classroom, $title, $content,$fileUrl);
            if ($item) {
                header('Location: ../home.php');
                exit;
            } else {

            }
        }
    } elseif (isset($_POST['classroom-signup'])) {
        $classroom = getClassroom($_POST['classroom_id']);
        $registerToClassroom = registerStudentToClassroom($_SESSION['current_user'], $classroom);
        if ($registerToClassroom) {
            header('Location: ../home.php');
            exit;
        } else {

        }
    }
}
?>