<?php
/**
 * 建立跳转请求表单
 * @param string $url 数据提交跳转到的URL
 * @param array $data 请求参数数组
 * @param string $method 提交方式：post或get 默认post
 * @return string 提交表单的HTML文本
 */
function buildRequestForm($url, $data, $method = 'post')
{
    $sHtml = "<form id='requestForm' name='requestForm' action='".$url."' method='".$method."'>";
    while (list ($key, $val) = each ($data))
    {
        $sHtml.= "<input type='hidden' name='".$key."' value='".$val."' />";
    }
    $sHtml = $sHtml."<input type='submit' value='确定' style='display:none;'></form>";
    $sHtml = $sHtml."<script>document.forms['requestForm'].submit();</script>";
    return $sHtml;
}