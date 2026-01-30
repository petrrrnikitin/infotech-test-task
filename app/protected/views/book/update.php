<?php

$this->pageTitle = 'Редактировать книгу: ' . $model->title;
?>

<h2>Редактировать книгу: <?= CHtml::encode($model->title) ?></h2>

<?= $this->renderPartial('_form', ['model' => $model]) ?>
