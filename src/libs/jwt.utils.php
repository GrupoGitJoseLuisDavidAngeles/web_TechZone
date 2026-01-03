<?php
function base64url_encode(string $data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode(string $data) {
    $remainder = strlen($data) % 4;
    if ($remainder) {
        $data .= str_repeat('=', 4 - $remainder);
    }
    return base64_decode(strtr($data, '-_', '+/'));
}

function generateJWT(array $payload, string $clave) {
    $header = base64url_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $body   = base64url_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$body", $clave, true);
    $signature = base64url_encode($signature);

    return "$header.$body.$signature";
}

function validateJWT(string $jwt, string $clave) {
    $partes = explode('.', $jwt);

    if (count($partes) !== 3) {
        return false;
    }

    [$headerB64, $payloadB64, $signatureB64] = $partes;

    $firmaEsperada = hash_hmac(
        'sha256',
        "$headerB64.$payloadB64",
        $clave,
        true
    );

    $firmaEsperadaB64 = base64url_encode($firmaEsperada);

    if (!hash_equals($firmaEsperadaB64, $signatureB64)) {
        return false;
    }

    $payload = json_decode(base64url_decode($payloadB64), true);

    if ($payload['exp'] < time()) {
        return false;
    }

    return $payload;
}
?>