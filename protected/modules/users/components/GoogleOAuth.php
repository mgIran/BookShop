<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class GoogleOAuth extends CComponent
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     *
     * @var $_id
     */
    private $_id;

    /**
     * @var string email
     */
    public $email;

    /**
     * @var string OAuth webservice
     */
    public $OAuth;

    /**
     * @var OAuth Requires
     */
    public $scope;
    public $redirect_uri;
    public $client_id;
    public $client_secret;
    public $login_url;
    public $image_size;

    /**
     * GoogleOAuth constructor.
     */
    public function __construct()
    {
        $this->scope = "https://www.googleapis.com/auth/userinfo.email";
        $this->redirect_uri = Yii::app()->createAbsoluteUrl('/googleLogin');
        $this->client_id = "847053315039-s41olq8kabaaee4dn5sk7hk4era5a6b4.apps.googleusercontent.com";
        $this->client_secret = "nAsP8voWDtb2sm3ZC__ZlYit";
        $this->login_url = "https://accounts.google.com/o/oauth2/v2/auth?scope=$this->scope&response_type=code&redirect_uri=$this->redirect_uri&client_id=$this->client_id";
        $this->image_size = 200;
    }

    public function login($model){
        if (!Yii::app()->user->getState('gp_access_token')) {
            if (!isset($_GET['code']) or Yii::app()->user->getState("gp_access_token") or Yii::app()->user->getState("gp_result")) {
                $this->redirect($this->login_url);
            }
            $header = array("Content-Type: application/x-www-form-urlencoded");
            $data = http_build_query(
                array(
                    'code' => str_replace("#", null, $_GET['code']),
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'redirect_uri' => $this->redirect_uri,
                    'grant_type' => 'authorization_code'
                )
            );
            $url = "https://www.googleapis.com/oauth2/v4/token";
            $result = $this->google_request(1, $url, $header, $data);
            if (!empty($result['error'])) { // If error login
                var_dump($result['error']);
                exit;
            } else {
                Yii::app()->user->setState("gp_access_token", $result['access_token']); // Access Token
            }
        }
    }
    
    public function register(){
        $user = new Users('OAuthInsert');
        $user->email = $this->getInfo()->email;
        $user->status = "active";
        $user->auth_mode = 'google';
        $user->role_id = 1;
        $user->save();
    }

    public function getInfo()
    {
        if (Yii::app()->user->getState('gp_access_token')) {
            $access_token = Yii::app()->user->getState("gp_access_token"); // User access token
            $api_url = "https://www.googleapis.com/plus/v1/people/me?fields=aboutMe%2Cemails%2Cimage%2Cname&access_token=$access_token"; // Do not change it!
            if (!Yii::app()->user->getState("gp_result")) {
                $result = $this->google_request(0, $api_url, 0, 0);
                Yii::app()->user->setState("gp_result", $result);
                $user_info = Yii::app()->user->getState("gp_result");
            } else {
                $user_info = Yii::app()->user->getState("gp_result");
            }
            $first_name = $user_info['name']['givenName']; // User first name
            $last_name = $user_info['name']['familyName']; // User last name
            $this->email = $user_info['emails'][0]['value']; // User email
            $get_profile_image = $user_info['image']['url'];
            $change_image_size = str_replace("?sz=50", "?sz=$this->image_size", $get_profile_image);
            $profile_image_link = $change_image_size; // User profile image link
            $page_title = "Hello my name is $first_name $last_name!"; // Page title if user is logged in
        }
        return $this;
    }

    private function google_request($method, $url, $header, $data)
    {
        if ($method == 1) {
            $method_type = 1; // 1 = POST
        } else {
            $method_type = 0; // 0 = GET
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        if ($header !== 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($curl, CURLOPT_POST, $method_type);
        if ($data !== 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        $response = curl_exec($curl);
        $json = json_decode($response, true);
        curl_close($curl);
        return $json;
    }
}