<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<h2>Product type
   <br>
     <select name="Product[type_id]">
   	<?php
   	foreach($types as $type)
   	{
		
	
   	?>
   <option value="<?php echo $type['id'];?>"><?php echo $type['name'];?></option>
   <?php
}
?>
   </select>
   <h2>Category</h2>
   <select name="Product[category_id]">
   	<?php
   	foreach($categories as $category)
   	{
		
	
   	?>
   <option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
   <?php
}
?>
   </select>
    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'imageFile')->fileinput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
