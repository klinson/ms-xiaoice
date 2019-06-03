<?php
/**
 * Created by PhpStorm.
 * User: klinson <klinson@163.com>
 * Date: 19-5-15
 * Time: 下午5:35
 */

require __DIR__.'/../src/XiaoIce.php';

use MsXiaoIce\XiaoIce;

function getOriginImages($saveName)
{
    $path = __DIR__ . '/originImages/' . $saveName;
    return $path;
}

function saveProcessedImages($url, $saveName)
{
    $path = __DIR__ . '/processedImages/' . $saveName;
    file_put_contents($path, file_get_contents($url));
}

//$img = 'https://ss0.bdstatic.com/94oJfD_bAAcT8t7mm9GUKT-xh_/timg?image&quality=100&size=b4000_4000&sec=1557905228&di=eed5cbd0ccddca5040f6d210bc58627b&src=http://b-ssl.duitang.com/uploads/item/201512/12/20151212193107_ujGZV.jpeg';
// 颜值鉴定 / appraise appearance score
$img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1557915647241&di=4248f55beae825b50491aca53512bd2a&imgtype=0&src=http%3A%2F%2Fimg.tukexw.com%2Fimg%2F8e675ce41005d9fc.jpg';
$res = XiaoIce::getInstance()->appraiseScore($img);
var_dump($res);
exit;
saveProcessedImages($res['image_url'], 'img1-1.jpeg');
$path = getOriginImages('img1.jpg');
$res = XiaoIce::getInstance()->appraiseScore($path);
var_dump($res);
saveProcessedImages($res['image_url'], 'img1-2.jpeg');


// 拼颜值 / compete appearance
$img ='https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1557916418774&di=a79bd9eef9d1e64f890badc9fb49b5c9&imgtype=0&src=http%3A%2F%2Fp0.ifengimg.com%2Fpmop%2F2018%2F0705%2F27F3EA7EC281BDF657F322A1B8098D44638FD1C5_size127_w960_h1128.jpeg';
$res = XiaoIce::getInstance()->competeAppearance($img);
var_dump($res);
saveProcessedImages($res['image_url'], 'img2-1.jpeg');
$path = getOriginImages('img2.jpeg');
$res = XiaoIce::getInstance()->competeAppearance($path);
var_dump($res);
saveProcessedImages($res['image_url'], 'img2-2.jpeg');

// 测CP / speculate CP
$img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1557981569487&di=3558d3fb26cf89263549edd707ddd1c3&imgtype=0&src=http%3A%2F%2Fimg.tuohuangzu.com%2Fthz%2Fuserblog%2F0%2F13%2F2014030415073246634.png';
$res = XiaoIce::getInstance()->speculateCP($img);
var_dump($res);
saveProcessedImages($res['image_url'], 'img3-1.jpeg');
$path = getOriginImages('img3.jpeg');
$res = XiaoIce::getInstance()->speculateCP($path);
var_dump($res);
saveProcessedImages($res['image_url'], 'img3-2.jpeg');

// 谁请客 / who treat
$img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1557916418774&di=a79bd9eef9d1e64f890badc9fb49b5c9&imgtype=0&src=http%3A%2F%2Fp0.ifengimg.com%2Fpmop%2F2018%2F0705%2F27F3EA7EC281BDF657F322A1B8098D44638FD1C5_size127_w960_h1128.jpeg';
$res = XiaoIce::getInstance()->whoTreat($img);
var_dump($res);
saveProcessedImages($res['image_url'], 'img4-1.jpeg');
$path = getOriginImages('img4.jpeg');
$res = XiaoIce::getInstance()->whoTreat($path);
var_dump($res);
saveProcessedImages($res['image_url'], 'img4-2.jpeg');

// 测年龄 / speculate age
$img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1557915647241&di=4248f55beae825b50491aca53512bd2a&imgtype=0&src=http%3A%2F%2Fimg.tukexw.com%2Fimg%2F8e675ce41005d9fc.jpg';
$res = XiaoIce::getInstance()->speculateAge($img);
var_dump($res);
saveProcessedImages($res['image_url'], 'img5-1.jpeg');
$path = getOriginImages('img5.jpg');
$res = XiaoIce::getInstance()->speculateAge($path);
var_dump($res);
saveProcessedImages($res['image_url'], 'img5-2.jpeg');
