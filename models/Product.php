<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $category_id
 * @property string $name
 * @property string $description
 * @property string $image
 *
 * @property ProductType $type
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public $imageFile;
    public function rules()
    {
        return [
            [['type_id', 'category_id', 'name', 'description'], 'required'],
            [['type_id', 'category_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
             //  [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,jpeg,ico'],
        
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }
	
        
    
    /**
     * @inheritdoc
     */
  
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

}
