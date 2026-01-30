<?php

declare(strict_types=1);


class BookService extends CApplicationComponent
{
    /**
     * Получение списка книг с пагинацией
     *
     * @param int $page Номер страницы
     * @param int $pageSize Количество элементов на странице
     * @return CActiveDataProvider Data provider со списком книг
     */
    public function getList(int $page = 1, int $pageSize = 20): CActiveDataProvider
    {
        return new CActiveDataProvider('Book', [
            'criteria' => [
                'with' => ['authors'],
                'order' => 'created_at DESC',
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
    }

    /**
     * Получение книги по ID
     *
     * @param int $id ID книги
     * @return Book Найденная книга
     * @throws NotFoundException Книга не найдена
     */
    public function getById(int $id): Book
    {
        $book = Book::model()->with('authors')->findByPk($id);
        if (!$book) {
            throw new NotFoundException('Book', $id);
        }
        return $book;
    }

    /**
     * Создание новой книги
     *
     * @param BookDto $dto Данные книги
     * @return Book Созданная книга
     * @throws ValidationException Ошибка валидации
     * @throws FileUploadException Ошибка загрузки файла
     */
    public function createBook(BookDto $dto): Book
    {
        $book = new Book();
        $book
            ->setTitle($dto->title)
            ->setYear($dto->year)
            ->setIsbn($dto->isbn)
            ->setDescription($dto->description);

        if (!$book->validate()) {
            throw new ValidationException($book->getErrors());
        }

        if ($dto->photo) {
            $book->setPhoto(Yii::app()->fileUploader->upload($dto->photo, 'books', 'book'));
        }

        if (!$book->save(false)) {
            throw new ValidationException(['general' => ['Не удалось сохранить книгу']]);
        }

        $this->updateBookAuthors($book, $dto->authorIds);

        try {
            Yii::app()->subscriptionService->queueSmsNotifications($book);
        } catch (QueueException $e) {
            Yii::log("Failed to queue SMS notifications: {$e->getMessage()}", CLogger::LEVEL_ERROR);
        }

        return $book;
    }

    /**
     * Обновление существующей книги
     *
     * @param int $id ID книги
     * @param BookDto $dto Данные книги
     * @return Book Обновленная книга
     * @throws NotFoundException Книга не найдена
     * @throws ValidationException Ошибка валидации
     * @throws FileUploadException Ошибка загрузки файла
     */
    public function updateBook(int $id, BookDto $dto): Book
    {
        $book = $this->getById($id);
        $book
            ->setTitle($dto->title)
            ->setYear($dto->year)
            ->setIsbn($dto->isbn)
            ->setDescription($dto->description);

        if (!$book->validate()) {
            throw new ValidationException($book->getErrors());
        }

        if ($dto->photo) {
            if ($book->getPhoto()) {
                Yii::app()->fileUploader->delete($book->getPhoto());
            }
            $book->setPhoto(Yii::app()->fileUploader->upload($dto->photo, 'books', 'book'));
        }

        if (!$book->save(false)) {
            throw new ValidationException(['general' => ['Не удалось обновить книгу']]);
        }

        $this->updateBookAuthors($book, $dto->authorIds);

        return $book;
    }

    /**
     * Удаление книги
     *
     * @param int $id ID книги
     * @throws NotFoundException Книга не найдена
     * @throws DeleteException|CDbException Ошибка удаления
     */
    public function deleteBook(int $id): void
    {
        $book = $this->getById($id);

        if ($book->getPhoto()) {
            try {
                Yii::app()->fileUploader->delete($book->getPhoto());
            } catch (Exception $e) {
                Yii::log("Failed to delete photo: {$e->getMessage()}", CLogger::LEVEL_WARNING);
            }
        }

        if (!$book->delete()) {
            throw new DeleteException('Не удалось удалить книгу');
        }
    }

    /**
     * Обновление связей книги с авторами
     *
     * @param Book $book Модель книги
     * @param int[] $authorIds Массив ID авторов
     */
    private function updateBookAuthors(Book $book, array $authorIds): void
    {
        $db = Yii::app()->db;
        $bookId = $book->id;

        $db->createCommand()
            ->delete('book_authors', 'book_id = :book_id', [':book_id' => $bookId]);

        if (empty($authorIds)) {
            return;
        }

        $params = [];
        $placeholders = [];
        foreach ($authorIds as $i => $authorId) {
            $placeholders[] = "(:book_id_{$i}, :author_id_{$i})";
            $params[":book_id_{$i}"] = $bookId;
            $params[":author_id_{$i}"] = (int) $authorId;
        }

        $db->createCommand(
            'INSERT INTO book_authors (book_id, author_id) VALUES ' . implode(', ', $placeholders)
        )->execute($params);
    }
}
