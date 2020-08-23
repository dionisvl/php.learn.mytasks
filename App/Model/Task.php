<?php

namespace App\Model;

use App\Helpers\Db;
use Exception;

class Task
{
    private $link;

    public function __construct()
    {
        $this->link = Db::getLink();
    }

    public function create(string $name, string $email, string $text, string $status)
    {
        $query = 'INSERT INTO tasks(name, email, text, status) VALUES(?,?,?,?)';

        $stmt = $this->link->prepare($query);

        $stmt->bind_param('ssss', $name, $email, $text, $status);

        if ($stmt->execute()) {
            return $this->link->insert_id;
        } else {
            throw new Exception($this->link->error);
        }
    }

    public function getAll(string $orderBy, string $orderDirection, int $perPage = 3, int $page = 1)
    {
        $startRow = ($page - 1) * $perPage;

        $query = "
SELECT t.id, t.name, t.email, t.text, t.status, t.edited
    FROM tasks t    
ORDER BY 
    $orderBy $orderDirection
LIMIT $perPage
OFFSET $startRow";

        $result = mysqli_query($this->link, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCount(): int
    {
        $result = $this->link->query("SELECT COUNT(*) FROM `tasks`");
        $row = $result->fetch_row();
        return $row[0];
    }

    public static function getById(int $id)
    {
        $query = "SELECT * FROM tasks WHERE `id` = '$id'";
        $result = mysqli_query(Db::getLink(), $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    }

    public function update(string $name, string $email, string $text, string $status, bool $edited, int $id)
    {
        $query = 'UPDATE tasks SET `name`=?, `email`=?,`text`=?,`status`=?,`edited`=? WHERE id=?';

        $stmt = $this->link->prepare($query);

        $edited = (int)$edited;
        $stmt->bind_param('ssssii', $name, $email, $text, $status, $edited, $id);

        $status = $stmt->execute();
        if ($status === false) {
            throw new Exception($stmt->error);
        }
    }
}