<?php
require_once('composants.php');
if (!class_exists('FormGenerator')) {
    class FormGenerator
    {
        private $form_elements = array();
        private $method;
        private $action;
        private $enctype;
        private $css_class;
    
        public function __construct($fields, $method, $action, $enctype = '', $css_class = '')
        {
            $this->method = $method;
            $this->action = $action;
            $this->enctype = $enctype;
            $this->css_class = $css_class;
    
            foreach ($fields as $field) {
                $type = isset($field['type']) ? $field['type'] : 'text';
                $name = $field['name'];
                $id = isset($field['id']) ? $field['id'] : $name;
                $label = isset($field['label']) ? $field['label'] : '';
                $css_class = isset($field['css_class']) ? $field['css_class'] : '';
                $div_wrapper = isset($field['div_wrapper']) ? $field['div_wrapper'] : '';
                $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
                $required = isset($field['required']) ? $field['required'] : false;
                $disabled = isset($field['disabled']) ? $field['disabled'] : false;

                switch ($field['type']) {
                    case 'text':
                    case 'email':
                    case 'number':
                    case 'password':
                    case 'color':
                    case 'date':
                    case 'datetime':
                    case 'month':
                    case 'hour':
                    case 'value':
                        $this->form_elements[] = input_cx($name, $type, $label, $css_class, $div_wrapper, $id, $placeholder, $required, $disabled);
                        break;
                    case 'select':
                        $options = isset($field['options']) ? $field['options'] : array();
                        $this->form_elements[] = select_cx($name, $options, $label, $css_class, $div_wrapper, $id, $required, $disabled);
                        break;
                    case 'textarea':
                        $this->form_elements[] = textarea_cx($name, $label, $css_class, $div_wrapper, $id, $placeholder, $required, $disabled);
                        break;
                    case 'button':
                        $value = isset($field['value']) ? $field['value'] : 'Envoyer';
                        $this->form_elements[] = button_cx($name, $value, $css_class, $div_wrapper, $id, $disabled);
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
    
        
    
        public function getForm()
        {
            $form = '<form method="' . $this->method . '" action="' . $this->action . '"';
            if (!empty($this->enctype)) {
                $form .= ' enctype="' . $this->enctype . '"';
            }
            if (!empty($this->css_class)) {
                $form .= ' class="' . $this->css_class . '"';
            }
            $form .= '>';
            foreach ($this->form_elements as $element) {
                $form .= $element;
            }
            $form .= '</form>';
            return $form;
        }
    }
}
