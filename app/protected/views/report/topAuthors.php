<?php
$this->pageTitle = 'ТОП-10 авторов по году';
?>

<h2>ТОП-10 авторов по количеству книг</h2>

<?= CHtml::beginForm('', 'post', ['class' => 'row g-3 align-items-end mb-4']) ?>
    <div class="col-auto">
        <label for="year" class="form-label">Выберите год:</label>
        <input type="number" name="year" id="year" class="form-control" min="1000" max="<?= date('Y') ?>" value="<?= $year ? $year : date('Y') ?>" required>
    </div>
    <div class="col-auto">
        <?= CHtml::submitButton('Показать отчет', ['class' => 'btn btn-primary']) ?>
    </div>
<?= CHtml::endForm() ?>

<?php if ($results !== null): ?>
    <?php if (!empty($results)): ?>
        <h3>Результаты за <?= CHtml::encode($year) ?> год</h3>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Место</th>
                    <th>Автор</th>
                    <th>Количество книг</th>
                </tr>
            </thead>
            <tbody>
                <?php $place = 1; ?>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?= $place++ ?></td>
                        <td><?= CHtml::link($result['author']->getFullName(), ['author/view', 'id' => $result['author']->id]) ?></td>
                        <td><?= $result['book_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">За <?= CHtml::encode($year) ?> год книг не найдено.</div>
    <?php endif; ?>
<?php endif; ?>
