<?php


namespace App\Model;

use App\Helpers\Db;
use Exception;

class User
{
    public function create(string $name, string $password, string $email)
    {
        $query = 'INSERT INTO users(name, password, email) VALUES(?,?,?)';

        $link = Db::getLink();
        $stmt = $link->prepare($query);
        $stmt->bind_param('sss', $name, $password, $email);

        if ($stmt->execute()) {
            return $link->insert_id;
        } else {
            throw new Exception($link->error);
        }
    }

    public static function getById(int $id)
    {
        $link = Db::getLink();

        $query = "SELECT * FROM users WHERE `id` = '$id'";
        $result = mysqli_query($link, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function getByName(string $name)
    {
        $link = Db::getLink();

        $sql = "SELECT * FROM users WHERE name=?"; // SQL with parameters
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $name);

        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        while ($row = $result->fetch_assoc()) {
            return $row;
        }

    }

    //проверка данных авторизации
//    function ValidData($login, $pass)
//    {
//        $sql = "SELECT * FROM users WHERE login='$login' and pass='$pass'";
//        $result = mysql_query($sql) or die(mysql_error());
//        if (mysql_num_rows($result)) {
//            $_SESSION["Auth"] = true;
//            $_SESSION["User"] = $login;
//        } else $_SESSION["Auth"] = false;
//
//        if (!$_SESSION["Auth"]) {
//            $msg = "<em><span style='color:red'>Данные введены не верно!</span></em>";
//        } else {
//            $msg = "<em><span style='color:green'>Вы верно ввели данные!</span></em>";
//            $unVisibleForm = true;
//        }
//
//        $result = array("unVisibleForm" => $unVisibleForm,
//            "userName" => $login,
//            "msg" => $msg,
//            "login" => $login,
//            "pass" => $pass,);
//        return $result;
//    }
}


?>  
  