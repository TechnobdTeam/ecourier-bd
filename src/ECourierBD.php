<?php 
namespace technobd\ecourierbd;

//define("GREETING", "Welcome to W3Schools.com!");


class ECourierBD
{
    protected $api_key;
    protected $api_secret;
    protected $user_id;
    protected $sandbox = TRUE;
    protected $sandbox_url = "https://dev.ecourier.com.bd/apiv2/";
    protected $production_url = "https://ecourier.com.bd/apiv2/";

    


    public function init($apiKey, $apiSecret, $userId, $sandbox = true)
    {
        $this->api_key = $apiKey;
        $this->api_secret = $apiSecret;
        $this->user_id = $userId;
        $this->sandbox = $sandbox;
    }

    
    public function placeOrder($data = []){

        $response = NULL;

        try {
            $data['parcel'] = "insert";
            $this->validateplaceOrderData($data);
            
            $response = $this->sendData($data);
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $response;
    }

    public function percelTracking($data = []){
        $response = NULL;

        try {
            $data['parcel'] = "track";
            $this->validatePercelTrackingData($data);
            $response = $this->sendData($data);
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $response;
    }

    public function supportedCityList(){
        $response = NULL;

        try {
            $data['parcel'] = "citylist";
            $response = $this->sendData($data);
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $response;
    }

    public function supportedCoverageAreaList($city = 'Dhaka'){
        $response = NULL;

        try {
            $data['parcel'] = "arealist";
            $data['city'] = $city;
            $response = $this->sendData($data);
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $response;
    }

    public function supportedPackageList(){
        $response = NULL;

        try {
            $data['parcel'] = "packagelist";
            $response = $this->sendData($data);
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $response;
    }

    public function cancelOrder($data = []){
        $response = NULL;

        try {
            $data['parcel'] = "cancel_order";
            $this->validateCancelOrderData($data);
            $response = $this->sendData($data);
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $response;
    }

    public function fraudAlertService($mobileNumber){
        $response = NULL;

        try {
            $data['parcel'] = "fraud_status_check";
            $this->validateFraudAlertServiceData($data);
            $response = $this->sendData($data);
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $response;
    }

    private function validateFraudAlertServiceData($data = []){

        $requiredKeys = [
            'percel',
            'number', // mobile number 017xxxxx
        ];

        if( !is_array($data)) {
            throw new Exception("data must be an array type");
        }

        foreach ($data as $key => $val) {
            if ( ! in_array($key, $requiredKeys)){
                throw new Exception("Unsupported parameter name : $key");
            }

            if(empty($val)){
                throw new Exception("value of parameter : $key must exists");
                die();
            }

            if( ! is_string($val)){
                throw new Exception("value of parameter : $key must be string");
                die();
            }
        }

        return TRUE;
    }

    private function validateCancelOrderData($data = []){

        $requiredKeys = [
            'percel',
            'tracking_no', // ecr no
            'comment'
        ];

        if( !is_array($data)) {
            throw new Exception("data must be an array type");
        }

        foreach ($data as $key => $val) {
            if ( ! in_array($key, $requiredKeys)){
                throw new Exception("Unsupported parameter name : $key");
            }

            if(empty($val)){
                throw new Exception("value of parameter : $key must exists");
                die();
            }

            if( ! is_string($val)){
                throw new Exception("value of parameter : $key must be string");
                die();
            }
        }

        return TRUE;
    }

    private function validatePercelTrackingData($data = []){

        $requiredKeys = [
            'percel',
            //'product_id',
            //'ecr'
        ];

        if( !is_array($data)) {
            throw new Exception("data must be an array type");
        }

        foreach ($data as $key => $val) {
            if ( ! in_array($key, $requiredKeys)){
                throw new Exception("Unsupported parameter name : $key");
            }

            if(empty($val)){
                throw new Exception("value of parameter : $key must exists");
                die();
            }

            if( ! is_string($val)){
                throw new Exception("value of parameter : $key must be string");
                die();
            }
        }

        if ( ! array_key_exists("product_id",$data)){
            if ( ! array_key_exists("ecr",$data)){
                throw new Exception("parameter : ecr / product_id must be exists");
                die();
            }
            else {
                if(empty($data['ecr'])){
                    throw new Exception("value of parameter : ".$data['ecr']." must exists");
                    die();
                }
            }
        }
        else {
            if(empty($data['product_id'])){
                throw new Exception("value of parameter : ".$data['product_id']." must exists");
                die();
            }
        }

        return TRUE;
    }


    private function validateplaceOrderData($data = []){

        $requiredKeys = [
            'percel',
            'recipient_name',
            'recipient_mobile',
            'recipient_city',
            'recipient_area',
            'recipient_address',
            'package_code',
            'product_price',
            'payment_method'
        ];
    
        $optionalKeys = [
            'recipient_landmark',
            'parcel_type',
            'is_anonymous',
            'requested_delivery_time',
            'delivery_hour',
            'recipient_zip',
            'product_id',
            'pick_address',
            'comments',
            'number_of_item',
            'actual_product_price'
        ];



        if( !is_array($data)) {
            throw new Exception("data must be an array type");
        }


        foreach ($data as $key => $val) {
            if ( ! in_array($key, $requiredKeys)){
                if ( ! in_array($key, $optionalKeys)){
                    throw new Exception("Unsupported parameter name : $key");
                }
            }
        }

        foreach ($data as $key => $val) {
            if ( ! in_array($key, $requiredKeys)){
                throw new Exception(" parameter : $key and its value must be exists");
                die();
            }

            if($key == 'product_price' || $key == 'is_anonymous' || $key == 'number_of_item' || $key == 'actual_product_price'){
                if( ! is_integer($val)){
                    throw new Exception("value of parameter : $key must be an integer");
                    die();
                }
            }
            else {
                if( ! is_string($val)){
                    throw new Exception("value of parameter : $key must be string");
                    die();
                }
            }
        }
        
        return TRUE;
    }



    private function headers()
    {
        return [
            'API_KEY: '. $this->api_key,
            'API_SECRET: '. $this->api_secret,
            'USER_ID: '. $this->user_id,
            'Content-Type: application/json'
        ];
    }

    private function sendData($data = []){

        $postdata = json_encode($data);

        if($this->sandbox == TRUE){
            $url = $this->sandbox_url;
        }
        else {
            $url = $this->production_url;
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        
        // $headers = [
        //     'X-Apple-Tz: 0',
        //     'X-Apple-Store-Front: 143444,12',
        //     'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        //     'Accept-Encoding: gzip, deflate',
        //     'Accept-Language: en-US,en;q=0.5',
        //     'Cache-Control: no-cache',
        //     'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        //     'Host: www.example.com',
        //     'Referer: http://www.example.com/index.php', //Your referrer address
        //     'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        //     'X-MicrosoftAjax: Delta=true'
        // ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $$this->headers());

        $reponse = $server_output = curl_exec($ch);

        if($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            $obj = new stdClass();
            $obj->code = $errno;
            $obj->message = $error_message;
            $reponse = json_encode($obj);
            //echo "cURL error ({$errno}):\n {$error_message}";
        }
        curl_close($ch);
        return $reponse;
    }



}
