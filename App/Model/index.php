<?php

//Модель вывода картинки
class application_models_index
{
    function resizeimg($username, $email, $zadanie)
    {
        //*************************************************************************

        $msg = "
                    <p class=\"alert alert-success\" role=\"alert\">Уважаемый(ая) $username! Рады сообщить, что Ваше задание и изображение загружены успешно!</p>
                    <p>Ваш e-mail: $email, Ваше задание: $zadanie</p>
                    ";


        //вносим информацию в БД
        $query = mysql_query("
                    INSERT INTO resultTable(username, email,zadacha,image)
                    VALUES ('$username','$email','$zadanie');
                    ")
        or die(mysql_error());
        $result = array(
            "username" => $username,
            "email" => $email,
            "zadanie" => $zadanie,
            "msg" => $msg);

        return $result;

    }

}


?>