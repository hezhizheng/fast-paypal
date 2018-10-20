<?php
/**
 * Created by PhpStorm.
 * User: DexterHo
 * Date: 2018/10/20/0020
 * Time: 下午 23:20
 * Email: dexter.ho.cn@gmail.com
 */

namespace DexterHo\FastPayPal;

class PayConfig
{

    /**
     * 支付参数
     */
    public static $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // Live https://www.paypal.com/cgi-bin/webscr
    public static $cmd = '_xclick'; // 告诉paypal 是立即购买
    public static $business = '920625788-facilitator@qq.com'; // buy 920625788-buyer@qq.com; pwd 12345678
    public static $item_name = 'test'; // 商品名称
    public static $item_number = 'test'; // 商品编号
    public static $amount = '10'; // 支付金额
    public static $currency_code = 'USD'; //
    public static $return = 'http://xblog.frp.hezhizheng.com/paypal/sync';  // 同步回调地址
    public static $notify_url = 'http://notify.frp.hezhizheng.com/Notify.php'; // 异步回调地址，一定得外网可以访问到的！！！
    public static $cancel_return = 'https://hezhizheng.com'; // 在支付界面取消返回商家的地址
    public static $invoice = '111111111111'; // 订单号
    public static $charset = 'utf-8'; // 字符集
    public static $no_shipping = '1'; // 不要求客户提供收货地址
    public static $no_note = '1'; // 付款说明
    public static $rm = '2'; // 没找到说明该参数的文档


    /**
     * 退款参数
     */
    public static $client_id = 'AbabXad3rTbKm35ryVfGDsZNnbqKx0TN-8pmH5euMinUZwpTr_mfoJDuYOJFuCxS0ZNkMI7FZbcZrNWY';
    public static $client_secret = 'EMRNMggmXW9spnkQ5DwOlqZ8vmDhSa1wwxRf6P84fjdUpyHTivaX5tJDNOSHoZi39OxwipsvqLR_hqdr';
    public static $refund_amount = '10';
    public static $refund_currency_code = 'USD';
    public static $model = ''; // live 环境下请将modle 的值设置为 live
    public static $txn_id = ''; // 交易ID，异步回调可以获取到


}