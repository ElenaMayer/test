<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'ЛК';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'surname',
            'phone',
            'email',
            'birthday',
            'sex',
        ],
    ]) ?>

</div>
