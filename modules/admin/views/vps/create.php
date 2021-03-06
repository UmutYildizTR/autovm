<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->registerJs("
    var servers = $('.servers select');
    var datastores = $('.datastores select');
    var ips = $('.ips select');

    $(\".loadfromserver\").click(function(){
        var serverId = $('#vps-server_id').val();
        var datastore = $('#vps-datastore_id').val();
        var ip = $('#vps-ip_id').val();

        if(!serverId || !ip || !datastore) {
               showDialog('Hata','IP ve disk seçimi yapınız');
        } else {
             $.ajax({
                 url:'". \yii\helpers\Url::to(['vps/informations'])."',
                 data:{
                 serverId:serverId,
                 ip:ip,
                 datastore:datastore,
                 },
                 type:'GET',
                 error:function(data)
                 {
                     new simpleAlert({title:\"Hata\", content:\"bilgilerin uygulanması sırasında hata oluştu\"});

                 },
                 success:function(data)
                 {
                     $(\"#applyInformations\").removeAttr('disabled');
                     if(data['status'] == 'success')
                     {
                         $(\"#ram\").val(data['ram']);
                         $(\"#cpu\").val(data['cpu']);
                         $(\"#cpuCores\").val(data['cpuCores']);
                     }
                     else
                     new simpleAlert({title:\"Hata\", content:\"bilgilerin uygulanması sırasında hata oluştu\"});
                 }
             });
        }
    });

    function applyDatastores(id) {
        $.ajax({
            url:'" . Yii::$app->urlManager->createUrl(['/admin/vps/datastores']) ."',
            type:'POST',
            dataType:'JSON',
            data:{id:id},
            success:function(data) {
                options = '';

                $.each(data, function(id, value) {
                    options += '<option value=\"' + id + '\">' + value + '</option>';
                });

                datastores.html(options);
            }
        });
    }

    function applyIps(id) {
        $.ajax({
            url:'" . Yii::$app->urlManager->createUrl(['/admin/vps/ips']) ."',
            type:'POST',
            dataType:'JSON',
            data:{id:id},
            success:function(data) {
                options = '';

                $.each(data, function(id, ip) {
                    options += '<option value=\"' + id + '\">' + ip + '</option>';
                });

                ips.html(options);
            }
        });
    }

    applyDatastores(servers.val());
    applyIps(servers.val());

    servers.change(function() {
        applyDatastores($(this).val());
        applyIps($(this).val());
    });
    $(document).ready(function() {
                $('.field-vps-vps_ram').hide();
                $('.field-vps-vps_cpu_core').hide();
                $('.field-vps-vps_cpu_mhz').hide();
                $('.field-vps-vps_hard').hide();
                $('.field-vps-vps_band_width').hide();
                $('.loadfromserver').hide();
        $(\"input[name='Vps[plan_type]']\").click(function() {

            if($(this).val()==1)
            {
            //console.log( $( this ).val());
                $('.field-vps-plan_id').show();
                $('.field-vps-vps_ram').hide();
                $('.loadfromserver').hide();
                $('.field-vps-vps_cpu_core').hide();
                $('.field-vps-vps_cpu_mhz').hide();
                $('.field-vps-vps_hard').hide();
                $('.field-vps-vps_band_width').hide();

            }
            else
            {
            //console.log( $( this ).val());
                $('.field-vps-plan_id').hide();
                $('.loadfromserver').show();
                $('.field-vps-vps_ram').show();
                $('.field-vps-vps_cpu_core').show();
                $('.field-vps-vps_cpu_mhz').show();
                $('.field-vps-vps_hard').show();
                $('.field-vps-vps_band_width').show();
            }

        });
    });

");

?>

  <div class="page-content__header">
    <div>
      <h2 class="page-content__header-heading"><i class="fab fa-linux"></i> Sanal Sunucu Oluştur</h2>
    </div>
  </div>

<!-- content -->
<div class="main-container">
        <?php echo \app\widgets\Alert::widget();?>
        <?php $form = ActiveForm::begin(['enableClientValidation' => true]);?>

            <div class="servers">
            <?php echo $form->field($model, 'server_id')->dropDownList(ArrayHelper::map($servers, 'id', 'name'))->label('Sunucu Seçimi');?>
            </div>

            <div class="datastores">
            <?php echo $form->field($model, 'datastore_id')->dropDownList(['' => 'Sunucu seçiniz'])->label('Disk Seçimi');?>
            </div>

            <div class="ips">
            <?php echo $form->field($model, 'ip_id')->dropDownList(['' => 'Sunucu seçiniz'])->label('IP Adresi');?>
            </div>

            <div class="disk">
            <?php echo $form->field($model, 'disk')->dropDownList(\app\models\Vps::getDisks());?>
            </div>


            <div class="hostname">
            <?php echo $form->field($model, 'hostname')->label('Hostname');?>
            </div>


<?php $list = range(1,30); $list = array_combine($list, $list);?>
  	    <?php echo $form->field($model, 'reset_at')->dropDownList($list)->label('Trafik sıfırlanma periyodu');?>

            <?= $form->field($model, 'plan_type', ['template' => '<label class="gender-head">{label}</label><label class="form-inline">{input}</label>'])->radioList([VpsPlansTypeDefault => 'Hazır Paketler', VpsPlansTypeCustom => 'Özelleştir'], ['separator' => '', 'tabindex' => 3]); ?>
            <?php echo $form->field($model, 'plan_id')->dropDownList(ArrayHelper::map($plans, 'id', 'name'))->label('Plan');?>
            <?php echo $form->field($model, 'vps_ram')->label('RAM Miktarı (MB)');?>
            <?php echo $form->field($model, 'vps_cpu_mhz')->label('CPU Hızı (MHZ)');?>
            <?php echo $form->field($model, 'vps_cpu_core')->label('CPU Çekirdeği');?>
            <?php echo $form->field($model, 'vps_hard')->label('Disk Alanı (GB)');?>
            <?php echo $form->field($model, 'vps_band_width')->label('Trafik (GB)');?>


            <?php echo $form->field($model, 'extra_bw')->label('Ekstra Trafik (GB)');?>
            <?php echo $form->field($model, 'snapshot')->dropDownList(\app\models\Vps::getSnapshotList());?>
            <?php echo $form->field($model, 'status')->label('Access')->dropDownList(\app\models\Vps::getStatusList());?>
            <?php echo $form->field($model, 'view')->checkBox(['value' => 1]);?>

            <div class="margin-top-10"></div>
            <div class="margin-top-10"></div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Kaydet</button>
                <button type="reset" class="btn btn-danger">Sıfırla</button>
            </div>
        <?php ActiveForm::end();?>
</div>
<!-- END content -->
