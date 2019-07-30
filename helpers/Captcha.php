<?php

namespace helpers;

class Captcha{
    public static function generateCaptchaQuestion($prefix = '')
    {
        $answer = rand(1, 20);
        $marker = rand(0, 1) ? '+' : '-';
        $b = rand(1, $answer);
        $a = ($marker === '+') ? $answer - $b : $answer + $b;
        $question = $a . ' ' . $marker . ' ' . $b . ' = ';
        $_SESSION[$prefix . '_captcha'] = $answer;
        $_SESSION[$prefix . '_captcha_question'] = $question;
        return $question;
    }
    public static function isValidCaptcha($answer, $prefix = '')
    {
        $rightAnswer = isset($_SESSION[$prefix . '_captcha']) ? $_SESSION[$prefix . '_captcha'] : '';
        return $answer == $rightAnswer;
    }
    public static  function getCaptchaAnswer($prefix){
        if(!isset($_SESSION[$prefix . '_captcha'])){
            self::generateCaptchaQuestion($prefix);
        }
        return $_SESSION[$prefix . '_captcha'];
    }
    public static  function getCaptchaQuestion($prefix = ''){
        if(!isset($_SESSION[$prefix . '_captcha'])){
            self::generateCaptchaQuestion($prefix);
        }
        return $_SESSION[$prefix . '_captcha_question'];
    }
}