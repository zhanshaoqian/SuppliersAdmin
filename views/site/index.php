<?php
use yii\helpers\Html;
use yii\grid\GridView;
echo Html::jsFile('@web/assets/371f50c2/jquery.js');
?>
<div id="page-wrapper">
    <a class="btn btn-primary" style="float:right" id="exportBtn">Export</a>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <?php echo GridView::widget([
                'id' => 'suppliers',
                'filterModel' => $model,
                'dataProvider' => $provider,
                'columns' => [
                    ['class' => 'yii\grid\CheckboxColumn'],
                    [
                        'label' => 'ID',
                        'attribute' => 'id',
                        'format' => 'raw',
                        'headerOptions' => [
                            'style' => 'width:120px;',
                        ],
                    ],
                    [
                        'label' => 'Name',
                        'attribute' => 'name',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Code',
                        'attribute' => 'code',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Status',
                        'filter' => ['ok' =>'ok','hold' =>'hold'],
                        'attribute' => 't_status',
                        'format' => 'raw'
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#exportBtn').on('click', function () {
        var ids = $('#suppliers').yiiGridView('getSelectedRows');
        if (ids == '') {
            alert('Please select items to export');
            return;
        }
        window.location = '<?= Yii::$app->urlManager->createUrl('site/supplier')?>?ids=' + ids;
    });
</script>