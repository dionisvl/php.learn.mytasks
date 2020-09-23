<?php


namespace App\Model;

use App\Helpers\Db;
use Exception;

class User extends BaseModel
{
    public function create(string $name, string $password, string $email)
    {
        $query = 'INSERT INTO users(name, password, email) VALUES(?,?,?)';

        $stmt = $this->link->prepare($query);
        $stmt->bind_param('sss', $name, $password, $email);

        if ($stmt->execute()) {
            return $this->link->insert_id;
        } else {
            throw new Exception($this->link->error);
        }
    }

    public static function getById(int $id)
    {
        $query = "SELECT * FROM users WHERE `id` = '$id'";
        $result = mysqli_query(Db::getLink(), $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function getByName(string $name)
    {
        $sql = "SELECT * FROM users WHERE name=?"; // SQL with parameters
        $link = Db::getLink();
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $name);

        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        while ($row = $result->fetch_assoc()) {
            return $row;
        }
    }
}