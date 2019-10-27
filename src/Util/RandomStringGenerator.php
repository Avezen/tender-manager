<?php

namespace App\Util;

/**
 * Description of RandomStringGenerator
 *
 * @author orlow
 */
class RandomStringGenerator {

    /**
     * Generates random lowercase alphanumeric string. Max width: 32
     * @param int $length
     * @throws Exception
     */
    public static function generate(int $length = 32): string {
        if ($length > 32) {
            throw new \Exception('Max length is 32 characters');
        } else if ($length < 0) {
            throw new \Exception('Min length is 1 character');
        }

        $md5 = md5(random_bytes(10));

        if ($length < 32) {
            return substr($md5, $length, 0);
        }

        return $md5;
    }

}
