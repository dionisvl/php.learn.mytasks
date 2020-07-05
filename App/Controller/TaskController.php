<?php

namespace App\Controller;


use App\Helpers\Auth;
use App\Helpers\Validator;
use App\Model\Task;

class TaskController
{
    private $perPage = 3;

    public function index()
    {
        if (empty(mb_strimwidth($_GET['orderDirection'], 0, 10))) {
            if (empty($_SESSION['orderDirection'])) {
                $_SESSION['orderDirection'] = $orderDirection = 'ASC';
            } else {
                $orderDirection = $_SESSION['orderDirection'];
            }
        } else {
            $_SESSION['orderDirection'] = $orderDirection = mb_strimwidth($_GET['orderDirection'], 0, 10);
        }

        if (empty(mb_strimwidth($_GET['orderBy'], 0, 20))) {
            if (empty($_SESSION['orderBy'])) {
                $_SESSION['orderBy'] = $orderBy = 'name';
            } else {
                $orderBy = $_SESSION['orderBy'];
            }
        } else {
            $_SESSION['orderBy'] = $orderBy = mb_strimwidth($_GET['orderBy'], 0, 20);
        }

        $task = new Task;

        $needPage = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $count = $task->getCount();
        $pagesCount = ceil($count / $this->perPage);

        $tasks = $task->getAll($orderBy, $orderDirection, $this->perPage, $needPage);
        $page = includeTemplate('views/task/index.php', [
            'tasks' => $tasks,
            'curPage' => $needPage,
            'pagesCount' => $pagesCount
        ]);
        $layout = includeTemplate('views/layout.php', [
            'page' => $page
        ]);
        print($layout);
    }

    public function create()
    {
        $page = includeTemplate('views/task/create.php', []);
        $layout = includeTemplate('views/layout.php', [
                'page' => $page
            ]
        );
        print($layout);
    }

    public function show(int $id)
    {
        $task = (new Task)->getById($id);
        $page = includeTemplate('views/task/show.php', ['task' => $task]);
        $layout = includeTemplate('views/layout.php', [
                'page' => $page
            ]
        );
        print($layout);
    }

    public function store()
    {
        $errorMessage = '';
        $validateResult = Validator::validate($_POST, ['name', 'email', 'text']);
        if (!empty($validateResult)) {
            $errorMessage = 'Заполните недостающие поля: ' . implode(', ', $validateResult);
        }

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
        } else {
            $errorMessage .= '<br> E-mail адрес указан НЕверно.';
        }

        if ($errorMessage) {
            $page = includeTemplate('views/task/create.php', []);
            $layout = includeTemplate('views/layout.php', [
                    'errorMessage' => $errorMessage,
                    'page' => $page
                ]
            );
            print($layout);
            return false;
        }

        $name = htmlspecialchars($_POST['name']);
        $text = htmlspecialchars($_POST['text']);

        $task = new Task;
        $taskId = $task->create($name, $email, $text, 'NEW');

        $createdTask = Task::getById($taskId);
        $page = includeTemplate('views/task/show.php', ['task' => $createdTask]);
        $layout = includeTemplate('views/layout.php', [
                'message' => 'Задача #' . $taskId . ' успешно создана',
                'page' => $page
            ]
        );

        print($layout);
    }

    public function edit(int $id)
    {
        Auth::denyIfNotAuth();

        $task = (new Task)->getById($id);
        $page = includeTemplate('views/task/edit.php', ['task' => $task]);
        $layout = includeTemplate('views/layout.php', ['page' => $page]);
        print($layout);
    }

    public function update(int $id)
    {
        Auth::denyIfNotAuth();

        $errorMessage = '';
        $validateResult = Validator::validate($_POST, ['name', 'email', 'text', 'status']);
        if (!empty($validateResult)) {
            $errorMessage = 'Заполните недостающие поля: ' . implode(', ', $validateResult);
        }

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
        } else {
            $errorMessage .= '<br> E-mail адрес указан НЕверно.';
        }

        $task = (new Task)->getById($id);

        if ($errorMessage) {

            $page = includeTemplate('views/task/edit.php', ['task' => $task]);
            $layout = includeTemplate('views/layout.php', [
                    'errorMessage' => $errorMessage,
                    'page' => $page
                ]
            );
            print($layout);
            return false;
        }

        $edited = false;
        $text = htmlspecialchars($_POST['text']);
        if ($task['text'] != $text) {
            $edited = true;
        }
        $name = htmlspecialchars($_POST['name']);

        $status = htmlspecialchars($_POST['status']);

        $task = new Task;
        $result = $task->update($name, $email, $text, $status, $edited, $id);

        $task = (new Task)->getById($id);

        $page = includeTemplate('views/task/edit.php', ['task' => $task]);
        $layout = includeTemplate('views/layout.php', [
                'message' => 'Задача #' . $id . ' успешно изменена',
                'page' => $page
            ]
        );
        print($layout);
    }

    private function getStatus(string $status): string
    {
        switch ($status) {
            case 'NEW':
                return 'Новая';
            case 'RESOLVED':
                return 'Выполнена';
            default:
                return 'Неизвестный статус';
        }
    }
}