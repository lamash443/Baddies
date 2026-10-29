<?php

namespace App\Helpers;

class ChatHelper
{
    private const MOD = 90000000;
    private const OFFSET = 10000000;
    private const MULTIPLIER = 38472911;
    private const INVERSE = 55734191;

    /**
     * Encode an integer user ID into an 8-digit random-looking code.
     */
    public static function encodeId(int|string|null $id): string
    {
        if (!$id) return '';
        if ($id === 'announcement') return 'announcement';
        if (!is_numeric($id)) return (string) $id;

        $idInt = (int) $id;
        if ($idInt <= 0) return (string) $id;

        $val = ($idInt * self::MULTIPLIER) % self::MOD;
        return (string) ($val + self::OFFSET);
    }

    /**
     * Decode an 8-digit code back into the original user ID.
     */
    public static function decodeId(int|string|null $code): ?int
    {
        if (!$code || !ctype_digit((string) $code)) return null;

        $num = (int) $code;
        if ($num < self::OFFSET || $num >= self::OFFSET + self::MOD) return null;

        $val = $num - self::OFFSET;
        $id = ($val * self::INVERSE) % self::MOD;

        return $id > 0 ? (int) $id : null;
    }

    /**
     * Resolve a URL parameter (raw ID or 8-digit code).
     * Returns [$resolvedUserId, $redirectToCode]
     * If the user accessed via raw ID (e.g. 62), $redirectToCode will be the 8-digit code.
     */
    public static function resolve(int|string|null $param): array
    {
        if ($param === 'announcement') {
            return ['announcement', null];
        }

        if (!$param) {
            return [null, null];
        }

        // Try decoding as obfuscated code
        $decodedId = self::decodeId($param);
        if ($decodedId) {
            return [$decodedId, null];
        }

        // Fallback: If accessed via raw integer ID, resolve it and redirect to the 8-digit code
        if (is_numeric($param)) {
            $rawId = (int) $param;
            return [$rawId, self::encodeId($rawId)];
        }

        return [null, null];
    }
}
