<?php

interface JobInterface
{
    /**
     * Выполнение задачи
     *
     * @param array $data Данные задачи
     */
    public function handle(array $data): void;
}