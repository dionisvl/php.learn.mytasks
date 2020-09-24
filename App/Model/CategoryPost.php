<?php

namespace App\Model;

use App\Helpers\Db;
use Exception;

class CategoryPost extends BaseModel
{
    public static function getById(int $id)
    {
        $query = "SELECT * FROM category_post WHERE `id` = '$id'";
        $result = mysqli_query(Db::getLink(), $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    }

    public function getAll(string $orderBy, string $orderDirection, int $perPage = 3, int $page = 1)
    {
        $startRow = ($page - 1) * $perPage;

        $query = "
SELECT *
    FROM category_post    
ORDER BY 
    $orderBy $orderDirection
LIMIT $perPage
OFFSET $startRow";

        $result = mysqli_query($this->link, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCount(): int
    {
        $result = $this->link->query("SELECT COUNT(*) FROM `category_post`");
        $row = $result->fetch_row();
        return $row[0];
    }
}