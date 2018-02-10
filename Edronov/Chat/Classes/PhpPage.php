<?php

namespace Edronov\Chat\Classes;

abstract class PhpPage
{
    protected function errorToFile($filename, $error_text)
    {
        $fd = fopen($filename, "w");    //открываем файл и получаем дескриптор
        fwrite($fd, $error_text);             //задаем текст файла (пишем с затиранием имеющегося)
        fclose($fd);                          //закрываем файл по дескриптору
    }

    public function render()                  //абстрактная функция - генерация html кода страницы
    {
        
    }
}