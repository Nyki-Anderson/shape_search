<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'username';
    protected $useAutoIncrement = FALSE;
    protected $returnType       = \App\Entities\User::class;
    protected $useSoftDelete    = FALSE;
    protected $allowedFields    = [
        'username',
        'password',
        'role',
        'profile_image',
        'profile_views',
        'last_login',
        'about_me',
        'birthday',
        'gender',
        'occupation',
        'hometown',
        'country',
        'fav_shape',
        'fav_color',
        'modified',
    ];

    // Validation
    protected $validationRules = 'registration';
    protected $skipValidation = FALSE;

    public function __construct() 
    {
        parent::__construct(); 
    }

    public function updateModified(array $data)
    {
       $modified = Time::now('America/New_York', 'en_US');

       if ($data['modified'] === NULL) {

            $data['modified'] = $modified;
        
            return $data;
        }
    }

    public function hashPassword(array $data) 
    {
        if (isset($data['password'])) {

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            return $data;
        }
    }

    public function lastLogin(int $id)
    {
        $lastLogin = Time::now('America/New_York', 'en_US');

        return $this->builder()
            ->set('last_login', $lastLogin)
            ->where('id', $id)
            ->update();
    }

    public function addUser(array $newUser)
    {
        $newUser = $this->hashPassword($newUser);
        $newUser = $this->updateModified($newUser);

        return $this->builder()
            ->set($newUser)
            ->insert();
    }

     public function updateProfile(array $updateProfile)
    {
        $updateProfile = $this->updateModified($updateProfile);

        return $this->builder()
            ->set($updateProfile)
            ->where('username', session()->get('username'))
            ->update();
    }

    public function updateProfileImage(array $updateProfileImage)
    {
        $updateProfileImage = $this->updateModified($updateProfileImage);

        return $this->builder()
            ->set($updateProfileImage)
            ->where('username', session()->get('username'))
            ->update();
    }

    public function getUser(string $username)
    {
       return $this->builder()
            ->where(['username' => $username])
            ->get()
            ->getRow();
    }

    public function fillUserEntity(string $profile)
    {
        $userData = $this->builder()
            ->where(['username' => $profile])
            ->get()
            ->getRowArray();

        $user = new \App\Entities\User();

        $user->fill($userData);
        $user->setAge($userData['username']);
        $user->setUploads($userData['username']);
        $user->setSubscribers($userData['username']);
        $user->setUserSubscribed($userData['username']);
        $user->setSubscriberCount($userData['username']);
        $user->setUploadCount($userData['username']);
        $user->setProfileViews($userData['username']);

        return $user;
    }

    public function getSubscribeProfiles(array $where, string $field)
    {
        $subscribers = [];

        $profiles = $this->builder('subscribers')
            ->where($where)
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();

        if (! empty($profiles)) {

            foreach ($profiles as $profile) {

                $subscribers[$profile->id] = $this->fillUserEntity($profile->$field);
            }
        }

        return $subscribers;
    }

    public function getSubscribersInfo(string $profile)
    {
        $subscriberList = [];

        $profileList = $this->builder('subscribers')
            ->where('profile', $profile)
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();

        if (! empty($profileList)) {

            foreach ($profileList as $profile) {

                $profileImage = $this->getUser($profile->subscriber);
                
                $subscriberList[$profileImage->id] = [
                    'subscriber'        => $profile->subscriber,
                    'profile_image'     => $profileImage->profile_image,
                ];
            }
        }

        return $subscriberList;
    }
}