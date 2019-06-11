<?php    
namespace App\Helpers;

class TokenJWT {

    public function create($payload)
    {
        $secret = 'trenmongdoi';
        $header = [
            "typ"=> "JWT",
            "alg"=> "HS256"
        ];
        $header = base64_encode(json_encode($header));
        $payload['jti'] = $this->createJTI();
        $payload = base64_encode(json_encode($payload));
        $signature = hash('sha256', implode('.', [$header, $payload, $secret]));
        $token = implode('.', [$header, $payload, $signature]);
        return $token;
    }

    private function createJTI()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public function verify()
    {
        $secret = 'trenmongdoi';
        $result = null;
        $bearer_token = $this->getBearerToken();
        if($bearer_token !== null) {
            $bearer_token = explode('.', $bearer_token);
            $header = empty($bearer_token[0]) ? null : $bearer_token[0];
            $payload = empty($bearer_token[1]) ? null : $bearer_token[1];
            $signature = empty($bearer_token[2]) ? null : $bearer_token[2];

            if(hash('sha256', implode('.', [$header, $payload, $secret])) === $signature) {
                $result = [
                    'header'=> json_decode(base64_decode($header), true),
                    'payload'=> json_decode(base64_decode($payload), true),
                ];
            }
        }
        return $result;
    }

    /** 
     * Get header Authorization
     * */
    function getAuthorizationHeader(){
            $headers = null;
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                //print_r($requestHeaders);
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }
    /**
     * get access token from header
     * */
    function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

}