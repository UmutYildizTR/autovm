<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJs('
    $("#screate").click(function(e){
    
        self = $(this);
        
        vpsId = ' . $id . ';

        $.ajax({
            type:"POST",
            dataType:"JSON",
            url:"' . Yii::$app->urlManager->createUrl('/site/vps/create-shot') . '",
            data:{id:vpsId},

            beforeSend:function() {
            	new simpleAlert({title:"Oluşturuluyor", content:"Lütfen bekleyiniz..."});
            },
            
            success:function(data) {
            	if(data.ok) {
                    new simpleAlert({title:"Eylem Durumu", content:"Başarıyla tamamlandı"});
                } else {
                    new simpleAlert({title:"Eylem Durumu", content:"Bir hata oluştu, lütfen tekrar deneyiniz"});
                }
            }
        });
    });
    
    $("#sreverse").click(function(e){
    
        self = $(this);
        
        vpsId = ' . $id . ';

        $.ajax({
            type:"POST",
            dataType:"JSON",
            url:"' . Yii::$app->urlManager->createUrl('/site/vps/reverse-shot') . '",
            data:{id:vpsId},

            beforeSend:function() {
            	new simpleAlert({title:"Geri yükleniyor", content:"Lütfen bekleyiniz..."});
            },
            
            success:function(data) {
            	if(data.ok) {
                    new simpleAlert({title:"Eylem Durumu", content:"Başarıyla tamamlandı"});
                } else {
                    new simpleAlert({title:"Eylem Durumu", content:"Bir hata oluştu, lütfen tekrar deneyiniz"});
                }
            }
        });
    });
');

?>

<style type="text/css">
    .select-os-table {
        box-shadow: none !important;
        border: 0 !important;
    }

    .select-os-table td {
        border: 0 !important;
    }
</style>


<?php if($vps->getCanSnapshot()) {?>
<table class="table select-os-table">
    <tbody>
    <tr>
        <td width="100%" colspan="2">
            <p>Buradan yedekleme oluşturabilir yada geri yükleyebilirsiniz</p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button class="label btn-red btn teal waves-effect waves-light" id="screate" type="button">Oluştur</button>
            <button class="btn waves-effect waves-light amber" id="sreverse" type="button" style="margin-left:10px;">Geri yükle</button>
        </td>
    </tr>
    </tbody>
</table>
<?php } else {?>
<table class="table select-os-table">
    <tbody>
    <tr>
        <td width="100%" colspan="2">
            <p>Maalesef bu özelliği paketinizde kullanamıyorsunuz</p>
        </td>
    </tr>
    </tbody>
</table>
<?php }?>