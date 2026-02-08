<?php
class Crypto
{
    private const CIPHER = 'aes-256-cbc';

    public static function encrypt(string $plainText): string
    {
        $key = config('encryption_key');
        $iv = random_bytes(openssl_cipher_iv_length(self::CIPHER));
        $cipherText = openssl_encrypt($plainText, self::CIPHER, $key, 0, $iv);

        return base64_encode($iv . '::' . $cipherText);
    }

    public static function decrypt(string $payload): string
    {
        $key = config('encryption_key');
        $decoded = base64_decode($payload);
        if ($decoded === false) {
            return '';
        }
        [$iv, $cipherText] = explode('::', $decoded, 2);
        $plainText = openssl_decrypt($cipherText, self::CIPHER, $key, 0, $iv);

        return $plainText ?: '';
    }
}
