<?php
namespace MsXiaoIce;

use Exception;
use BadMethodCallException;

/**
 * 微软小冰颜值测试
 * Class XiaoIce
 * @method boolean|array appraiseScore($image, $isBase64 = false) 颜值鉴定
 * @method boolean|array competeAppearance($image, $isBase64 = false) 拼颜值
 * @method boolean|array speculateCP($image, $isBase64 = false) 测CP
 * @method boolean|array whoTreat($image, $isBase64 = false) 谁请客
 * @method boolean|array appraiseDress($image, $isBase64 = false) 时尚穿衣秘籍
 * @method boolean|array speculateAge($image, $isBase64 = false) 测年龄
 * @param string $image 文件url或者本地地址或者文件base64编码
 * @package MsXiaoIce
 * @author klinson <klinson@163.com>
 * @link https://www.klinson.com
 */
class XiaoIce
{
    // 访问host
    protected $host = 'kan.msxiaobing.com';
    // 启动https？
    protected $isHttps = true;

    protected $urls = [
        'appraiseScore' => [
            'page' => '/ImageGame/Portal?task=beauty',
            'api' => '/Api/ImageAnalyze/Process?service=beauty',
        ],
        'competeAppearance' => [
            'page' => '/ImageGame/Portal?task=yanzhi',
            'api' => '/Api/ImageAnalyze/Process?service=yanzhi',
        ],
        'speculateCP' => [
            'page' => '/ImageGame/Portal?task=guanxi',
            'api' => '/Api/ImageAnalyze/Process?service=guanxi',
        ],
        'whoTreat' => [
            'page' => '/ImageGame/Portal?task=qingke',
            'api' => '/Api/ImageAnalyze/Process?service=qingke',
        ],
        'speculateAge' => [
            'page' => '/ImageGame/Portal?task=howold',
            'api' => '/Api/ImageAnalyze/Process?service=howold',
        ],
    ];
    // 上传图片接口
    protected $fileApi = '/Api/Image/UploadBase64';

    // 保存会话的文件
    protected $cookieFile = '';

    protected static $instance;
    protected function __construct()
    {
        // 建立一个零时文件
        $this->cookieFile = tempnam('./', 'cookie');
    }
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    public function __destruct()
    {
        file_exists($this->cookieFile) && unlink($this->cookieFile);
    }

    /**
     * 验证服务主页是否正常可访问
     * @throws Exception
     * @author klinson <klinson@163.com>
     */
    private function check($api)
    {
        $url = $this->getUrl($api, 0);
        $ret = $this->curl($url);
        if (empty($ret)) {
            return $this->setError('error to call page', 1);
        }
    }

    /**
     * 接口统一调用
     * @param string $api 请求接口
     * @param string $image 本地或网络的文件路径或者base64编码内容
     * @param boolean $isBase64 传入的$image是否是base64编码内容
     * @throws Exception
     * @return boolean|array 测试是否成功
     */
    protected function handle($api, $image, $isBase64 = false)
    {
//        $api = __FUNCTION__;
        $this->check($api);

        $ret = $this->uploadImage($image, $isBase64);
        if (!isset($ret->Host) || !isset($ret->Url)) {
            return $this->setError('error to upload image', 2);
        }

        $data = [
            'MsgId' => str_pad(time(), 13, '0'),
            'CreateTime' => time(),
            'Content[imageUrl]' => $ret->Host . $ret->Url,
        ];

        $url = $this->getUrl($api, 1);
        $rsp = $this->curl($url, $data, 'POST', $this->getCurlHeaders($api));
        if (empty($rsp)) {
            return $this->setError('error to handle', 3);
        }

        $response = json_decode($rsp, true);

        if (!isset($response['content'])) {
            return $this->setError('callback content unknown', 4);
        }

        if (isset($response['content']['metadata']['score']) && $response['content']['metadata']['score'] > 0) {
            $score = $response['content']['metadata']['score'];
        } else {
            preg_match('/[-+]?([0-9]*\.[0-9]+|[0-9]+)/', $response['content']['text'], $matches);
            if (!empty($matches) && isset($matches[0])) {
                $score = $matches[0];
            } else {
                $score = 0;
            }
        }

        return [
            'result' => $score,
            'text' => $response['content']['text'],
            'image_url' => $response['content']['imageUrl'],
        ];
    }

    public function __call($name, $arguments)
    {
        if (key_exists($name, $this->urls)) {
            return $this->handle($name, $arguments[0], ($arguments[1] ?? false));
        } else {
            throw new BadMethodCallException('Call to undefined method ' . __CLASS__ . '::' . $name . '()');
        }
    }

    /**
     * 设置错误信息
     * @param string $message
     * @author klinson <klinson@163.com>
     * @throws Exception
     */
    private function setError($message = '', $code = 0)
    {
        $this->error = $message;
        throw new \Exception($message, $code);
    }

    /**
     * 上传图片
     * @param  string $file 本地或网络地址
     * @param boolean $isBase64 传入的$image是否是base64编码内容
     * @return boolean|string|array       响应数据
     */
    private function uploadImage($file, $isBase64 = false)
    {
        if ($isBase64) {
            $img_data = $file;
        } else {
            $img_data = $this->getBase64DataByFilePath($file);
        }

        $url = ($this->isHttps ? 'https://' : 'http://') . $this->host . $this->fileApi;
        $rsp = $this->curl($url, $img_data, 'post', [], true);
        if (empty($rsp)) {
            return false;
        }
        return json_decode($rsp);
    }

    /**
     * 统一curl头
     * @author klinson <klinson@163.com>
     * @return array
     */
    private function getCurlHeaders($api)
    {
        $headers = [
            'Referer' => $this->getUrl($api, 0),
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
            'Connection' => 'close',
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Host' => $this->host,
            'Origin' => ($this->isHttps ? 'https://' : 'http://') . $this->host
        ];

        return $headers;
    }

    /**
     * 发出请求
     * @param  string           $url     URL
     * @param  array|string     $request 请求参数
     * @param  string           $method  请求方法
     * @return string
     */
    private function curl($url, $request = null, $method = 'GET', $headers = [], $is_binary = false)
    {
        $ch = curl_init();
        $method = strtoupper($method);
        if ($method == 'GET') {
            if (is_array($request)) {
                $url = $url . '?' . http_build_query($request);
            }
        }
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($is_binary) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            } else {
                if (is_array($request)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
                }
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->paramHeader($headers));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // cookie文件
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    private function getUrl($apiName, $isApi = 1)
    {
        return ($this->isHttps ? 'https://' : 'http://') . $this->host . $this->urls[$apiName][($isApi ? 'api' : 'page')];
    }

    /**
     * 解析header
     * @param array $headers
     * @return array 解析后的头部数组
     */
    private function paramHeader($headers)
    {
        $arr = [];
        foreach ($headers as $key => $value) {
            $arr[] = $key . ':' . $value;
        }
        return $arr;
    }

    /**
     * 获取图片的Base64编码的数据
     * @param  string $file_path 本地或网络地址
     * @return string
     */
    private function getBase64DataByFilePath($file_path)
    {
        return base64_encode(file_get_contents($file_path));
    }
}



