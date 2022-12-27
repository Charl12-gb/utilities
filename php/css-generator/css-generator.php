<?php

if (!class_exists('CSSGenerator')) {
    class CSSGenerator
    {
        private $css = '';
    
        public function addRule($selector, $declarations)
        {
            $this->css .= $selector . ' {' . "\n";
            foreach ($declarations as $property => $value) {
                $this->css .= "\t" . $property . ': ' . $value . ';' . "\n";
            }
            $this->css .= '}' . "\n";
        }
    
        public function getCSS()
        {
            return $this->css;
        }
    }
}