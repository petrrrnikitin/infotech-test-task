<?php

class NotFoundException extends BaseException
{
    public function __construct($model, $id)
    {
        parent::__construct("{$model} с ID {$id} не найден");
    }
}
