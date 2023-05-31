<?php

namespace App\Repositories;


use App\Models\Message;

class  MessageRepository {

    protected $entity;

    public function __construct(Message $model){
        $this->entity = $model;
    }
}
