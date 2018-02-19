<?php

namespace app\controllers;

use Yii;

use app\models\Product;
use app\models\Category;
use app\models\ProductType;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
     $sql = "select product.id as id, product.name as name,description as description,image as image,category.name as category,product_type.name as type from product inner join category on product.category_id=category.id inner join product_type on product.type_id=product_type.id   ";

        $dataProvider = new ActiveDataProvider([
            'query' => Product::findBySql($sql)->asArray(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    //$products=Product::find($id)->joinWith('category')->all();
$sql = "select product.id as id, product.name as name,description as description,image as image,category.name as category,product_type.name as type from product inner join category on product.category_id=category.id inner join product_type on product.type_id=product_type.id   where product.id='$id'";
	$products=Product::findBySql($sql)->asArray()->one();
 //die (var_dump($products));
        return $this->render('view', [
            'model' => $products,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
	  $model->image = UploadedFile::getInstance($model, 'imageFile');
     if ($model->image)
     {
	 	  $model->image->saveAs('uploads/' . $model->image->baseName . '.' . $model->image->extension);
          
	 }
        if ($model->load(Yii::$app->request->post()) && $model->save()&& $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        //populating selectbox with categories from our model
         $categories=Category::find()->asArray()->all();
	
	//same with type of product
	     $types=ProductType::find()->asArray()->all();
	
            return $this->render('create', [
                'model' => $model,
                'categories'=>$categories,
          		'types'=>$types,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
      //populating selectbox with categories from our model
         $categories=Category::find()->asArray()->all();
	
	//same with type of product
	     $types=ProductType::find()->asArray()->all();
	
            return $this->render('update', [
                'model' => $model,
                'types'=>$types,
                'categories'=>$categories,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
