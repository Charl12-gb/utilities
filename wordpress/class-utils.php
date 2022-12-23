<?php
if (!class_exists('Utilities')) {

    class Utilities
    {

        /**
         * Formulaire
         * @param array $data
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
                if (!isset($champ['default']))
                    $champ['default'] = '';
                if (!isset($champ['disabled']))
                    $champ['disabled'] = false;
                if (!isset($champ['title']))
                    $champ['title'] = isset($champ['name']) ? $champ['name'] : '';
                if (!isset($champ['description']))
                    $champ['description'] = '';
                if (!isset($champ['placeholder']))
                    $champ['placeholder'] = '';

                // Custom attribute handling.
                $custom_attributes = array();

                if (!empty($champ['custom_attributes']) && is_array($champ['custom_attributes'])) {
                    foreach ($champ['custom_attributes'] as $attribute => $attribute_champ) {
                        $custom_attributes[] = esc_attr($attribute) . '="' . esc_attr($attribute_champ) . '"';
                    }
                }


                $description = $champ['desc'];

                if ($description && in_array($champ['type'], array('textarea', 'radio'))) {
                    $description = "<p style='margin-top:0'> $description </p>";
                } elseif ($description) {
                    $description = "<span class='description'>$description</span>";
                }

                $post_id         = get_the_ID();
                $champ_value    = '';
                $raw_hierarchy   = self::explodes_x(array('[', ']'), $champ['name']);
                $hierarchy       = array_filter($raw_hierarchy);
                $section_types   = array('sectionbegin', 'sectionend');
                $settings_table  = self::get_right_value($champ[0], 'table', 'metas');

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

                if (!in_array($champ['type'], $section_types)) {
                    $description = $champ['description'];
                    ?>
                    <td class='label'>
                        <?php
                        echo wp_kses_post($champ['title']);
                        echo wp_kses_post("<div class=''>" . $description . '</div>');
                        ?>
                    </td>
                    <?php
                }

                switch ($champ['type']) {
                    case 'sectionstart':
                        // We start/reset the session.
                        $_SESSION['util-data'] = array();
                        ?>
                        <div class="wrap">
                        <div id="<?php echo esc_attr($champ['id']); ?>" class="metabox-container">
                        <div class='block-form'>
                        <table class="wp-list-table widefat fixed pages">
                        <tbody>
                        <?php
                        break;
                    case 'sectionend':
                        ?>
                        </tbody>
                        </table>
                        </div>
                        </div>
                        </div>
                        <?php
                        break;
                }
            }
            return ob_get_clean();
        }


                        /**
                         * Get a value by key in an array if defined
                         *
                         * @param array  $values Array to search into.
                         * @param string $search_key Searched key.
                         * @param mixed  $default_value Value if the key does not exist in the array.
                         *
                         * @return mixed
                         */
                        public static function get_right_value($values, $search_key, $default_value = '')
                        {
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
                    }
                }
