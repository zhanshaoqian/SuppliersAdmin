<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Supplier;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'/*, 'index'*/],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $supplier = new Supplier();
        $provider = $supplier->search(YII::$app->request->get());

        return $this->render('index', [
            'model' => $supplier,
            'provider' => $provider,
        ]);
    }

    public function actionSupplier()
    {
        $supplier = new Supplier();
        $ids = Yii::$app->request->get('ids');
        $supplier->ids = $ids;
        return $this->render('supplier', [
            'model' => $supplier
        ]);
    }

    /**
     * Export action
     */
    public function actionExport()
    {
        $postData = Yii::$app->request->post();
        $arrId = empty($postData['Supplier']['ids']) ? [] : explode(',', $postData['Supplier']['ids']);
        $title = 'ID';
        if (!empty($postData['name'])) {
            $title .= ',Name';
        }
        if (!empty($postData['code'])) {
            $title .= ',Code';
        }
        if (!empty($postData['t_status'])) {
            $title .= ',Status';
        }
        $title .= "\n";
        $fileName = 'Suppliers' . date('YmdHi') . '.csv';
        $dataArr = (new Supplier())::find()->andFilterWhere(['in', 'id', $arrId])->asArray()->all();
        $writeStr = '';
        if (!empty($dataArr)) {
            foreach ($dataArr as $key => $value) {
                $writeStr .= $value['id'];
                if (!empty($postData['name'])) {
                    $writeStr .= ',' . $value['name'];
                }
                if (!empty($postData['code'])) {
                    $writeStr .= ',' . $value['code'];
                }
                if (!empty($postData['t_status'])) {
                    $writeStr .= ',' . $value['t_status'];
                }
                $writeStr .= "\n";
            }
        }
        header('Content-Disposition:attachment;filename=' . $fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        ob_start();
        $writeStr = $title . $writeStr;
        $writeStr = iconv('utf-8', 'GBK//ignore', $writeStr);
        ob_end_clean();
        echo $writeStr;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/site/login');
    }

}
