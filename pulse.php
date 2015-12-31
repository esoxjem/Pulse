<?php

    // API access key from Google API's Console
    define( 'API_ACCESS_KEY', '<access key>' );


    $registrationIds = array
    ( 
        "<GCM ID>" 
    );

    // message bundle
    $pushMessage = array
    (
        'title'         => 'Test Title',
        'message'       => 'Test Message'
        // add custom values here if needed
    );

    $fields = array
    (
        'registration_ids'  => $registrationIds,
        'data'              => $pushMessage
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );

    echo $result;
?>