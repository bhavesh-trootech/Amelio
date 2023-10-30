<?php /* Template Name: Auth Token */ 



/* Google App Client Id */
define('CLIENT_ID', '233839178528-gn1neghr9d1ukqgt7i0on0pkc4fvv79q.apps.googleusercontent.com');

/* Google App Client Secret */
define('CLIENT_SECRET', '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');

/* Google App Redirect Url */
define('CLIENT_REDIRECT_URL', site_url().'/access-token-save/');

	$access_token = $_GET['code'];
	if($access_token){
		// GetAccessToken Start
	    $url = 'https://accounts.google.com/o/oauth2/token';
	   	// echo CLIENT_REDIRECT_URL;
	    $curlPost = 'client_id=' . CLIENT_ID . '&redirect_uri='.CLIENT_REDIRECT_URL.'&client_secret=' . CLIENT_SECRET . '&code='. $access_token . '&grant_type=authorization_code';
	   
	   $ch = curl_init();  
	    curl_setopt($ch, CURLOPT_URL, $url);        
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
	    curl_setopt($ch, CURLOPT_POST, 1);      
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);    
	    $data = json_decode(curl_exec($ch), true);
	    // print_r($data);
	    $access_token =  (isset($data['access_token']))?$data['access_token']:"";
	    $refresh_token = (isset($data['refresh_token']))?$data['refresh_token']:"";
	    if($access_token && $refresh_token){
	    	$user_id = get_current_user_id();
	    	update_user_meta( $user_id, 'access_token', $access_token );
	    	update_user_meta( $user_id, 'refresh_token', $refresh_token );
	    	
			// update_option( 'access_token', $access_token );
			// update_option( 'refresh_token', $refresh_token );
			wp_redirect( site_url().'/therapist-calendar/');
			// exit();
		}
	}else{
		?>
		<div style="flex-direction: column; display: flex;align-items: center; justify-content: center; min-height: 90vh;">
			<h3>Your Google calendar access not getting now.</h3>
			<a href="<?php echo site_url().'/therapist-calendar/'; ?>">Go to calendar</a>
		</div>
		<?php
	}
    
?>