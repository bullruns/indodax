<?php
error_reporting( E_ALL & ~E_NOTICE );
ini_set("memory_limit",-1);
set_time_limit(0);
date_default_timezone_set('Asia/Jakarta');

class Script
{
    private $url_private = 'https://indodax.com/tapi';
    private $url_list_data = 'http://localhost:8000/api/';

    // Please find Key from trade API Indodax exchange
    private $key = '';
    // Please find Secret Key from trade API Indodax exchange
    private $secretKey = '';
   
    //email from api 
    private $email = '';
    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->key;
        $this->secretKey;
        $this->email;
    }

    public function get_balance($coin)
    {
     
        $data = [
	        'method' => 'getInfo',
	        'timestamp' => '1578304294000',
	        'recvWindow' => '1578303937000'
	    ];
        $post_data = http_build_query($data, '', '&');
        $sign = hash_hmac('sha512', $post_data, $this->secretKey);
        
        $headers = ['Key:'.$this->key,'Sign:'.$sign];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => $this->url_private,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true
        ));

         $response = curl_exec($curl);
        
        curl_close($curl);
        $res_json = json_decode($response,true);
        return $res_json;
    }

   
}

$running = new Script();

print_r($running->get_balance('bal'));