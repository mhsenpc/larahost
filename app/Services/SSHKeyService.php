<?php


namespace App\Services;


use App\Models\Site;
use App\Models\User;

class SSHKeyService {
    public static function generateKeyPair(User $user) {
        $keys_dir = PathHelper::getSSHKeysDir($user->email);
        SuperUserAPIService::generate_key_pair($user->email, $keys_dir);
        return true;
    }
}
