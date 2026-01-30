<?php

class SubscriptionController extends Controller
{
    public function filters(): array
    {
        return [
            'accessControl',
            'postOnly + subscribe',
        ];
    }

    public function accessRules(): array
    {
        return [
            [
                'allow',
                'actions' => ['subscribe'],
                'users' => ['*'],
            ],
            [
                'deny',
                'users' => ['*'],
            ],
        ];
    }

    /**
     * @throws CHttpException
     */
    public function actionSubscribe(int $authorId): void
    {
        $phone = Yii::app()->request->getPost('phone')
            ?? throw new CHttpException(400, 'Телефон обязателен');

        try {
            Yii::app()->subscriptionService->subscribe($authorId, $phone);
            Yii::app()->user->setFlash('success', 'Вы успешно подписались на уведомления');
        } catch (ValidationException | DuplicateSubscriptionException $e) {
            Yii::app()->user->setFlash('error', $e->getMessage());
        } catch (NotFoundException $e) {
            throw new CHttpException(404, $e->getMessage());
        }

        $this->redirect(['author/view', 'id' => $authorId]);
    }
}
