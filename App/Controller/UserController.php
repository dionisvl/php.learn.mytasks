<?php

namespace App\Controller;

use App\Helpers\Auth;
use App\Helpers\Validator;
use App\Model\User;
use Exception;

class UserController extends BaseController
{
    /**
     * Show the form for creating a new resource.
     * @throws Exception
     */
    public function create()
    {
        $this->print('/registration.html.twig', [
            'header' => 'Регистрация',
        ]);
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
            $this->print('/registration.html.twig', [
                'error' => 1,
                'errorMessage' => $errorMessage,
                'header' => 'Регистрация',
            ]);

            return false;
        }

        $name = htmlspecialchars($_POST['name']);
        $password = hash('SHA3-512', $_POST['password'] . DB_SALT);

        $user = new User;
        try {
            $userId = $user->create($name, $password, $email);
            $user = $this::getById($userId);
            Auth::authorize($user);
            $this->print('/registration.html.twig', [
                'message' => "Пользователь $user[name] успешно зарегистрирован",
                'user' => $user,
                'header' => 'Регистрация',
            ]);

            return false;
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function loginForm()
    {
        $this->print('/login.html.twig', [
            'header' => "Вход"
        ]);
        return false;
    }

    public function getById(int $userId)
    {
        return User::getById($userId)[0];
    }

    public function getByName(string $name)
    {
        return User::getByName($name);
    }
}