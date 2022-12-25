<?php
if (!class_exists('Utilities')) {

    class Utilities
    {

		/**
		 * Formulaire of admin_form
		 * @param mixed $data
		 * @return bool|string
		 */
        public static function admin_form($data)
        {
            ob_start();
            foreach ($data as $champ) {
                if (!isset($champ['type']))
                    continue;
                if (!isset($champ['id']))
                    $champ['id'] = '';
                if (!isset($champ['name']))
                    $champ['name'] = $champ['id'];
                if (!isset($champ['class']))
                    $champ['class'] = '';
                if (!isset($champ['css']))
                    $champ['css'] = '';
                if (!isset($champ['default']))
                    $champ['default'] = '';
                if (!isset($champ['title']))
                    $champ['title'] = isset($champ['name']) ? $champ['name'] : '';
                if (!isset($champ['description']))
                    $champ['description'] = '';
                if (!isset($champ['options']))
                    $champ['options'] = array();
                if (!isset($champ['placeholder']))
                    $champ['placeholder'] = '';
                if (!isset($champ['btn_value']))
                    $champ['btn_value'] = '';
				if ( ! isset( $champ['row_css'] ) )
					$champ['row_css'] = '';
				if ( ! isset( $champ['ig_desc'] ) ) 
					$champ['ig_desc'] = false;


                $description = $champ['description'];

                if ($description && in_array($champ['type'], array('textarea', 'radio'))) {
                    $description = "<p style='margin-top:0'> $description </p>";
                } elseif ($description) {
                    $description = "<span class='description'>$description</span>";
                }

                $post_id         = get_the_ID();
                $champ_value    = '';
                $raw_hierarchy   = self::explodes_x(array('[', ']'), $champ['name']);
                $hierarchy       = array_filter($raw_hierarchy);
                $section_types   = array('sectionstart', 'sectionend');
                $settings_table  = self::get_right_value($data[0], 'table', 'metas');

                if (!in_array($champ['type'], $section_types) & !empty($hierarchy)) {
                    $root_key    = $hierarchy[0];
                    $session_key = $root_key . "_$post_id";

                    $champ_value = null;
                    if (isset($_SESSION['util-data'])) {
                        $_SESSION['util-data'] = filter_input(INPUT_POST, 'util-data', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                        $champ_value       = self::get_right_value($_SESSION['util-data'], $session_key, false);
                    }

					
                    if (!$champ_value) {
                        // Retrieve from the metas.
                        if ('metas' == $settings_table) {
							$champ_value                       = get_post_meta($post_id, $root_key, true);
                            $_SESSION['util-data'][$session_key] = $champ_value;
                        } elseif ('options' == $settings_table) { // Retrieve from the options.
                            $champ_value                       = get_option($root_key);
                            $_SESSION['util-data'][$session_key] = $champ_value;
                        } elseif ('custom' == $settings_table) {
                            $champ_value                       = self::get_right_value($data[0], 'data', array());
                            $_SESSION['util-data'][$session_key] = $champ_value;
                        }
                    }
					
                    $session_key = $root_key . "_$post_id";
                    $root_value  = self::get_right_value($_SESSION['util-data'], $session_key, false);
                    if ($root_key != $champ['name']) {
						$champ_value = self::find_in_array_by_key($root_value, $champ['name']);
                    }
                }
				if ( ! $champ_value && '0' !== $champ_value ) {
					$champ_value = $champ['default'];
				}

				if ( ! in_array( $champ['type'], $section_types ) && ! $champ['ig_desc'] ) {
					$descrip = $champ['description'];
					champ_text_desc($champ['title'], $descrip);
				}

                switch ($champ['type']) {
                    case 'sectionstart':
                        // We start/reset the session.
                        $_SESSION['util-data'] = array();
                        section_start($champ['id']);
                        break;
                    case 'sectionend':
                        section_end();
                        break;
                    case 'text':
                    case 'email':
                    case 'number':
                    case 'password':
                    case 'color':
                    case 'date':
                    case 'datetime':
                    case 'month':
                    case 'hour':
                        $type = $champ['type'];
                        input_x($champ['name'], $champ['id'], $type, $champ['css'], $champ_value, $champ['class'], $champ['placeholder']);
                        break;
                    case 'textarea':
                        textarea_x($champ['name'], $champ['id'], $champ['css'], $champ_value, $champ['class'], $champ['placeholder']);
                        break;
                    case 'texteditor':
                        texteditor_x($champ['name'], $champ['id'], $champ_value);
                        break;
                    case 'select':
                    case 'multiselect':
                        select_x($champ['name'], $champ['id'], $champ['type'], $champ['css'], $champ['class'], $champ['options'], $champ_value);
                        break;
                    case 'radio':
                        radio_x($champ['options'], $champ['name'], $champ['css'], $champ['class'], $champ_value);
                        break;
                    case 'checkbox':
                        checkbox_x($champ['name'], $champ['title'], $champ_value, $champ['id'], $champ['css'], $champ['class'], $champ['description']);
                        break;
                    case 'file':
                        file_x($champ['name'], $champ['class'], $champ_value);
                        break;
					case 'submit':
						button_submit_x($champ['id'], $champ['css'], $champ['btn_value'], $champ['class'], $champ['title']);
						break;
					default:
						do_action( 'admin_form_' . $champ['type'], $champ );
						break;
                }
            }
            return ob_get_clean();
        }


        public static function get_right_value($values, $search_key, $default_value = ''){
            if (isset($values[$search_key])) {
                $default_value = $values[$search_key];
            }

            return $default_value;
        }

        /**
         * Explode a character.
         *
         * @param string $delimiters Delimiters.
         * @param string $string String value.
         *
         * @return false|string[]
         */
        public static function explodes_x($delimiters, $string)
        {
            return explode(chr(1), str_replace($delimiters, chr(1), $string));
        }

        /**
         * Returns a media URL
         *
         * @param mixed $media_id Media ID.
         *
         * @return mixed
         */
        public static function get_media_url($media_id)
        {
            $attachment = wp_get_attachment_image_src($media_id, 'full');

            return $attachment[0];
        }

        public static function find_in_array_by_key($root_value, $key)
        {
            $bracket_pos         = strpos($key, '[');
            $usable_value_index  = substr($key, $bracket_pos);
            $usable_value_index2 = str_replace('[', '', $usable_value_index);
            $temp_array          = explode(']', $usable_value_index2, -1);
            foreach ($temp_array as $key => $value) {
                if (!is_array($root_value) || !isset($root_value[$value])) {
                    return false;
                }
                $root_value = $root_value[$value];
            }
            return $root_value;
        }

        /**
		 * Function to load allowed html tags.
		 *
		 * @return array
		 */
		public static function get_allowed_balises() {
			$allowed_balises = wp_kses_allowed_html( 'post' );
			add_filter(
				'safe_style_css',
				function( $styles ) {
					$styles[] = 'display';
					return $styles;
				}
			);

			$allowed_balises['li'] = array(
				'id'             => array(),
				'name'           => array(),
				'class'          => array(),
				'value'          => array(),
				'style'          => array(),
			);

			$allowed_balises['br'] = array();

			$allowed_balises['input'] = array(
				'type'           => array(),
				'id'             => array(),
				'name'           => array(),
				'style'          => array(),
				'class'          => array(),
				'value'          => array(),
				'min'            => array(),
				'max'            => array(),
				'selected'       => array(),
				'checked'        => array(),
				'readonly'       => array(),
				'placeholder'    => array(),
				'hidden'    	 => array(),
				'autocomplete'   => array(),
				'pattern'        => array(),
				'required'       => array(),
			);
			$allowed_balises['form']  = array(
				'accept-charset' => array(),
				'id'             => array(),
				'name'           => array(),
				'style'          => array(),
				'class'          => array(),
				'value'          => array(),
				'action'         => array(),
				'autocomplete'   => array(),
				'novalidate'     => array(),
				'method'         => array(),
				'readonly'       => array(),
				'target'         => array(),
				'hidden'         => array(),
			);

			$allowed_balises['div'] = array(
				'id'                   => array(),
				'name'                 => array(),
				'data-id'              => array(),
				'class'                => array(),
				'role'                 => array(),
				'tabindex'             => array(),
				'style'                => array(),
				'media'                => array(),
			);
			$allowed_balises['i']   = array();

			$allowed_balises['button'] = array(
				'id'                => array(),
				'name'              => array(),
				'class'             => array(),
				'value'             => array(),
				'style'             => array(),
				'data-editor'       => array(),
				'type'              => array(),
			);

			$allowed_balises['body'] = array(
				'id'                 => array(),
				'name'               => array(),
				'class'              => array(),
			);

			$allowed_balises['a']        = array(
				'id'               => array(),
				'name'             => array(),
				'class'            => array(),
				'data-tpl'         => array(),
				'href'             => array(),
				'target'           => array(),
				'data-group'       => array(),
				'download'         => array(),
				'style'            => array(),
			);
			$allowed_balises['select']   = array(
				'id'         => array(),
				'name'       => array(),
				'class'      => array(),
				'data-tpl'   => array(),
				'style'      => array(),
				'multiple'   => array(),
				'tabindex'   => array(),
			);
			$allowed_balises['optgroup'] = array(
				'id'       => array(),
				'name'     => array(),
				'class'    => array(),
				'style'    => array(),
				'multiple' => array(),
				'tabindex' => array(),
				'label'    => array(),
			);
			$allowed_balises['option']   = array(
				'id'       => array(),
				'name'     => array(),
				'class'    => array(),
				'value'    => array(),
				'style'    => array(),
				'selected' => array(),
				'tabindex' => array(),
			);

			$allowed_balises['span'] = array(
				'id'                 => array(),
				'name'               => array(),
				'class'              => array(),
				'value'              => array(),
				'style'              => array(),
			);

			$allowed_balises['h1']     = array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			);
			$allowed_balises['iframe'] = array();
			$allowed_balises['h2']     = array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			);
			$allowed_balises['h3']     = array(
				'style' => array(),
				'id'    => array(),
				'class' => array(),
			);

			$allowed_balises['link'] = array(
				'id'    => array(),
				'rel'   => array(),
				'media' => array(),
				'href'  => array(),
			);

			$allowed_balises['textarea'] = array(
				'autocomplete'   => array(),
				'autocorrect'    => array(),
				'autocapitalize' => array(),
				'class'          => array(),
				'rows'           => array(),
				'cols'           => array(),
				'name'           => array(),
				'id'             => array(),
				'style'          => array(),
			);

			$allowed_balises['table'] = array(
				'border'      => array(),
				'class'       => array(),
				'style'       => array(),
			);

			$allowed_balises['tr'] = array(
				'align'   => array(),
				'class'   => array(),
				'style'   => array(),
			);

			$allowed_balises['td'] = array(
				'colspan' => array(),
				'class'   => array(),
				'style'   => array(),
			);

			$allowed_balises['th'] = array(
				'colspan' => array(),
				'class'   => array(),
				'style'   => array(),
			);

			$allowed_balises['img'] = array(
				'src'    => array(),
				'alt'    => array(),
				'height' => array(),
				'width'  => array(),
				'style'  => array(),
				'class'  => array(),
			);

			return apply_filters( 'allowed_balises', $allowed_balises );
		}
    }
}
