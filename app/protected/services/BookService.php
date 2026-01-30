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
}
