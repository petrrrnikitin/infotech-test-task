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

    /**
     * Создание нового автора
     *
     * @param AuthorDto $dto Данные автора
     * @return Author Созданный автор
     * @throws ValidationException Ошибка валидации
     */
    public function createAuthor(AuthorDto $dto): Author
    {
        $author = new Author();
        $author
            ->setFirstName($dto->firstName)
            ->setLastName($dto->lastName)
            ->setMiddleName($dto->middleName);

        if (!$author->validate()) {
            throw new ValidationException($author->getErrors());
        }

        if (!$author->save(false)) {
            throw new ValidationException(['general' => ['Не удалось сохранить автора']]);
        }

        return $author;
    }

    /**
     * Обновление существующего автора
     *
     * @param int $id ID автора
     * @param AuthorDto $dto Данные автора
     * @return Author Обновленный автор
     * @throws NotFoundException Автор не найден
     * @throws ValidationException Ошибка валидации
     */
    public function updateAuthor(int $id, AuthorDto $dto): Author
    {
        $author = $this->getAuthorById($id);
        $author
            ->setFirstName($dto->firstName)
            ->setLastName($dto->lastName)
            ->setMiddleName($dto->middleName);

        if (!$author->validate()) {
            throw new ValidationException($author->getErrors());
        }

        if (!$author->save(false)) {
            throw new ValidationException(['general' => ['Не удалось обновить автора']]);
        }

        return $author;
    }

    /**
     * Удаление автора
     *
     * @param int $id ID автора
     * @return void
     * @throws NotFoundException Автор не найден
     * @throws DeleteException|CDbException Ошибка удаления
     */
    public function deleteAuthor(int $id): void
    {
        $author = $this->getById($id);

        $bookCount = Yii::app()->db->createCommand()
            ->select('COUNT(*)')
            ->from('book_authors')
            ->where('author_id = :author_id', [':author_id' => $author->id])
            ->queryScalar();

        if ($bookCount > 0) {
            throw new DeleteException('Невозможно удалить автора, у которого есть книги');
        }

        if (!$author->delete()) {
            throw new DeleteException('Не удалось удалить автора');
        }
    }


    /**
     * Получение ТОП авторов по году издания книг
     *
     * @param int $year Год издания
     * @param int $limit Лимит результатов
     * @return array{author: Author, book_count: int}[] Массив с авторами и количеством книг
     */
    public function getTopAuthorsByYear(int $year, int $limit = 10): array
    {
        $rows = Yii::app()->db->createCommand()
            ->select('a.id, a.first_name, a.last_name, a.middle_name, COUNT(DISTINCT b.id) as book_count')
            ->from('authors a')
            ->join('book_authors ba', 'ba.author_id = a.id')
            ->join('books b', 'b.id = ba.book_id')
            ->where('b.year = :year', [':year' => $year])
            ->group('a.id')
            ->order('book_count DESC')
            ->limit($limit)
            ->queryAll();

        $results = [];
        foreach ($rows as $row) {
            $author = new Author();
            $author->setAttributes($row, false);
            $results[] = [
                'author' => $author,
                'book_count' => (int)$row['book_count'],
            ];
        }

        return $results;
    }
}
