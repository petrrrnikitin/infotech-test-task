<?php

declare(strict_types=1);

class AuthorService extends CApplicationComponent
{
    /**
     * Получение списка авторов с пагинацией
     *
     * @param int $page Номер страницы
     * @param int $pageSize Количество элементов на странице
     * @return CActiveDataProvider Data provider со списком авторов
     */
    public function getList(int $page = 1, int $pageSize = 20): CActiveDataProvider
    {
        $criteria = new CDbCriteria();
        $criteria->select = [
            't.*',
            '(SELECT COUNT(*) FROM book_authors WHERE author_id = t.id) AS books_count',
        ];

        return new CActiveDataProvider('Author', [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => 'last_name, first_name',
                'attributes' => [
                    'id',
                    'first_name',
                    'last_name',
                    'middle_name',
                    'full_name' => [
                        'asc' => 'last_name ASC, first_name ASC, middle_name ASC',
                        'desc' => 'last_name DESC, first_name DESC, middle_name DESC',
                    ],
                    'books_count' => [
                        'asc' => 'books_count ASC',
                        'desc' => 'books_count DESC',
                    ],
                ],
            ],
        ]);
    }

    /**
     * Получение автора по ID
     *
     * @param int $id ID автора
     * @return Author Найденный автор
     * @throws NotFoundException Автор не найден
     */
    public function getById(int $id): Author
    {
        $author = Author::model()->with('books')->findByPk($id);
        if (!$author) {
            throw new NotFoundException('Author', $id);
        }
        return $author;
    }
}
