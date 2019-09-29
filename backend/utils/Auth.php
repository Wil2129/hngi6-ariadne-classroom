<?php
declare(strict_types=1);
require_once 'database.php';
require_once(__DIR__.'/../models/User.php');
require_once(__DIR__.'/../models/Teacher.php');
require_once(__DIR__.'/../models/Student.php');

class Auth
{
    public static function signUp(string $name, string $email, string $password, string $type): bool
    {
        try {
            $stmt = $GLOBALS['db']->prepare("INSERT INTO users (name, email, password, type) VALUES (:name, :email, :password, :type)");
            $stmt->execute(array(':name' => $name, ':email' => $email, ':password' => $password, ':type' => $type));

            $id = (int) $GLOBALS['db']->lastInsertId();
            if ($type === 'student') {
                $user = new Student($id, $name, $email, $password);
            } elseif ($type === 'teacher') {
                $user = new Teacher($id, $name, $email, $password);
            }

            return true;
        } catch (PDOException $e) {
            echo "Could not register user into database: " . $e->getMessage();
            return false;
        }
    }

    public static function signIn(string $email, string $password, string $type): ?User
    {
        try {
            $stmt = $GLOBALS['db']->prepare("SELECT * FROM users WHERE email = :email AND password = :password AND type = :type");
            $stmt->execute(array(':email' => $email, ':password' => $password, ':type' => $type));

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                if ($type === 'student') {
                    return new Student((int) $row['uid'], $row['name'], $row['email'], $row['password']);
                } elseif ($type === 'teacher') {
                    return new Teacher((int) $row['uid'], $row['name'], $row['email'], $row['password']);
                }
            }

            return NULL;
        } catch (PDOException $e) {
            echo "Could not sign in user: " . $e->getMessage();

            return NULL;
        }
    }

    public static function validateInput(string &$input): bool
    {
        $input = htmlspecialchars(stripslashes(trim($input)));
        if (empty($input)) {
            return false;
        } else {
            return true;
        }
    }

    public static function validateName(string &$name): bool
    {
        if (Auth::validateInput($name)) {
            if (!preg_match("/^[a-zA-Z'\s]+$/", $name)) {
                return false;
            } else {
                return true;
            }
        }
    }

    public static function validateEmail(string &$email): bool
    {
        if (Auth::validateInput($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function validatePassword(string $password): bool
    {
        if (strlen($password) >= 6) {
            return true;
        } else {
            return false;
        }
    }

    public static function confirmPasswords(string &$password1, string &$password2): bool
    {
        if (($password1 === $password2) and Auth::validatePassword($password1)) {
            return true;
        } else {
            return false;
        }
    }
}
