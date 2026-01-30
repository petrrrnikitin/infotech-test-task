<?php

class AuthorController extends Controller
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
                'actions' => ['index', 'view', 'subscribe'],
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

    public function actionCreate(): void
    {
        $authorData = Yii::app()->request->getPost('Author');

        if ($authorData !== null) {
            try {
                $author = Yii::app()->authorService->createAuthor(AuthorDto::fromRequest($authorData));
                Yii::app()->user->setFlash('success', 'Автор успешно создан');
                $this->redirect(['view', 'id' => $author->id]);
            } catch (ValidationException $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $this->render('create', ['model' => new Author()]);
    }

    public function actionUpdate(int $id): void
    {
        $authorData = Yii::app()->request->getPost('Author');

        try {
            if ($authorData === null) {
                $model = Yii::app()->authorService->getById($id);
                $this->render('update', ['model' => $model]);
                return;
            }

            Yii::app()->authorService->updateAuthor($id, AuthorDto::fromRequest($authorData));
            Yii::app()->user->setFlash('success', 'Автор успешно обновлен');
            $this->redirect(['view', 'id' => $id]);
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        } catch (ValidationException $e) {
            Yii::app()->user->setFlash('error', $e->getMessage());
        }

        $model = Yii::app()->authorService->getById($id);
        $this->render('update', ['model' => $model]);
    }

    public function actionDelete(int $id): void
    {
        try {
            Yii::app()->authorService->deleteAuthor($id);
            Yii::app()->user->setFlash('success', 'Автор успешно удален');
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        } catch (DeleteException $e) {
            Yii::app()->user->setFlash('error', $e->getMessage());
        }

        $this->redirect(['index']);
    }


    /**
     * @throws CHttpException
     */
    public function actionSubscribe(int $id): void
    {
        $phone = Yii::app()->request->getPost('phone')
            ?? throw new CHttpException(400, 'Телефон обязателен');

        try {
            Yii::app()->subscriptionService->subscribe($id, $phone);
            Yii::app()->user->setFlash('success', 'Вы успешно подписались на уведомления');
        } catch (ValidationException|DuplicateSubscriptionException $e) {
            Yii::app()->user->setFlash('error', $e->getMessage());
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        }

        $this->redirect(['view', 'id' => $id]);
    }
}
