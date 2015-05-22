<?php
/**
 * 字符串工具类
 * @since      2014-04-29
 */

class Util_String
{
    /**
     * 计算字符串长度，一个汉字计数为1，非汉字则为0.5
     * @param string $str 需要计算长度的字符串
     * @param string $enc 字符串编码nt
     * @return int 字符串长度
     */
    public static function chineseLength($str, $enc = 'UTF-8')
    {   
        return mb_strwidth($str, $enc) / 2;
    }   

    /** 
     * 计算字符串长度，一个英文字符计数为1，汉字计2 
     * @param string $str 需要计算长度的字符串
     * @param string $enc 字符串编码nt
     * @return int 字符串长度
     */  
    public static function englishLength($str, $enc = 'UTF-8')
    {   
        return mb_strwidth($str, $enc);
    }

    /** 
     * 中英文混杂字符串截取,截取后英文长度总长不超过$length
     *
     * @param string $string
     * 原字符串
     * @param interger $length
     * 截取的字符数
     * @param string $etc
     * 省略字符
     * @param string $charset
     * 原字符串的编码
     *
     * @return string
     */
    public static function substr($string, $length = 80, $etc = '...', $charset = 'UTF-8')
    {
        if (mb_strwidth($string, $charset) < $length) {
            return $string;
        }
        return mb_strimwidth($string, 0, $length, $etc, $charset);
    }

    /** 
     * 生成随机字符串
     * @param int $lenthg 长度
     * @param int $range 产生随机字符串的范围类型，
     *                      第一位置1表示从数字中产生
     *                      第二位置1表示从小写字母中产生
     *                      第三位置1表示从大写字母中产生
     *                      第四位置1表示从符号字符中产生
     * @return string 随机字符串
     */  
    public static function random($length, $rangeType)
    {   
        $strDigit = '0123456789';
        $strLower = 'abcdefghijklmnopqrstuvwxyz';
        $strUpper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $strSymbol = '~!@#$%^&*()_+-=[]{}\|;:\'",.<>/?';

        $strFrom = '';
        $strResult = '';
        $rangeType = intval($rangeType);
        if ($rangeType & 0x1) $strFrom .= $strDigit;
        if ($rangeType & 0x2) $strFrom .= $strLower;
        if ($rangeType & 0x4) $strFrom .= $strUpper;
        if ($rangeType & 0x8) $strFrom .= $strSymbol;

        if (empty($strFrom)) return false;
        $fromLen = strlen($strFrom);
        for($i = 0; $i < $length; $i++)
        {   
            $index = mt_rand(0, $fromLen - 1); 
            $strResult .= $strFrom[$index];
        }   
        return $strResult;
    }   
}