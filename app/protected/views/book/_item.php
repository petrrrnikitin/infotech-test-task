<div class="col-12 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <?php if ($data->photo): ?>
                    <div class="col-md-2">
                        <img src="/uploads/<?= CHtml::encode($data->photo) ?>" class="img-fluid rounded" alt="<?= CHtml::encode($data->title) ?>">
                    </div>
                <?php endif; ?>
                <div class="<?= $data->photo ? 'col-md-10' : 'col-12' ?>">
                    <h5 class="card-title"><?= CHtml::link(CHtml::encode($data->title), ['book/view', 'id' => $data->id]) ?></h5>
                    <p class="card-text mb-1"><strong>Год:</strong> <?= CHtml::encode($data->year) ?></p>
                    <p class="card-text mb-1"><strong>ISBN:</strong> <?= CHtml::encode($data->isbn) ?></p>
                    <?php if (!empty($data->authors)): ?>
                        <p class="card-text"><strong>Авторы:</strong>
                            <?php
                            $authors = [];
                            foreach ($data->authors as $author) {
                                $authors[] = CHtml::link($author->getFullName(), ['author/view', 'id' => $author->id]);
                            }
                            echo implode(', ', $authors);
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
