<?php
/**
 * Created by PhpStorm.
 * User: evgeniy
 * Date: 16.02.18
 * Time: 21:00
 */

namespace Edronov\Chat\build;

class Build
{
    protected $classes_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/Classes/";
    protected $output_path = "/home/evgeniy/PhpstormProjects/MyChat/Edronov/Chat/build/output/";

    public function __construct()
    {

    }

    protected function wrapWithHeredoc($text)
    {
        return "<<<HEREDOC\n" . $text . "\nHEREDOC;\n";
    }

    public function buildClass($class_name, $was, $become)
    {
        $class_code = file_get_contents($this->classes_path . $class_name);
        foreach ($become as &$substitution_file) {
            $substitution_file = file_get_contents($substitution_file);
        }
        foreach ($become as &$substitution) {
            $substitution = $this->wrapWithHeredoc($substitution);
        }
        $class_code = str_replace($was, $become, $class_code);
        file_put_contents($this->output_path . $class_name, $class_code);
    }
}