<?php use yii\widgets\ActiveForm;?>
<!-- content -->

  <div class="page-content__header">
    <div>
      <h2 class="page-content__header-heading">Kullanıcı Oluştur</h2>
    </div>
  </div>


<div class="main-container">     
        <?php echo \app\widgets\Alert::widget();?>
        <?php $form = ActiveForm::begin(['enableClientValidation' => true]);?>
            <?php echo $form->field($forms->user, 'first_name');?>
            
            <?php echo $form->field($forms->user, 'last_name');?>
            
            <?php echo $form->field($forms->user, 'is_admin')->dropDownList(\app\models\User::getAdminYesNo());?>
            
            <?php echo $form->field($forms->user, 'status')->dropDownList(\app\models\User::getStatusList());?>
            
            <?php echo $form->field($forms->email, 'email');?>
            
            <?php echo $form->field($forms->password, 'password')->passwordInput();?>
            
            <?php echo $form->field($forms->password, 'repeatPassword')->passwordInput();?>

            <div class="margin-top-10"></div>
            <div class="margin-top-10"></div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Kaydet</button>
                <button type="reset" class="btn btn-danger">Sıfırla</button>
            </div>
        <?php ActiveForm::end();?>
</div>
<!-- END content -->