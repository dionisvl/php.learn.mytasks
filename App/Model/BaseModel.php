<?php


namespace App\Model;


use App\Helpers\Db;

class BaseModel
{
    protected $link;

    public function __construct()
    {
        $this->link = Db::getLink();
    }
}