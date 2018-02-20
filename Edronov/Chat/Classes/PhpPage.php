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

    protected function loadHtmlTemplate($template_name, $var_array, $value_array)
    {
        $template_code = file_get_contents($template_name);
        return str_replace($var_array, $value_array,$template_code);
    }

    protected function loadSqlRequest($request_name)
    {
        return file_get_contents($request_name);
    }

    public function render()                  //абстрактная функция - генерация html кода страницы
    {
        
    }
}