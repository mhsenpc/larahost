<?php


namespace App\Services;


use App\Models\Site;

class SSHKeyService {
    public static function generateKeyPair(Site $site) {
        $email = $site->user->email;
        $keys_dir = PathHelper::getSSHKeysDir($email, $site->name);
        SuperUserAPIService::generate_key_pair($email, $keys_dir);
        return true;
    }
}
