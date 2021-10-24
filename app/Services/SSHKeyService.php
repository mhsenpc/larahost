<?php


namespace App\Services;


use App\Models\Site;
use App\Models\User;

class SSHKeyService {
    public static function generateKeyPair(User $user) {
        SuperUserAPIService::generate_key_pair($user->email, $user->getSSHKeysDir());
        return true;
    }

    public static function writeSSHConfig(User $user) {
        $keys_dir = $user->getSSHKeysDir();
        $config = "Host *
    StrictHostKeyChecking no";
        SuperUserAPIService::new_file("$keys_dir/config", $config);
    }
}
