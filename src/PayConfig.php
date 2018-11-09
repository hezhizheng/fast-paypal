<?php
/**
 * Created by PhpStorm.
 * User: DexterHo
 * Date: 2018/10/20/0020
 * Time: 下午 23:20
 * Email: dexter.ho.cn@gmail.com
 */

namespace DexterHo\FastPayPal;

/**
 * @property string $url
 * @property string $cmd
 * @property string $business
 * @property string $item_name
 * @property string $item_number
 * @property string $amount
 * @property string $currency_code
 * @property string $return
 * @property string $notify_url
 * @property string $cancel_return
 * @property string $invoice
 * @property string $charset
 * @property string $no_shipping
 * @property string $no_note
 * @property string $rm
 *
 * @property string $client_id
 * @property string $client_secret
 * @property string $refund_amount
 * @property string $refund_currency_code
 * @property string $model
 * @property string $txn_id
 *
 * Class PayConfig
 * @package DexterHo\FastPayPal
 */
class PayConfig
{

    private $config_param = [
        /**
         * 支付参数
         */
        'url'                  => 'https://www.sandbox.paypal.com/cgi-bin/webscr', // Live https://www.paypal.com/cgi-bin/webscr
        'cmd'                  => '_xclick', // 告诉paypal 是立即购买
        'business'             => '920625788-facilitator@qq.com', // buy 920625788-buyer@qq.com, pwd 12345678
        'item_name'            => 'test', // 商品名称
        'item_number'          => 'test', // 商品编号
        'amount'               => '10', // 支付金额
        'currency_code'        => 'USD', //
        'return'               => 'http://xblog.frp.hezhizheng.com/paypal/sync',  // 同步回调地址
        'notify_url'           => 'http://xblog.frp.hezhizheng.com/paypal/async', // 异步回调地址，一定得外网可以访问到的！！！
        'cancel_return'        => 'https://hezhizheng.com', // 在支付界面取消返回商家的地址
        'invoice'              => '111111111111', // 订单号
        'charset'              => 'utf-8', // 字符集
        'no_shipping'          => '1', // 不要求客户提供收货地址
        'no_note'              => '1', // 付款说明
        'rm'                   => '2', // 没找到说明该参数的文档


        /**
         * 退款参数
         */
        'client_id'            => 'AbabXad3rTbKm35ryVfGDsZNnbqKx0TN-8pmH5euMinUZwpTr_mfoJDuYOJFuCxS0ZNkMI7FZbcZrNWY',
        'client_secret'        => 'EMRNMggmXW9spnkQ5DwOlqZ8vmDhSa1wwxRf6P84fjdUpyHTivaX5tJDNOSHoZi39OxwipsvqLR_hqdr',
        'refund_amount'        => '10',
        'refund_currency_code' => 'USD',
        'model'                => '', // live 环境下请将modle 的值设置为 live
        'txn_id'               => '', // 交易ID，异步回调可以获取到
    ];

    public function __construct($config = [])
    {
        if (is_array($config)) {
            $this->config_param = array_merge($this->config_param, $config);
        }
    }

    public function __get($name)
    {
        if (isset($this->config_param[$name])) {
            return $this->config_param[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        if (isset($this->config_param[$name])) {
            $this->config_param[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return isset($this->config[$name]);
    }
}