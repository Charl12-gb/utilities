<?php 

/**
 * Start of the section
 * @param string $id            -> id section
 * @param string $div_class     -> class section
 * @return void
 */
function section_start($id, $div_class=null){
    ?>
    <div class="wrap">
    <div id="<?php echo esc_attr($id); ?>" class="metabox-container">
    <div class="<?php echo esc_attr($div_class); ?>">
    <?php
}

/**
 * End of the section
 * @return void
 */
function section_end(){
    ?>
    </div>
    </div>
    </div>
    <?php
}

/**
 * Part title and description of the fields
 * @param string $title
 * @param string $description
 * @return void
 */
function champ_text_desc($title, $description){
    ?>
	<div class="">
	<?php
		echo wp_kses_post( $title );
		echo wp_kses_post( "<div class=''>" . $description . '</div>' );
	?>
	</div>
	<?php
}

/**
 * Standard text inputs and subtypes like 'text'
 * @param string $name
 * @param string $id
 * @param string $type
 * @param string $style
 * @param string $value
 * @param string $class
 * @param string $placeholder
 * @return void
 */
function input_x($name, $id, $type, $style, $value, $class, $placeholder){
    ?>
    <div>
        <input
            name="<?php echo esc_attr( $name ); ?>"
            id="<?php echo esc_attr( $id ); ?>"
            type="<?php echo esc_attr( $type ); ?>"
            style="<?php echo esc_attr( $style ); ?>"
            value="<?php echo esc_attr( $value ); ?>"
            class="<?php echo esc_attr( $class ); ?>"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"/>
        </div>
    <?php
}

/**
 * Textarea standard entry
 * @param string $name
 * @param string $id
 * @param string $style
 * @param string $value
 * @param string $class
 * @param string $placeholder
 * @return void
 */
function textarea_x($name, $id, $style, $value, $class, $placeholder){
    ?>
    <div>
        <textarea 
            name="<?php echo esc_attr( $name ); ?>"
            id="<?php echo esc_attr( $id ); ?>"
            style="<?php echo esc_attr( $style ); ?>"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"
            class="<?php echo esc_attr( $class ); ?>">
            <?php echo esc_textarea( $value ); ?>
        </textarea>
    <div>
    <?php
}

/**
 * Text editor fields
 * @param string $name
 * @param string $id
 * @param string $value
 * @return void
 */
function texteditor_x($name, $id, $value){
    ?><div><?php
    wp_editor(
        $value,
        $id,
        array(
            'wpautop'       => true,
            'media_buttons' => false,
            'textarea_name' => $name,
            'textarea_rows' => 10,
        )
    );
    ?></div><?php
}

/**
 * Selector fields
 * @param string $name
 * @param string $id
 * @param string $type
 * @param string $style
 * @param string $class
 * @param array $options
 * @param string $value
 * @return void
 */
function select_x($name, $id, $type, $style, $class, $options, $value){

	$select_is_multiple = '';
	if ( 'multiselect' === $type ) {
		$select_is_multiple = ' multiple="multiple"';
	}
	?>
    <div>
        <select 
            name="<?php echo esc_attr( $name ); ?>"
            id="<?php echo esc_attr( $id ); ?>"
            style="<?php echo esc_attr( $style ); ?>"
            class="<?php echo esc_attr( $class ); ?>"
            <?php echo esc_attr( $select_is_multiple ); ?> >
            <?php
            foreach ( $options as $key => $val ) {
                ?>
                <option value="<?php echo esc_attr( $key ); ?>"
                <?php 
                if ( is_array( $value ) ) {
                    selected( in_array( $key, $value, false ), true );
                } else {
                    selected( $value, $key );
                }
                ?>>
                <?php echo esc_html( $val ); ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <?php
}

/**
 * Checkbox fields
 * @param string $name
 * @param string $title
 * @param string $value
 * @param string $id
 * @param string $style
 * @param string $class
 * @param string $description
 * @return void
 */
function checkbox_x($name, $title, $value, $id, $style, $class, $description){
    if ( $title != '' ) {
		?><div>
		<legend>
            <span><?php echo esc_html( $title ); ?></span>
		</legend>
		<?php
	}

    ?>
	<label for="<?php echo esc_attr( $id ); ?>">
        <input 
            name="<?php echo esc_attr( $name ); ?>"
            id="<?php echo esc_attr( $id ); ?>"
            type="checkbox"
            style="<?php echo esc_attr( $style ); ?>"
            class="<?php echo esc_attr( $class ); ?>"
            value="<?php echo esc_attr( $value ); ?>"
            <?php checked( $value, $value ); ?> />
        <?php echo wp_kses_post( $description ); ?>
	</label>
    </div>
	<?php					
}

/**
 * Radio fields
 * @param array $options
 * @param string $name
 * @param string $css
 * @param string $class
 * @param string $value
 * @return void
 */
function radio_x(array $options, $name, $css, $class, $value){
    ?>
    <div>
	<fieldset>
		<ul>
            <?php
                foreach ( $options as $key => $val ) {
                ?>
                    <li>
                        <label>
                            <input 
                                name="<?php echo esc_attr( $name ); ?>"
                                value="<?php echo esc_attr( $key ); ?>" type="radio"
                                style="<?php echo esc_attr( $css ); ?>"
                                class="<?php echo esc_attr( $class ); ?>"
                                <?php checked( $key, $value ); ?> /> 
                                <?php echo esc_attr( $val ); ?>
                        </label>
                    </li>
                <?php
                }
            ?>
		</ul>
	</fieldset>
    </div>
	<?php
}

/**
 * File fields
 * @param string $name
 * @param string $class
 * @param string $value
 * @return void
 */
function file_x($name, $class, $value){
    ?>
    <div>
    <div class="<?php echo esc_attr( $class ); ?>">
        <input type="hidden" name="<?php echo esc_attr( $name ); ?>"
            value="<?php echo esc_attr( $value ); ?>">
        <div>
            <?php
            if ( $value != '' ) {
                echo esc_attr( basename( $value ) );
            }
            ?>
        </div>
    </div>
    </div>
    <?php
}

/**
 * Button fields
 * @param string $id
 * @param string $style
 * @param string $value
 * @param string $class
 * @param string $title
 * @return void
 */
function button_submit_x($id, $style, $value, $class, $title){
    ?>
    <div>
        <button 
            id="<?php echo esc_attr( $id ); ?>" 
            style="<?php echo esc_attr( $style ); ?>"
            value="<?php echo esc_attr( $value ); ?>"
            class="<?php echo esc_attr( $class ); ?>" 
            type="submit">
            <?php echo esc_attr( $title ); ?></button>
    </div>
	<?php
}