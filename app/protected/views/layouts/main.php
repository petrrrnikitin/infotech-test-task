<?php
/* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= CHtml::encode($this->pageTitle) ?> - Каталог книг</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container" id="page">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= Yii::app()->createUrl('/site/index') ?>">Каталог книг</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <?= CHtml::link('Книги', ['/book/index'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= CHtml::link('Авторы', ['/author/index'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= CHtml::link('Отчет', ['/report/topAuthors'], ['class' => 'nav-link']) ?>
                    </li>
                    <?php if (!Yii::app()->user->isGuest): ?>
                        <li class="nav-item">
                            <?= CHtml::link('Добавить книгу', ['/book/create'], ['class' => 'nav-link']) ?>
                        </li>
                        <li class="nav-item">
                            <?= CHtml::link('Добавить автора', ['/author/create'], ['class' => 'nav-link']) ?>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (!Yii::app()->user->isGuest): ?>
                        <li class="nav-item">
                            <?= CHtml::link('Выйти', ['/site/logout'], ['class' => 'nav-link']) ?>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <?= CHtml::link('Войти', ['/site/login'], ['class' => 'nav-link']) ?>
                        </li>
                        <li class="nav-item">
                            <?= CHtml::link('Регистрация', ['/site/register'], ['class' => 'nav-link']) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="bg-white p-4 rounded shadow-sm">
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= Yii::app()->user->getFlash('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= Yii::app()->user->getFlash('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
