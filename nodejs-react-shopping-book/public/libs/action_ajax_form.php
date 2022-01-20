<?php

add_action( 'wp_ajax_nopriv_salmanlateef_save_user_contact_form', 'salmanlateef_save_contact' );
add_action( 'wp_ajax_salmanlateef_save_user_contact_form', 'salmanlateef_save_contact' );
function salmanlateef_save_contact(){

    $title = wp_strip_all_tags($_POST["name"]);
    $email = wp_strip_all_tags($_POST["email"]);
    $message = wp_strip_all_tags($_POST["message"]);

    $args = array(
        'post_title' => $title,
        'post_content' => $message,
        'post_author' => 1,
        'post_status' => 'publish',
        'post_type' => 'salmanlateef_contact',
        'meta_input' => array(
            '_contact_email_value_key' => $email
        )
    );

    $postID = wp_insert_post( $args );

    if ($postID !== 0) {
        $to = get_bloginfo( 'admin_email' );
        $subject = 'Salman Lateef Contact Form - '.$title;

        $header[] = 'From: '.get_bloginfo( 'name' ).' <'.$to.'>';
        $header[] = 'Reply-To: '.$title.' <'.$email.'>';
        $header[] = 'Content-Type: text/html: charset=UTF-8';

        wp_mail( $to, $subject, $message, $headers );

        echo $postID;
    } else {
        echo 0;
    }

    die();

}


?>