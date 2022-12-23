<?php 

function section_start(){
    ?>
    <div class="wrap">
    <div id="<?php echo esc_attr($champ['id']); ?>" class="metabox-container">
    <div class='block-form'>
    <table class="wp-list-table widefat fixed pages">
    <tbody></tbody>
    <?php
}

function section_end(){
    ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <?php
}

// Standard text inputs and subtypes like 'number'
function input_x($name, $id, $type, $style, $value, $class, $placeholder){
    ?>
    <input
		name="<?php echo esc_attr( $name ); ?>"
		id="<?php echo esc_attr( $id ); ?>"
		type="<?php echo esc_attr( $type ); ?>"
		style="<?php echo esc_attr( $style ); ?>"
		value="<?php echo esc_attr( $value ); ?>"
		class="<?php echo esc_attr( $class ); ?>"
		placeholder="<?php echo esc_attr( $placeholder ); ?>"/>
    <?php
}

function textarea_x($name, $id, $style, $value, $class, $placeholder){
    ?>
    <textarea 
        name="<?php echo esc_attr( $name ); ?>"
		id="<?php echo esc_attr( $id ); ?>"
		style="<?php echo esc_attr( $style ); ?>"
        placeholder="<?php echo esc_attr( $placeholder ); ?>"
		class="<?php echo esc_attr( $class ); ?>">
		<?php echo esc_textarea( $value ); ?>
	</textarea>
    <?php
}

function texteditor_x($name, $id, $value){
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
}

function select_x($name, $id, $type, $style, $class){

	$select_is_multiple = '';
	if ( 'multiselect' === $type ) {
		$select_is_multiple = ' multiple="multiple"';
	}
	?>
    <select 
        name="<?php echo esc_attr( $name ); ?>"
		id="<?php echo esc_attr( $id ); ?>"
		style="<?php echo esc_attr( $style ); ?>"
		class="<?php echo esc_attr( $class ); ?>"
		<?php echo esc_attr( $select_is_multiple ); ?> >
		<?php
		foreach ( $value['options'] as $key => $val ) {
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
    <?php
}

function checkbox_x($name, $title, $value, $id, $style, $class, $description){
    if ( $title != '' ) {
		?>
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
	<?php					
}

function radio_x(array $options, $name, $css, $class, $value){
    ?>
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
	<?php
}

function file_x($name, $class, $value){
    ?>
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
    <?php
}