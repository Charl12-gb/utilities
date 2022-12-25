<?php 

function section_start($id){
    ?>
    <div class="wrap">
    <div id="<?php echo esc_attr($id); ?>" class="metabox-container">
    <table class="">
    <tbody></tbody>
    <?php
}

function section_end(){
    ?>
    </tbody>
    </table>
    </div>
    </div>
    <?php
}

// Standard text inputs and subtypes like 'number'
function input_x($name, $id, $type, $style, $value, $class, $placeholder){
    ?>
    <td>
        <input
            name="<?php echo esc_attr( $name ); ?>"
            id="<?php echo esc_attr( $id ); ?>"
            type="<?php echo esc_attr( $type ); ?>"
            style="<?php echo esc_attr( $style ); ?>"
            value="<?php echo esc_attr( $value ); ?>"
            class="<?php echo esc_attr( $class ); ?>"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"/>
        </td>
    <?php
}

function textarea_x($name, $id, $style, $value, $class, $placeholder){
    ?>
    <td>
        <textarea 
            name="<?php echo esc_attr( $name ); ?>"
            id="<?php echo esc_attr( $id ); ?>"
            style="<?php echo esc_attr( $style ); ?>"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"
            class="<?php echo esc_attr( $class ); ?>">
            <?php echo esc_textarea( $value ); ?>
        </textarea>
    <td>
    <?php
}

function texteditor_x($name, $id, $value){
    ?><td><?php
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
    ?></td><?php
}

function select_x($name, $id, $type, $style, $class, $options, $value){

	$select_is_multiple = '';
	if ( 'multiselect' === $type ) {
		$select_is_multiple = ' multiple="multiple"';
	}
	?>
    <td>
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
    </td>
    <?php
}

function checkbox_x($name, $title, $value, $id, $style, $class, $description){
    if ( $title != '' ) {
		?><td>
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
    </td>
	<?php					
}

function radio_x(array $options, $name, $css, $class, $value){
    ?>
    <td>
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
    </td>
	<?php
}

function file_x($name, $class, $value){
    ?>
    <td>
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
    </td>
    <?php
}

function button_submit_x($id, $style, $value, $class, $title){
    ?>
    <td>
        <button 
            id="<?php echo esc_attr( $id ); ?>" 
            style="<?php echo esc_attr( $style ); ?>"
            value="<?php echo esc_attr( $value ); ?>"
            class="<?php echo esc_attr( $class ); ?>" 
            type="submit">
            <?php echo esc_attr( $title ); ?></button>
    </td>
	<?php
}