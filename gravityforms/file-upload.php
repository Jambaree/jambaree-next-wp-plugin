<?php

add_action( 'gform_pre_process', function ( $form ) {
    
    foreach($form['fields'] as $field):
        if($field['type'] == 'fileupload'){

            $field_id = $field['id'];

            $raw_string = rgpost( 'input_' . $field_id );
            $array = explode(',', $raw_string);
            $base64_type = $array[0];
            $base64_string = $array[1];

            if (strpos($base64_type, '.pdf') !== false) {
                $type = 'pdf';
            }else{
                $type = 'png';
            }

            if (!empty( $base64_string)){
                $target_dir = GFFormsModel::get_upload_path( $form['id'] ) . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

                if ( ! is_dir( $target_dir ) ) {
                    if ( ! wp_mkdir_p( $target_dir ) ) {
                        return;
                    } else {
                        GFCommon::recursive_add_index_file( $target_dir );
                    }
                }

                $file_contents = base64_decode( preg_replace( '#^data:image/\w+;base64,#i', '', $base64_string ) );
                
                $temp_filename = sprintf( '%s_input_%s.%s', GFFormsModel::get_form_unique_id( $form['id'] ), $field_id, $type );

                $result = file_put_contents( $target_dir . $temp_filename, $file_contents );

                $uploaded_file_name = wp_generate_uuid4() . '.' . $type;

                $_POST['gform_uploaded_files'] = json_encode( array( 'input_' . $field_id => $uploaded_file_name ) );
            }
        }
    endforeach;
});