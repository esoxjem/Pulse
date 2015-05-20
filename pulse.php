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
        'provider'      => '__Test__',
        'message'       => 'Test Message',
        'title'         => 'Test Title',
        'target'    => 'http://www.google.com',
        'target_type' => 'webview',
        'image'     => 'http://www.indraneelghosh.com/img/sport/sport_318_test-201.gif'
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