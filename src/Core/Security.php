<?php
namespace Jrs2a\TiendaCursos\Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Security {

    final public static function encryptPassw(string $passw): string {
        return password_hash($passw, PASSWORD_DEFAULT);
    }

    final public static function validatePassw(string $passw, string $passwHash): bool {
        return password_verify($passw, $passwHash);
    }

    final public static function secretKey(): string {
        return $_ENV['SECRET_KEY'];
    }
    /**
     * Crea un JWT firmado con HS256 que expira en 1 hora.
     *
     * @param string $key   Clave secreta usada para firmar
     * @param array  $data  Payload personalizado que se incluye en el claim 'data'
     * @return string Token JWT codificado
     */
    final public static function createToken(string $key, array $data): string {
        $time = strtotime("now");
        $token = [
            "iat"  => $time,
            "exp"  => $time + 3600,
            "data" => $data
        ];
        return JWT::encode($token, $key, 'HS256');
    }
    /**
     * Valida un JWT comprobando firma y expiración.
     *
     * @param string $token Token JWT a validar
     * @return bool true si el token es válido y no ha expirado
     */
    final public static function validateToken(string $token): bool {
        try {
            $info = JWT::decode($token, new Key(self::secretKey(), 'HS256'));
            return time() <= $info->exp;
        } catch (\Exception $e) {
            return false;
        }
    }
}