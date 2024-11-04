<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
require_once 'vendor/autoload.php';

class googlecalender183 extends Google_Client {
 
    function __construct($params = array()) {
        parent::__construct();
        // $this->client = new Google\Client();
        // $this->client->setAuthConfig('credential.json');
        // $this->client->setApplicationName('Calendar Api');
        // $this->ci =& get_instance();
        // // $this->client->setRedirectUri($this->ci->config->base_url().'gc/auth/oauth');
        // $this->client->setRedirectUri($this->ci->config->base_url().'calender');
        // $this->client->addScope(Google_Service_Calendar::CALENDAR);
    }

    public function loginUrl() {
        return $this->client->createAuthUrl();
    }

    public function getAuthenticate($code) {
        return $this->client->authenticate($code);
    }

    // public function client() {
    //     return $this->client;
    // }

    // public function getAccessToken() {
    //     return $this->client->getAccessToken();
    // }

    // public function setAccessToken() {
    //     return $this->client->setAccessToken();
    // }

    // public function revokeToken() {
    //     return $this->client->revokeToken();
    // }

    // public function getUser() {
    //     $google_ouath = new Google_Service_Oauth2($this->client);
    //     return (object)$google_ouath->userinfo->get();
    // }

    // public function isAccessTokenExpired() {
    //     return $this->client->isAccessTokenExpired();
    // } 
}

?>