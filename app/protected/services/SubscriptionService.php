<?php

class SubscriptionService extends CApplicationComponent
{
    /**
     * Создание подписки на уведомления о новых книгах автора
     *
     * @param int $authorId ID автора
     * @param string $phone Номер телефона
     * @return Subscription Созданная подписка
     * @throws NotFoundException Автор не найден
     * @throws ValidationException Ошибка валидации
     * @throws DuplicateSubscriptionException Подписка уже существует
     */
    public function subscribe(int $authorId, string $phone): Subscription
    {
        $author = Author::model()->findByPk($authorId);
        if (!$author) {
            throw new NotFoundException('Author', $authorId);
        }

        $existing = Subscription::model()->findByAttributes([
            'author_id' => $authorId,
            'phone' => $phone,
        ]);

        if ($existing) {
            throw new DuplicateSubscriptionException();
        }

        $subscription = new Subscription();
        $subscription->author_id = $authorId;
        $subscription->phone = $phone;

        if (!$subscription->validate()) {
            throw new ValidationException($subscription->getErrors());
        }

        if (!$subscription->save(false)) {
            throw new ValidationException(['general' => ['Не удалось создать подписку']]);
        }

        return $subscription;
    }

    /**
     * Получение подписчиков по массиву ID авторов
     *
     * @param int[] $authorIds Массив ID авторов
     * @return Subscription[] Массив объектов Subscription
     */
    public function getSubscribersByAuthorIds(array $authorIds): array
    {
        if (empty($authorIds)) {
            return [];
        }

        $criteria = new CDbCriteria();
        $criteria->select = 'DISTINCT t.phone';
        $criteria->addInCondition('author_id', $authorIds);

        return Subscription::model()->findAll($criteria);
    }

    /**
     * Постановка задач на отправку SMS уведомлений о новой книге
     *
     * @param Book $book Модель книги
     * @throws QueueException Ошибка постановки в очередь
     */
    public function queueSmsNotifications(Book $book): void
    {
        $authorIds = array_map(static fn(Author $author) => $author->id, $book->authors);

        if (empty($authorIds)) {
            return;
        }

        $subscriptions = $this->getSubscribersByAuthorIds($authorIds);

        $authorNames = implode(', ',
            array_map(
                static fn(Author $author) => $author->getFullName(),
                $book->authors)
        );
        $message = "Новая книга: \"{$book->getTitle()}\" ({$authorNames})";

        array_map(static fn(Subscription $subscription) => Yii::app()->queue->push('SendSmsJob', [
            'phone' => $subscription->phone,
            'message' => $message,
        ]), $subscriptions);
    }
}
