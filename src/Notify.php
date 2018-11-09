<?php
/**
 * Created by PhpStorm.
 * User: DexterHo
 * Date: 2018/10/20/0020
 * Time: 下午 23:20
 * Email: dexter.ho.cn@gmail.com
 */

namespace DexterHo\FastPayPal;

class Notify
{
    /**
     * 异步回调的验证
     * @return string
     */
    public static function checkPaymentStatus()
    {
        $verify = self::verifyNotify();
        if ($verify) {
            return 'success';
        } else {
            return 'fail';
        }
    }

    /**
     * 验证异步回调数据
     * @return bool
     */
    private static function verifyNotify()
    {
        $post = $_REQUEST;

        $url = (new PayConfig)->url;

        $data['cmd'] = '_notify-validate'; // 增加cmd参数，

        foreach ($post as $key => $item) $data[$key] = ($item);  // 如果数据验证失败，请在这里将参数urlencode

        $res = self::http($url, $data, 'POST');

        if (!empty($res)) {
            if (strcmp($res, "VERIFIED") == 0) {

                if ($post['payment_status'] == 'Completed') {
                    // 付款完成，这里修改订单状态
                    return true;
                }
            } elseif (strcmp($res, "INVALID") == 0) {
                //未通过认证，有可能是编码错误或非法的 POST 信息
                return false;
            }
        } else {
            //未通过认证，有可能是编码错误或非法的 POST 信息

            return false;

        }
        return false;
    }

    /**
     * 模拟提交参数，支持https提交 可用于各类api请求
     * @param string $url ： 提交的地址
     * @param array $data : POST数组
     * @param string $method : POST/GET，默认GET方式
     * @return mixed
     */
    private static function http($url, $data = [], $method = 'GET')
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            if ($data != '') {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
}