<?php
$this->pageTitle = $model->getFullName();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><?= CHtml::encode($model->getFullName()) ?></h2>
</div>

<table class="table table-bordered">
    <tbody>
        <tr>
            <th style="width: 200px;">Фамилия</th>
            <td><?= CHtml::encode($model->last_name) ?></td>
        </tr>
        <tr>
            <th>Имя</th>
            <td><?= CHtml::encode($model->first_name) ?></td>
        </tr>
        <tr>
            <th>Отчество</th>
            <td><?= CHtml::encode($model->middle_name) ?></td>
        </tr>
    </tbody>
</table>

<h4 class="mt-4">Книги автора</h4>

<?php if (!empty($model->books)): ?>
    <ul class="list-group mb-4">
        <?php foreach ($model->books as $book): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= CHtml::link(CHtml::encode($book->title), ['book/view', 'id' => $book->id]) ?>
                <span class="badge bg-secondary"><?= $book->year ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <div class="alert alert-info">У этого автора пока нет книг в каталоге.</div>
<?php endif; ?>

<p><?= CHtml::link('Назад к списку', ['index'], ['class' => 'btn btn-secondary']) ?></p>
