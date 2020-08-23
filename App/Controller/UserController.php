<?php

namespace App\Controller;

use App\Helpers\Auth;
use App\Helpers\Validator;
use App\Model\User;
use Exception;

class UserController
{
    /**
     * Show the form for creating a new resource.
     * @throws Exception
     */
    public function create()
    {
        $page = includeTemplate('views/registration.php', []);

        $layout = includeTemplate('views/layout.php', [
                'header' => 'Регистрация',
                'page' => $page
            ]
        );

        print($layout);
    }

    public function store()
    {
        $errorMessage = '';
        $validateResult = Validator::validate($_POST, ['name', 'password', 'email']);
        if (!empty($validateResult)) {
            $errorMessage = 'Заполните недостающие поля: ' . implode(', ', $validateResult);
        }

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
        } else {
            $errorMessage .= '<br> E-mail адрес указан НЕверно.';
        }

        if ($errorMessage) {
            $page = includeTemplate('views/registration.php', []);
            $layout = includeTemplate('views/layout.php', [
                    'error' => 1,
                    'errorMessage' => $errorMessage,
                    'header' => 'Регистрация',
                    'page' => $page
                ]
            );
            print($layout);
            return false;
        }

        $name = htmlspecialchars($_POST['name']);
        $password = hash('SHA3-512', $_POST['password'] . DB_SALT);

        $user = new User;
        try {
            $userId = $user->create($name, $password, $email);
            $user = $this::getById($userId);
            Auth::authorize($user);
            $page = includeTemplate('views/registration.php', []);
            $layout = includeTemplate('views/layout.php', [
                    'message' => "Пользователь $user[name] успешно зарегистрирован",
                    'page' => $page,
                    'user' => $user
                ]
            );
            print($layout);
            return false;
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function loginForm(){
        $page = includeTemplate('views/login.php', []);
        $layout = includeTemplate('views/layout.php', [
                'header' => "Вход",
                'page' => $page
            ]
        );
        print($layout);
        return false;
    }

    public function getById(int $userId)
    {
        return User::getById($userId)[0];
    }

    public function getByName(string $name){
        return User::getByName($name);
    }
}