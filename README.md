yii2-alipay
===========
Alipay extension for YII2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist silentlun/yii2-alipay "*"
```

or add

```
"silentlun/yii2-alipay": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

#### Controller
```php
namespace app\controllers;

use yii\web\Controller;
use silentlun\alipay\AliPay;

class SiteController extends Controller
{
    public $alipayConfig = [
        'app_id' => '支付宝应用ID',
        'merchant_private_key' => '支付宝私钥',
        'alipay_public_key' => '支付宝公钥',
        ];
    public function actionPay()
    {
        $order = []; // 订单信息
        $payment = new AliPay($this->alipayConfig);
        $result = $payment->createWebPay($order);
        return $this->renderPartial('alipay', [
            'result' => $result,
        ]);
    }
}
```