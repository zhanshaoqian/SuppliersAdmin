<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Supplier Export';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please select fields to export</p>
    <?php $form = ActiveForm::begin([
        'id' => 'export-form',
        'layout' => 'horizontal',
        'action' => 'export',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <div class="col-lg-3">
        <input type="checkbox" name="id" checked="true" disabled="disabled" >
        <label>ID</label>
    </div>

    <div class="col-lg-3">
        <input type="checkbox" name="name">
        <label>Name</label>
    </div>

    <div class="col-lg-3">
        <input type="checkbox" name="code">
        <label>Code</label>
    </div>

    <div class="col-lg-3">
        <input type="checkbox" name="t_status">
        <label>Status</label>
    </div>

    <?= Html::activeHiddenInput($model,'ids') ?>
<!--    <input type="hidden" name="selectKeys" value="">-->

    <div class="form-group" style="text-align: center;margin-top: 50px;">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Ok', ['class' => 'btn btn-primary', 'name' => 'export-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
