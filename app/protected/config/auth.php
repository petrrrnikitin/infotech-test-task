<?php

return [
    'viewBook' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр книг',
    ],
    'viewAuthor' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр авторов',
    ],
    'subscribe' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Подписка на новые книги автора',
    ],
    'createBook' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Добавление книги',
    ],
    'updateBook' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование книги',
    ],
    'deleteBook' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление книги',
    ],
    'createAuthor' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Добавление автора',
    ],
    'updateAuthor' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование автора',
    ],
    'deleteAuthor' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление автора',
    ],

    'guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'children' => [
            'viewBook',
            'viewAuthor',
            'subscribe',
        ],
    ],
    'user' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователь',
        'children' => [
            'guest',
            'createBook',
            'updateBook',
            'deleteBook',
            'createAuthor',
            'updateAuthor',
            'deleteAuthor',
        ],
    ],
];
