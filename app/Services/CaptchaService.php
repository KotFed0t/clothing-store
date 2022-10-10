<?php

namespace App\Services;

class CaptchaService
{
    public function generateCaptcha()
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';

        $length = 6;

        $code = substr(str_shuffle($chars), 0, $length);

        session(['captcha' => $code]);


        // Генерируем изображение
        // Создаем новое изображение из файла
        $image = imagecreatefrompng(public_path() . '/captcha/bg.png');
        // Устанавливаем размер шрифта в пунктах
        $size = 36;
        // Создаём цвет, который будет использоваться в изображении
        $color = imagecolorallocate($image, 66, 182, 66);
        // Устанавливаем путь к шрифту
        $font = public_path() . '/captcha/oswald.ttf';
        // Задаём угол в градусах
        $angle = rand(-10, 10);
        // Устанавливаем координаты точки для первого символа текста
        $x = 56;
        $y = 64;
        // Наносим текст на изображение
        imagefttext($image, $size, $angle, $x, $y, $color, $font, $code);
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        return base64_encode($imageData);
    }

}
