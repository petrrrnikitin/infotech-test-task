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
                </ul>
            </div>
        </div>
    </nav>
    <div class="bg-white p-4 rounded shadow-sm">
        <?= $content ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
