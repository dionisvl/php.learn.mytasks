<?php

namespace App\Model;

use App\Helpers\Db;
use Exception;

class Task
{
    public function create(string $name, string $email, string $text, string $status)
    {
        $query = 'INSERT INTO tasks(name, email, text, status) VALUES(?,?,?,?)';

        $link = Db::getLink();
        $stmt = $link->prepare($query);

        $stmt->bind_param('ssss', $name, $email, $text, $status);

        if ($stmt->execute()) {
            return $link->insert_id;
        } else {
            throw new Exception($link->error);
        }
    }

    public function getAll(string $orderBy, string $orderDirection, int $perPage = 3, int $page = 1)
    {
        $link = Db::getLink();

        $startRow = ($page - 1) * $perPage;

        $query = "
SELECT t.id, t.name, t.email, t.text, t.status, t.edited
    FROM tasks t    
ORDER BY 
    $orderBy $orderDirection
LIMIT $perPage
OFFSET $startRow";
//dump($query);
        $result = mysqli_query($link, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCount(): int
    {
        $link = Db::getLink();

        $result = $link->query("SELECT COUNT(*) FROM `tasks`");
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function getById(int $id)
    {
        $link = Db::getLink();

        $query = "SELECT * FROM tasks WHERE `id` = '$id'";
        $result = mysqli_query($link, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    }

    public function update(string $name, string $email, string $text, string $status, bool $edited, int $id)
    {
        $query = 'UPDATE tasks SET `name`=?, `email`=?,`text`=?,`status`=?,`edited`=? WHERE id=?';

        $link = Db::getLink();
        $stmt = $link->prepare($query);

        $edited = (int)$edited;
        $stmt->bind_param('ssssii', $name, $email, $text, $status, $edited, $id);

        $status = $stmt->execute();
        if ($status === false) {
            throw new Exception($stmt->error);
        }
    }
}