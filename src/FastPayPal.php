<?php
/**
 * Created by PhpStorm.
 * User: DexterHo
 * Date: 2018/10/20/0020
 * Time: 下午 23:20
 * Email: dexter.ho.cn@gmail.com
 */

namespace DexterHo\FastPayPal;

require 'PayConfig.php';

class FastPayPal
{
    public static function redirectPay(PayConfig $payConfig)
    {
        $html = <<<heredoc
        
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Paypal订单支付</title>
            </head>
                <body>
                    <form action="{$payConfig::$url}" method="POST"  name="form_starPay"> <!-- // Live https://www.paypal.com/cgi-bin/webscr -->
                        <input type='hidden' name='cmd' value="{$payConfig::$cmd}">  <!-- //告诉paypal该表单是立即购买 -->
                        <input type='hidden' name='business' value='{$payConfig::$business}'> <!-- //卖家帐号 也就是收钱的帐号 -->
                        <input type='hidden' name='item_name' value='{$payConfig::$item_name}'> <!-- //商品名称 item_number -->
                        <input type='hidden' name='item_number' value='{$payConfig::$item_number}'> <!-- //物品号 item_number -->
                        <input type='hidden' name='amount' value='{$payConfig::$amount}'> <!-- .// 订单金额 -->
                        <input type='hidden' name='currency_code' value='{$payConfig::$currency_code}'> <!-- .// 货币 -->
                        <input type='hidden' name='return' value='{$payConfig::$return}'> <!-- .// 支付成功后网页跳转地址 -->
                        <input type='hidden' name='notify_url' value='{$payConfig::$notify_url}'> <!-- .//支付成功后paypal后台发送订单通知地址 -->
                        <input type='hidden' name='cancel_return' value='{$payConfig::$cancel_return}'> <!-- .//用户取消交易返回地址 -->
                        <input type='hidden' name='invoice' value='{$payConfig::$invoice}'> <!-- .//自定义订单号 -->
                        <input type='hidden' name='charset' value='{$payConfig::$charset}'> <!-- .// 字符集 -->
                        <input type='hidden' name='no_shipping' value='{$payConfig::$no_shipping}'> <!-- .// 不要求客户提供收货地址 -->
                        <input type='hidden' name='no_note' value='{$payConfig::$no_note}'> <!-- .// 付款说明 -->
                        <input type='hidden' name='rm' value='{$payConfig::$rm}'> <!-- 不知道是什么 -->
                        <input type="image" name="submit"   src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" />
                    </form>
                    正在跳转Paypal支付，请稍等。。。
                </body>
                <script>
                    function sub(){
                        document.form_starPay.submit();
                    }
                    onload(sub());
                </script>
        </html>
heredoc;
        return $html;
    }
}