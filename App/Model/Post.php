<?php

namespace App\Model;

use App\Helpers\Db;
use Exception;

class Post extends BaseModel
{
    public static function getById(int $id)
    {
        $query = "SELECT * FROM post WHERE `id` = '$id'";
        $result = mysqli_query(Db::getLink(), $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    }

    public static function getBySlug(string $slug)
    {
        $query = "SELECT * FROM post WHERE slug=?";

        $mysqli = Db::getLink();

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $post = $stmt->get_result()->fetch_assoc();
        $stmt->fetch();
        $stmt->close();

        return $post;
    }

    public function getAll(string $orderBy, string $orderDirection, int $perPage = 10000, int $page = 1)
    {
        $startRow = ($page - 1) * $perPage;

        $query = "
SELECT *
    FROM post    
ORDER BY 
    $orderBy $orderDirection
LIMIT $perPage
OFFSET $startRow";

        $result = mysqli_query($this->link, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCount(): int
    {
        $result = $this->link->query("SELECT COUNT(*) FROM `post`");
        $row = $result->fetch_row();
        return $row[0];
    }
}