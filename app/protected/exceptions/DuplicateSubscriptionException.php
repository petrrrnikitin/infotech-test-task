<?php

class DuplicateSubscriptionException extends BaseException
{
    public function __construct()
    {
        parent::__construct('Вы уже подписаны на этого автора');
    }
}
