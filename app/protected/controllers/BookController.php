<?php

declare(strict_types=1);

class BookController extends CController
{
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
}
