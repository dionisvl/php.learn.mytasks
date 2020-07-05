<?php

namespace App\Helpers;

class Db
{
    public static function getLink()
    {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($link == false) {
            dd('Ошибка подключения: ' . mysqli_connect_error());
        } else {
            //dd ('Подключились успешно к БД');
            return $link;
        }
    }
}