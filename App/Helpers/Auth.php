<?php


namespace App\Helpers;


use App\Controller\BaseController;
use App\Controller\UserController;
use App\Model\Task;

class Auth
{
    public static function authorize(array $user)
    {
        $_SESSION["user"] = $user;
    }

    public static function isAdmin()
    {
        return $_SESSION["user"]["is_admin"] ?? false;
    }

    public static function isAuth()
    {
        return $_SESSION["user"]['id'] ?? false;
    }


    public static function login()
    {
        $errorMessage = '';
        $message = '';
        $name = $_POST['name'];
        $saltedPass = hash('SHA3-512', $_POST['password'] . DB_SALT);

        $user = (new \App\Controller\UserController)->getByName($name);

        if (empty($user['id'])) {
            $errorMessage = 'пользователь не найден';
        } else {
            if ($user['password'] == $saltedPass) {
                Auth::authorize($user);
                $message = "Пользователь $user[name] успешно авторизован";
            } else {
                $errorMessage = 'Неверный пароль';
            }
        }

//        $page = includeTemplate('views/login.php', []);
//        $layout = includeTemplate('views/layout.php', [
//                'errorMessage' => $errorMessage,
//                'message' => $message,
//                'page' => $page
//            ]
//        );
//        print($layout);

        $baseController = new BaseController();
        $baseController->print('/login.html.twig', [
            'errorMessage' => $errorMessage,
            'message' => $message,
            'header' => "Вход"
        ]);
    }

    public static function logout()
    {
        unset($_SESSION["user"]);;
        header('Location: /');
    }

    public static function denyIfNotAuth()
    {
        if (!isAuth()) {
            $baseController = new BaseController();
            $tasks = (new Task)->getAll('name', 'ASC');
            $baseController->print('/task/index.html.twig', [
                'tasks' => $tasks,
                'errorMessage' => 'Пользователь не авторизован',
                'header' => "Список задач"
            ]);

//            $tasks = (new Task)->getAll('name', 'ASC');
//            $page = includeTemplate('views/task/index.php', ['tasks' => $tasks]);
//            $layout = includeTemplate('views/layout.php', [
//                    'errorMessage' => 'Пользователь не авторизован',
//                    'page' => $page
//                ]
//            );
//            print($layout);
            die();
        }
    }
}