<?

namespace Infuso\Google;
use \Infuso\Core;

class Test extends Core\Controller {

    public function indexTest() {
        return true;
    }
    

    public function index_simpleEventAdd() {
        \tmp::header();
        
        $client_id = '3357492066330-b7tqd8ubt8t1lv4m0eimv2tesv956783.apps.googleusercontent.com';
        $service_account_name = '357492066330-b7tqd8ubt8t1lv4m0eimv2tesv956783@developer.gserviceaccount.com';
        $key_file_location = '/bundles/Google/res/key.p12';
        
        $client = new \Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        $service = new \Google_Service_Calendar($client);
        if (isset($_SESSION['service_token'])) {
        $client->setAccessToken($_SESSION['service_token']);
        }
        
        $key = file_get_contents(\file::get($key_file_location)->native());
        $cred = new \Google_Auth_AssertionCredentials(
            $service_account_name,
            array('https://www.googleapis.com/auth/calendar'),
            $key
        );
        
        $client->setAssertionCredentials($cred);
            if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $_SESSION['service_token'] = $client->getAccessToken();
        
        
        $service = new \Google_Service_Calendar($client);
        
        $event =  new \Google_Service_Calendar_Event();
        $event->setSummary('Appointment');
        $event->setLocation('Somewhere');
        $start = new \Google_Service_Calendar_EventDateTime();
        $start->setDateTime('2014-05-21T10:00:00.000-07:00');
        $event->setStart($start);
        $end = new \Google_Service_Calendar_EventDateTime();
        $end->setDateTime('2014-05-21T10:25:00.000-07:00');
        $event->setEnd($end);
        $attendee1 = new \Google_Service_Calendar_EventAttendee();
        $attendee1->setEmail('kopleman@spark-mail.ru');
        // ...
        $attendees = array($attendee1);
        
                        
        $event->attendees = $attendees;
        $createdEvent = $service->events->insert('2bvo2ffevaja76r9vldepvqca8@group.calendar.google.com', $event);
        
            
        \tmp::footer();
    }
    
    public function index_logingToGoogle() {
        \tmp::header();
            $client_id = '357492066330-kub1sd1c6vqbea6ua6hnniosrrihapl6.apps.googleusercontent.com';
            $client_secret = '_I7O9MGVk0J5ifRe72uUHnn2';
            $redirect_uri = 'http://infuso2.herota.ru/Infuso/Google/Test/logingToGoogle';
            
            $client = new \Google_Client(); 
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri($redirect_uri);
            $client->setScopes('email');

            /************************************************
            If we're logging out we just need to clear our
            local access token in this case
            ************************************************/
            if (isset($_REQUEST['logout'])) {
            unset($_SESSION['access_token']);
            }
            
            /************************************************
            If we have a code back from the OAuth 2.0 flow,
            we need to exchange that with the authenticate()
            function. We store the resultant access token
            bundle in the session, and redirect to ourself.
            ************************************************/
            if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
            }
            
            /************************************************
            If we have an access token, we can make
            requests, else we generate an authentication URL.
            ************************************************/
            if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            } else {
            $authUrl = $client->createAuthUrl();
            }
            
            /************************************************
            If we're signed in we can go ahead and retrieve
            the ID token, which is part of the bundle of
            data that is exchange in the authenticate step
            - we only need to do a network call if we have
            to retrieve the Google certificate to verify it,
            and that can be cached.
            ************************************************/
            if ($client->getAccessToken()) {
                $_SESSION['access_token'] = $client->getAccessToken();
                $token_data = $client->verifyIdToken()->getAttributes();
            }
            
            
            if (
                $client_id == '<YOUR_CLIENT_ID>'
                || $client_secret == '<YOUR_CLIENT_SECRET>'
                || $redirect_uri == '<YOUR_REDIRECT_URI>') {
                echo "данные забыл!";
            }
            
            echo "<div class='box'>";
                echo "<div class='request'>";
                    if (isset($authUrl)){
                        echo "<a class='login' href='{$authUrl}'>Connect Me!</a>";
                    }else{
                        echo "<a class='logout' href='?logout'>Logout</a>";
                    }
                echo "</div>";
                
                if (isset($token_data)){ 
                    echo "<div class='data'>";
                        var_dump($token_data); 
                    echo "</div>";
                }
            echo "</div>";
            
        \tmp::footer();
    }
}