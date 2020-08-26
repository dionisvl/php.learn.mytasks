<?php

namespace App\Controller;


use App\Helpers\Auth;
use App\Helpers\Db;
use App\Helpers\Validator;
use App\Model\Task;

class TaskController extends BaseController
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
            $link = Db::getLink();
            $_SESSION['orderDirection'] = $orderDirection = $link->real_escape_string(mb_strimwidth($_GET['orderDirection'], 0, 10));
        }

        if (empty(mb_strimwidth($_GET['orderBy'], 0, 20))) {
            if (empty($_SESSION['orderBy'])) {
                $_SESSION['orderBy'] = $orderBy = 'name';
            } else {
                $orderBy = $_SESSION['orderBy'];
            }
        } else {
            $link = Db::getLink();
            $_SESSION['orderBy'] = $orderBy = $link->real_escape_string(mb_strimwidth($_GET['orderBy'], 0, 20));
        }

        $task = new Task;

        $requestedPage = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $count = $task->getCount();
        $pagesCount = ceil($count / $this->perPage);

        $tasks = $task->getAll($orderBy, $orderDirection, $this->perPage, $requestedPage);

        $this->print('/task/index.html.twig', [
            'tasks' => $tasks,
            'curPage' => $requestedPage,
            'pagesCount' => $pagesCount,
            'header' => "Список задач"
        ]);
    }

    public function create()
    {
        $this->print('/task/create.html.twig', [
            'header' => "Создание задачи"
        ]);
    }

    public function show(int $id)
    {
        $task = (new Task)->getById($id);
        $this->print('/task/show.html.twig', [
            'task' => $task,
            'header' => "Просмотр задачи № $task[id] ",
        ]);
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
            $this->print('/task/create.html.twig', [
                'header' => 'Создание новой задачи',
                'errorMessage' => $errorMessage,
            ]);
            return false;
        }

        $name = htmlspecialchars($_POST['name']);
        $text = htmlspecialchars($_POST['text']);

        $task = new Task;
        $taskId = $task->create($name, $email, $text, 'NEW');

        $createdTask = Task::getById($taskId);

        $this->print('/task/show.html.twig', [
            'task' => $createdTask,
            'header' => 'Создание новой задачи',
            'message' => 'Задача #' . $taskId . ' успешно создана',
        ]);
    }

    public function edit(int $id)
    {
        Auth::denyIfNotAuth();

        $task = (new Task)->getById($id);

        $this->print('/task/edit.html.twig', [
            'task' => $task,
            'header' => 'Изменение задачи'
        ]);
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
            $this->print('/task/edit.html.twig', [
                'task' => $task,
                'header' => "Изменение задачи #$task[id]",
                'errorMessage' => $errorMessage,
            ]);
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

        $this->print('/task/edit.html.twig', [
            'task' => $task,
            'message' => 'Задача #' . $id . ' успешно изменена',
            'header' => "Изменение задачи #$task[id]"
        ]);
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