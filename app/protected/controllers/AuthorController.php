<?php

class AuthorController extends Controller
{
	public function actionIndex(): void
    {
        $dataProvider = Yii::app()->authorService->getList(1, 10);
        $this->render('index', ['dataProvider' => $dataProvider]);
	}

    public function actionView(int $id): void
    {
        try {
            $author = Yii::app()->authorService->getById($id);
            $this->render('view', ['model' => $author]);
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        }
    }
}
