<?php

namespace App\Http\Acl;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use Illuminate\Support\Facades\Auth;


class UsersACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        //if (Auth::id() === $this->getUserID()) {
            return [
                ['disk' => 'filedisk', 'path' =>  $this->getUserID(), 'access' => 2],
            ];
        //}

        /*return [
            ['disk' => 'disk-name', 'path' => '/', 'access' => 1],                                  // main folder - read
            ['disk' => 'disk-name', 'path' => 'users', 'access' => 1],                              // only read
            ['disk' => 'disk-name', 'path' => 'users/'. \Auth::user()->name, 'access' => 1],        // only read
            ['disk' => 'disk-name', 'path' => 'users/'. \Auth::user()->name .'/*', 'access' => 2],  // read and write
        ];*/
    }
}