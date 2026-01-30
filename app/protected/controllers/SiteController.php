<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions(): array
    {
        return [
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => [
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ],
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => [
                'class' => 'CViewAction',
            ],
        ];
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex(): void
    {
        $dataProvider = Yii::app()->bookService->getList(1, 10);
        $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError(): void
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }


    /**
     * Displays the login page
     */
    public function actionLogin(): void
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
            return;
        }

        $model = new LoginForm();
        $formData = Yii::app()->request->getPost('LoginForm');

        if ($formData !== null) {
            $model->attributes = $formData;

            if ($model->validate() && $model->login()) {
                Yii::app()->user->setFlash('success', 'Вы успешно вошли в систему');
                $this->redirect(Yii::app()->user->returnUrl);
                return;
            }
        }

        $this->render('login', ['model' => $model]);
    }

    public function actionRegister(): void
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(['site/index']);
            return;
        }

        $userData = Yii::app()->request->getPost('User');

        if ($userData !== null) {
            try {
                Yii::app()->userService->register(UserRegistrationDto::fromRequest($userData));
                Yii::app()->user->setFlash('success', 'Регистрация прошла успешно. Теперь вы можете войти.');
                $this->redirect(['site/login']);
                return;
            } catch (ValidationException $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $model = new User();
        $model->scenario = 'register';
        $this->render('register', ['model' => $model]);
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout(): void
    {
        Yii::app()->user->logout();
        Yii::app()->user->setFlash('success', 'Вы вышли из системы');
        $this->redirect(Yii::app()->homeUrl);
    }
}
