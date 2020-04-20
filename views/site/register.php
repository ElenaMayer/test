<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'surname')->textInput() ?>

        <?= $form->field($model, 'sex')->radioList(['female' => 'женщина', 'male' => 'мужчина']) ?>

        <?= Html::activeLabel($model, 'birthday'); ?>

        <div class="clearfix"></div>
        <div class="col-lg-1"></div>
        <?= $form->field($model, 'birthday_day')->dropDownList(User::getDateList(), ['prompt' => 'день'])->label(false) ?>
        <div class="col-lg-1"></div>
        <?= $form->field($model, 'birthday_month')->dropDownList(User::getMonthList(), ['prompt' => 'месяц'])->label(false) ?>
        <div class="col-lg-1"></div>
        <?= $form->field($model, 'birthday_year')->dropDownList(User::getYearList(), ['prompt' => 'год'])->label(false) ?>

        <?= $form->field($model, 'phone')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'confirm')->checkbox([
                'value' => 1,
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} Я принимаю условия пользовательского <a href='#'>соглашения</a></div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>


        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
