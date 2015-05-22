<?php

/* 将UTF8编码中大于4字节的字符，全部转换成<utf8>...</utf8>形式，中间是base64编码，也可以实现为bin2hex
   */

class Tool_Utf8
{
    public static function encodeParams(&$arr)
    {
        if (empty($arr)) return;

        if (is_string($arr))
        {
            $arr = self::encode($arr);
            return;
        }

        foreach ($arr as $k => &$v)
        {
            if (is_string($v))
            {
                if (!empty($v))
                {
                    $v = self::encode($v);
                }
            }
            else if (is_array($v))
            {
                self::encodeParams($v);
            }
        }
    }

    public static function decodeResult(&$arr)
    {
        if (empty($arr)) return;

        if (is_string($arr))
        {
            $arr = self::decode($arr);
            return;
        }

        foreach ($arr as $k => &$v)
        {
            if (is_string($v))
            {
                if (!empty($v))
                {
                    $v = self::decode($v);
                }
            }
            else if (is_array($v))
            {
                self::decodeResult($v);
            }
        }
    }

    public static function encode($str)
    {
        $pattern = '/([\x{10000}-\x{7fffffff}]+)/u';
        return preg_replace_callback($pattern,
                'Tool_Utf8::_encodeMatch',
                $str);
    }

    public static function decode($str)
    {
        $pattern = '/<utf8>(.*?)<\/utf8>/';
        return preg_replace_callback($pattern,
                'Tool_Utf8::_decodeMatch',
                $str);
    }

    private static function _encodeMatch($matches)
    {
        if (!empty($matches) && !empty($matches[1])) return '<utf8>' . base64_encode($matches[1]) . '</utf8>'; else return '';
    }

    private static function _decodeMatch($matches)
    {
        if (!empty($matches) && !empty($matches[1])) return base64_decode($matches[1]); else return '';
    }

    public static function test()
    {
        $str = "😱我们😃😁微博😰😃😂";
        $str = "😱我们😃😁微博😰😃😂☔️abc";    // the "Umbrella" is at BMP, so it only need 3 bytes in UTF8, hahaha~  @see http://code.iamcal.com/php/emoji/
        echo $str . "\n";

        $a = self::encode($str);
        echo $a . "\n";

        echo self::decode($a) . "\n";

        $arr = array(
                'a' => $str,
                'b' => array(
                    $str,
                    'b1'    => $str . $str,
                    ),
                'c' => 'xxxxaaa祁冰bingo',
                );
        self::encodeParams($arr);
        print_r($arr);
        self::decodeResult($arr);
        print_r($arr);

        self::encodeParams($str);
        print_r($str); echo "\n";
        self::decodeResult($str);
        print_r($str); echo "\n";
    }
}
Tool_Utf8::test();
