<?php

class UserService extends CApplicationComponent
{
    /**
     * Регистрация нового пользователя
     *
     * @param UserRegistrationDto $dto Данные регистрации
     * @return User Созданный пользователь
     * @throws ValidationException Ошибка валидации
     */
    public function register(UserRegistrationDto $dto): User
    {
        $user = new User();
        $user->scenario = 'register';

        $user->password = $dto->password;
        $user
            ->setUsername($dto->username)
            ->setPassword($dto->password)
            ->setEmail($dto->email)
            ->setRole('user');

        if (!$user->validate()) {
            throw new ValidationException($user->getErrors());
        }

        if (!$user->save(false)) {
            throw new ValidationException(['general' => ['Не удалось создать пользователя']]);
        }

        return $user;
    }
}
