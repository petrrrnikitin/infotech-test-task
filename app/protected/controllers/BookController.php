<?php

declare(strict_types=1);

class BookController extends Controller
{
    public function filters(): array
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules(): array
    {
        return [
            [
                'allow',
                'actions' => ['index', 'view'],
                'users' => ['*'],
            ],
            [
                'allow',
                'actions' => ['create', 'update', 'delete'],
                'users' => ['@'],
            ],
            [
                'deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex(): void
    {
        $dataProvider = Yii::app()->bookService->getList(1, 10);
        $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @throws CHttpException
     */
    public function actionView(int $id): void
    {
        try {
            $book = Yii::app()->bookService->getById($id);
            $this->render('view', ['model' => $book]);
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        }
    }

    public function actionCreate(): void
    {
        $bookData = Yii::app()->request->getPost('Book');

        if ($bookData !== null) {
            try {
                $book = Yii::app()->bookService->createBook(BookDto::fromRequest($bookData));
                Yii::app()->user->setFlash('success', 'Книга успешно создана');
                $this->redirect(['view', 'id' => $book->id]);
            } catch (ValidationException | FileUploadException $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $this->render('create', ['model' => new Book()]);
    }

    public function actionUpdate(int $id): void
    {
        $bookData = Yii::app()->request->getPost('Book');

        try {
            if ($bookData === null) {
                $model = Yii::app()->bookService->getById($id);
                $this->render('update', ['model' => $model]);
                return;
            }

            Yii::app()->bookService->updateBook($id, BookDto::fromRequest($bookData));
            Yii::app()->user->setFlash('success', 'Книга успешно обновлена');
            $this->redirect(['view', 'id' => $id]);
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        } catch (ValidationException | FileUploadException $e) {
            Yii::app()->user->setFlash('error', $e->getMessage());
        }

        $model = Yii::app()->bookService->getById($id);
        $this->render('update', ['model' => $model]);
    }

    public function actionDelete(int $id): void
    {
        try {
            Yii::app()->bookService->deleteBook($id);
            Yii::app()->user->setFlash('success', 'Книга успешно удалена');
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        } catch (DeleteException $e) {
            Yii::app()->user->setFlash('error', $e->getMessage());
        }

        $this->redirect(['index']);
    }
}
