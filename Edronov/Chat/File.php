<?php

namespace Edronov\Chat;

class File
{
    protected $descriptor = null;
    protected $name = null;


    public function __construct($name)
    {
        $this->name = $name;
    }




    public function __destruct()
    {
        fclose($this->descriptor);
    }




    public function setText($text)
    {
        $this->descriptor = fopen($this->name, "w");
        fwrite($this->descriptor, $text);
        fclose($this->descriptor);        
    }
}
