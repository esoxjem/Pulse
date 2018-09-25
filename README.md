# Pulse
PHP script that sends a GCM/FCM push message.

1. Add API access key:
   `define( 'API_ACCESS_KEY', '<access key>' );`

2. Add GCM registration tokens
  `$registrationIds = array
    ( 
        "<GCM ID>" 
    );`

3. Run the script.

Note: This is not a GCM server and is only meant for development/testing.
