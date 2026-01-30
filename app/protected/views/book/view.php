<?php

$this->pageTitle = $model->title;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><?= CHtml::encode($model->title) ?></h2>
    <?php
    if (!Yii::app()->user->isGuest): ?>
        <div>
            <?= CHtml::link('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary me-2']
            ) ?>
            <?= CHtml::link(
                    'Удалить',
                    ['delete', 'id' => $model->id],
                    ['class' => 'btn btn-danger', 'confirm' => 'Вы уверены?']
            ) ?>
        </div>
    <?php
    endif; ?>
</div>

<?php
if ($model->photo): ?>
    <div class="mb-4">
        <img src="/uploads/<?= CHtml::encode($model->photo) ?>" class="img-thumbnail book-photo"
             alt="<?= CHtml::encode($model->title) ?>">
    </div>
<?php
endif; ?>

<table class="table table-bordered">
    <tbody>
    <tr>
        <th style="width: 200px;">Название</th>
        <td><?= CHtml::encode($model->title) ?></td>
    </tr>
    <tr>
        <th>Год издания</th>
        <td><?= CHtml::encode($model->year) ?></td>
    </tr>
    <tr>
        <th>ISBN</th>
        <td><?= CHtml::encode($model->isbn) ?></td>
    </tr>
    <tr>
        <th>Описание</th>
        <td><?= CHtml::encode($model->description) ?></td>
    </tr>
    <tr>
        <th>Авторы</th>
        <td>
            <?php
            if (!empty($model->authors)) {
                $authors = [];
                foreach ($model->authors as $author) {
                    $authors[] = CHtml::link($author->getFullName(), ['author/view', 'id' => $author->id]);
                }
                echo implode(', ', $authors);
            }
            ?>
        </td>
    </tr>
    </tbody>
</table>

<p><?= CHtml::link('Назад к списку', ['index'], ['class' => 'btn btn-secondary']) ?></p>
