# 微软小冰接口 / ms-xiaoice

## 官方地址

[微软小冰](https://kan.msxiaobing.com/)

## 接口清单 / API LIST

#### 颜值鉴定 / appraise appearance score
调用方式
```php
// $img 可以是路径、url、图片base64内容
$res = XiaoIce::getInstance()->appraiseScore($img_path_or_url);
$res = XiaoIce::getInstance()->appraiseScore($img_base64, true);
var_dump($res);
```
输出结果
```shell
array(3) {
  ["result"]=>
  float(5.2)
  ["text"]=>
  string(263) "深度神经网络输出的结果显示，全球各类人群中美国90后男性最喜欢这种容貌，给出的分数是5.2。不过这张脸在法国小姐姐和法国小哥哥眼中，颜值平平。讲道理，照片上的人蛮亲切的，特别是眼睛。"
  ["image_url"]=>
  string(170) "https://mediaplatform.msxiaobing.com/image/fetchimage?key=UQAfAC8ABAAAAFcAFgAGABYASgBFADMAQQA4ADQARQA2ADcAOQBEAEUAMAAyADMANQBDADQAMQAwADAANQA4AEYARgBCAEUANwA5ADMANAA4ADMA"
}
```

#### 拼颜值 / compete appearance

调用方式
```php
// $img 可以是路径、url、图片base64内容
$res = XiaoIce::getInstance()->competeAppearance($img_path_or_url);
$res = XiaoIce::getInstance()->competeAppearance($img_base64, true);
var_dump($res);
```
输出结果
```shell
array(3) {
  ["result"]=>
  string(3) "9.1"
  ["text"]=>
  string(72) "菇凉颜值9.1，天上掉下个大美人，似一朵轻云刚出岫。"
  ["image_url"]=>
  string(172) "http://mediaplatform.trafficmanager.cn/image/fetchimage?key=UQAfAC8ABAAAAFcAFgAGABYASgBEAEYARQAxAEQAMgA5AEUAQgAwAEUAMAA5AEUAMAA3ADMAQwAzAEYAOQA5ADcAQQA2ADMAOABBADEAMwAzADMA"
}
```

#### 测CP / speculate CP

调用方式
```php
// $img 可以是路径、url、图片base64内容
$res = XiaoIce::getInstance()->speculateCP($img_path_or_url);
$res = XiaoIce::getInstance()->speculateCP($img_base64, true);
var_dump($res);
```
输出结果
```shell
array(3) {
  ["result"]=>
  int(0)
  ["text"]=>
  string(77) "鲜花往往喜欢插在XX上(XX不好闻)，快让美女大喊：我喜欢XX"
  ["image_url"]=>
  string(172) "http://mediaplatform.trafficmanager.cn/image/fetchimage?key=UQAfAC8ABAAAAFcAFgAGABYASgBCAEEANQBDAEQANQA3ADYARAA3ADQARABDADQAQQBFADcAOABCADgARgAzAEQANQAzAEIAQgBBADMANQBFAEQA"
}

```

#### 谁请客 / who treat

调用方式
```php
// $img 可以是路径、url、图片base64内容
$res = XiaoIce::getInstance()->whoTreat($img_path_or_url);
$res = XiaoIce::getInstance()->whoTreat($img_base64, true);
var_dump($res);
```
输出结果
```shell
array(3) {
  ["result"]=>
  int(0)
  ["text"]=>
  string(61) "这被人簇拥的阵势，明显是boss！还不赶紧请客"
  ["image_url"]=>
  string(172) "http://mediaplatform.trafficmanager.cn/image/fetchimage?key=UQAfAC8ABAAAAFcAFgAGABYASgBGAEYAQwBGADIANgAwADIANwA4ADkAMgAzADQAQQA4ADgANQAwADgAOQA2ADYAMAAyAEMAMwA5ADYAOQAyAEYA"
}

```

#### 测年龄 / speculate age

调用方式
```php
// $img 可以是路径、url、图片base64内容
$res = XiaoIce::getInstance()->speculateAge($img_path_or_url);
$res = XiaoIce::getInstance()->speculateAge($img_base64, true);
var_dump($res);
```
输出结果
```shell
array(3) {
  ["result"]=>
  int(0)
  ["text"]=>
  NULL
  ["image_url"]=>
  string(172) "http://mediaplatform.trafficmanager.cn/image/fetchimage?key=UQAfAC8ABAAAAFcAFgAGABYASgAyADcAQwAzADQARAA5AEEANwAyADEANwA4ADUAOQBBADQANwBDAEYARABEAEUANgBCADQAMAAxAEUAQgA5ADEA"
}
```


