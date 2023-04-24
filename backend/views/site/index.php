<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = 'Мой склад';
?>

    <!-- Page Heading -->
    <!--    <div class="d-sm-flex align-items-center justify-content-between mb-4">-->
    <!--        <h1 class="h3 mb-0 text-gray-800">Дашборд</h1>-->
    <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i-->
    <!--                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
    <!--    </div>-->

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Ежедневный отчет
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $ <?= \app\modules\order\models\Order::getDailyOrderAmount() ?> </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Количество заказов в
                                день
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= \app\modules\order\models\Order::getDailyOrderTotal() ?>
                                        заказов
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-8 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Выберите желаемую дату для получения отчета</h6>
                </div>
                <!-- Card Body -->
                <div class="row">
                    <div class="col-lg-4 card-body">
                        <?php
                        echo DatePicker::widget([
                            'model' => new \app\modules\product\models\Product(),
                            'attribute' => 'created_at',
                            'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                            'options' => array(//               'showOn' => 'both'
                            ),
                            'inline' => true,
                        ]);
                        ?>
                    </div>
                    <div class="col-lg-5 card-body" id="moth">

                    </div>
                </div>

            </div>
        </div>

    </div>

<?php
$ajax_url = Url::to(['order/report-by-date']);
$jscre = <<<JS
  $(".hasDatepicker").datepicker({
    onSelect: function(dateText) {
      console.log('арёл арёл как слышна');
    }
  }).on("change", function(date) {
    getReportByDate(this.value);
  });

    function getReportByDate(date) {
         $.ajax({
                type: "POST",
                url: "$ajax_url",
                data: {date: date},
                success: function (response) {
                     $("#moth").html(response);
                },
                error: function (exception, status, error) {
                    if (exception.status == 404) {
                    }
                }
            });
    }
JS;

$this->registerJs($jscre);
