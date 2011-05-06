<?php
// initialisation
global $mf_domain;


// class with static properties encapsulating functions for the field type

class dropdown_field extends mf_custom_fields {

  public $allow_multiple = TRUE;
  public $has_properties = TRUE;
  
  public function _update_description(){
    global $mf_domain;
    $this->description = __("Simple dropdown input",$mf_domain);
  }
  
  public function _options(){
    global $mf_domain;
    
    $data = array(
      'option'  => array(
        'options'  => array(
          'type'        =>  'textarea',
          'id'          =>  'checkbox_dropdown_options',
          'label'       =>  __('Options',$mf_domain),
          'name'        =>  'mf_field[option][options]',
          'default'     =>  '',
          'description' =>  __( 'Separate each option with a newline.', $mf_domain ),
          'value'       =>  '',
          'div_class'   => '',
          'class'       => ''
        ),
        'multiple' =>  array(
          'type'        =>  'checkbox',
          'id'          =>  'multiple_dropdown_options',
          'label'       =>  __('The dropdown can have multiple values', $mf_domain ),
          'name'        =>  'mf_field[option][multiple]',
          'default'     =>  '',
          'description' =>  '',
          'value'       =>  '',
          'div_class'   =>  '',
          'class'       =>  ''
        ),
        'default_value'  => array(
          'type'        =>  'text',
          'id'          =>  'checkbox_dropdown_default_value',
          'label'       =>  __('Default value',$mf_domain),
          'name'        =>  'mf_field[option][default_value]',
          'default'     =>  '',
          'description' =>  __( 'Separate each value with a newline.', $mf_domain ),
          'value'       =>  '',
          'div_class'    => '',
          'class'       => ''
        )
      )
    );
    
    return $data;
  }
  
  public function display_field( $field, $group_index = 1, $field_index = 1 ) {
    $output = '';

    $check_post_id = null;
    if(!empty($_REQUEST['post'])) {
      $check_post_id = apply_filters('mf_source_post_data', $_REQUEST['post']);
    }


    $values = array();
    
    if($check_post_id) {
      $values = ($field['options']->multiple) ? unserialize($field['input_value']) : $field['input_value'];
    }else{
      $values =   $field['input_value']; 
    }

    $options = preg_split("/\\n/", $field['options']->options);

    $output = '<div class="mf-dropdown-box">';

    $multiple = ($field['options']->multiple) ? 'multiple="multiple"' : '';
    $output .= sprintf('<select class="dropdown_mf" id="%s" name="%s" %s />',$field['input_id'],$field['input_name'],$multiple);
    foreach($options as $option) {
      $check = '';
      $output .= sprintf('<option value="%s" type="checkbox" %s >%s</option>',
        $option,
        $check,
        $option
      );
    }
    $output .= '</select>';
    $output .= '</div>';

    return $output;
  }
}
