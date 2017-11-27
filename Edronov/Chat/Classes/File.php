<?php

namespace Edronov\Chat\Classes;      				 

class File                           				 //класс взаимодействия с выбранным файлом
{
    protected $descriptor = null;                    // дескриптор файла
    protected $name = null;                          // имя файла


    public function __construct($name)               
    {
        if ($this->singletonExists()) {                 // проверяем, существует ли уже синглтон?            
            $file_manager = $_SESSION['file_manager'];  //существует, берем его из глобальной переменной сессии
            $file_manager->change($name);               // применяем на него выбранное имя файла
            return $file_manager;
        } else {                                     //синглтон еще не существует, создаем его
            $this->name = $name;                     //применяем выбранное имя
            $_SESSION['file_manager'] = $this;       //записываем синглтон в глобальную переменную сессии
        }
    }

    public function __destruct()                     
    {
        fclose($this->descriptor);                   
        $this->descriptor = null;                    
    }

    public function setText($text)                   //задать содержимое файла - текст
    {
        $this->descriptor = fopen($this->name, "w"); //открываем файл и получаем дескриптор
        fwrite($this->descriptor, $text);            //задаем текст файла (пишем с затиранием имеющегося)
        fclose($this->descriptor);                   
        $this->descriptor = null;                    
    }

    public function change($name)                    //сменить выбранный файл
    {
        $this->name = $name;                         
    }

    protected function singletonExists()             //проверка наличия синглтона в сессии
    {
        return isset($_SESSION['file_manager']);     
    }
}
