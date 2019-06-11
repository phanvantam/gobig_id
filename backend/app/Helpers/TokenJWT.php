<?php    
namespace App\Helpers;

class TokenJWT {

    public function create($payload)
    {
        $secret = 'trenmongdoi';
        $header = [
            "typ": "JWT",
            "alg": "HS256"
        ];
        $header = base64urlEncode($header);
        $payload = base64urlEncode($payload);
        $signature = hash('sha256', implode('.', [$header, $payload, $secret]));
        $token = implode('.', [$header, $payload, $signature]);
        return $token;
    }

    public function getToken()
    {
        return [
            'header'=> null,
            'payload'=> null,
            'signature'=> null,
        ];
    }

    public function verify()
    {
        $
    }

}