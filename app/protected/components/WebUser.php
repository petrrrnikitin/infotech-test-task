<?php

class WebUser extends CWebUser
{
    /**
     * Проверяет, имеет ли пользователь указанное разрешение
     */
    public function checkAccess($operation, $params = [], $allowCaching = true): bool
    {
        if ($this->isGuest) {
            return Yii::app()->authManager->checkAccess($operation, 'guest', $params);
        }

        $role = $this->getState('role', 'user');
        return Yii::app()->authManager->checkAccess($operation, $role, $params);
    }

    /**
     * Возвращает роль текущего пользователя
     */
    public function getRole(): string
    {
        if ($this->isGuest) {
            return 'guest';
        }
        return $this->getState('role', 'user');
    }

    /**
     * Проверяет, является ли пользователь обычным пользователем или выше
     */
    public function isUser(): bool
    {
        return !$this->isGuest;
    }
}
