<?php
function input_cx($name, $type, $label, $css_class = '', $div_wrapper = '', $id = '', $placeholder = '', $required = false, $disabled = false)
{
    $input = '';
    if (!empty($label)) {
        $input .= '<label for="' . $name . '">' . $label . '</label>';
    }
    $input .= '<input type="' . $type . '" name="' . $name . '" id="' . $id . '"';
    if (!empty($css_class)) {
        $input .= ' class="' . $css_class . '"';
    }
    if (!empty($placeholder)) {
        $input .= ' placeholder="' . $placeholder . '"';
    }
    if ($required) {
        $input .= ' required';
    }
    if ($disabled) {
        $input .= ' disabled';
    }
    $input .= '>';
    if (!empty($div_wrapper)) {
        $input = '<div class="' . $div_wrapper . '">' . $input . '</div>';
    }
    return $input;
}

function select_cx($name, $options, $label, $css_class = '', $div_wrapper = '', $id = '', $required = false, $disabled = false)
{
    $select = '';
    if (!empty($label)) {
        $select .= '<label for="' . $name . '">' . $label . '</label>';
    }
    $select .= '<select name="' . $name . '" id="' . $id . '"';
    if (!empty($css_class)) {
        $select .= ' class="' . $css_class . '"';
    }
    if ($required) {
        $select .= ' required';
    }
    if ($disabled) {
        $select .= ' disabled';
    }
    $select .= '>';
    foreach ($options as $value => $option) {
        $select .= '<option value="' . $value . '">' . $option . '</option>';
    }
    $select .= '</select>';
    if (!empty($div_wrapper)) {
        $select = '<div class="' . $div_wrapper . '">' . $select . '</div>';
    }
    return $select;
}

function textarea_cx($name, $label, $css_class = '', $div_wrapper = '', $id = '', $placeholder = '', $required = false, $disabled = false)
{
    $textarea = '';
    if (!empty($label)) {
        $textarea .= '<label for="' . $name . '">' . $label . '</label>';
    }
    $textarea .= '<textarea rows="5" name="' . $name . '" id="' . $id . '"';
    if (!empty($css_class)) {
        $textarea .= ' class="' . $css_class . '"';
    }
    if (!empty($placeholder)) {
        $textarea .= ' placeholder="' . $placeholder . '"';
    }
    if ($required) {
        $textarea .= ' required';
    }
    if ($disabled) {
        $textarea .= ' disabled';
    }
    $textarea .= '></textarea>';
    if (!empty($div_wrapper)) {
        $textarea = '<div class="' . $div_wrapper . '">' . $textarea . '</div>';
    }
    return $textarea;
}

function button_cx($name, $value, $css_class = '', $div_wrapper = '', $id = '', $disabled = false)
{
    $button = '';
    $button .= '<button name="' . $name . '" id="' . $id . '"';
    if (!empty($css_class)) {
        $button .= ' class="' . $css_class . '"';
    }
    if ($disabled) {
        $button .= ' disabled';
    }
    $button .= '>' . $value . '</button>';
    if (!empty($div_wrapper)) {
        $button = '<div class="' . $div_wrapper . '">' . $button . '</div>';
    }
    return $button;
}
