<?php

    // API access key from Google API's Console
    define( 'API_ACCESS_KEY', '<access key>' );

    //Want to use FCM or GCM?
    $notificationChannelType = "FCM";
    if ($notificationChannelType == "FCM") {
        $url = 'https://fcm.googleapis.com/fcm/send';
    } else {
        $url = 'https://android.googleapis.com/gcm/send';
    }


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
    curl_setopt( $ch,CURLOPT_URL, $url );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
     if ($result == false) {
         echo 'Curl failed ' . curl_error($ch);
         curl_close($ch);
         return false;
     }
    curl_close( $ch );



  $jsonArray = json_decode($result);
        $results = array();

        if ($jsonArray->canonical_ids != 0 || $jsonArray->failure != 0 || $jsonArray->success != 0) {
            if (!empty($jsonArray->results)) {
                for ($i = 0; $i < count($jsonArray->results); $i++) {
                    $result = $jsonArray->results[$i];
                    if (isset($result->message_id) && isset($result->registration_id)) {
                        $results[] = 'success';
                     //Success
                    } else if (isset($result->message_id)) {
                        $results[] = 'success';
                    } else {
                        if (isset($result->error)) {
                            $results[] = $result->error;
                            switch ($result->error) {
                                case "NotRegistered":
                                    break;
                                case "InvalidRegistration":
                                    break;
                                case "Unavailable":
                                    break;
                                case "InternalServerError":
                                    // You could retry to send it late in another request.
                                    break;
                                case "MissingRegistration":
                                    // Check that the request contains a registration ID
                                    break;
                                case "InvalidPackageName":
                                    // Make sure the message was addressed to a registration ID whose package name matches the value passed in the request.
                                    break;
                                case "MismatchSenderId":
                                    // Invalid SENDER_ID
                                    if($notificationChannelType == "FCM"){
                                        array_push($failed_fcm_ids, $registration_ids[$i]);
                                    }
                                    break;
                                case "MessageTooBig":
                                    // Check that the total size of the payload data included in a message does not exceed 4096 bytes
                                    break;
                                case "InvalidDataKey":
                                    // Check that the payload data does not contain a key that is used internally by GCM.
                                    break;
                                case "InvalidTtl":
                                    // Check that the value used in time_to_live is an integer representing a duration in seconds between 0 and 2,419,200.
                                    break;
                                case "DeviceMessageRateExceed":
                                    // Reduce the number of messages sent to this device
                                    break;
                            }
                        } else {
                            $results[] = 'success';
                        }
                    }
                }
            }
        }

        if(count($failed_fcm_ids) > 0){
	        
            $GOOGLE_API_KEY = null;
           //change the api key to GCM
            //make a function and call it. The set of failed registration ids should be passed as a parameter now.
            $results = array_merge($results, $result1);
        }


    echo $result;
?>
