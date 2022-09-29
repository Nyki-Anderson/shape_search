<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\ImageModel;
use App\Models\UserModel;
use App\Models\SubscribeModel;

use CodeIgniter\I18n\Time;

class User extends Entity
{
    protected $attributes = [
        'id'                => NULL,
        'username'          => NULL,
        'password'          => NULL,
        'role'              => NULL,
        'profileImage'      => NULL,
        'profileViews'      => NULL,
        'lastLogin'         => NULL,
        'aboutMe'           => NULL,
        'bday_month'        => NULL,
        'bday_day'          => NULL,
        'bday_year'         => NULL,
        'age'               => NULL,
        'gender'            => NULL,
        'occupation'        => NULL,
        'hometown'          => NULL,
        'country'           => NULL,
        'favShape'          => NULL,
        'favColor'          => NULL,
        'created'           => NULL,
        'modified'          => NULL,
        'uploads'           => NULL,
        'subscribers'       => NULL,
        'subscriptions'     => NULL,
        'userSubscribed'    => NULL,
        'subscriberCount'   => NULL,
        'uploadCount'       => NULL,
    ];

    protected $datamap = [
        'profile_image'     => 'profileImage',
        'last_login'        => 'lastLogin',
        'about_me'          => 'aboutMe',
        'fav_shape'         => 'favShape',
        'fav_color'         => 'favColor',
        'profile_views'     => 'profileViews'
    ];

    protected $dates = [
        'created',
        'updated',
        'birthday',
    ];

    protected $casts = [
        'uploads'           => 'array',
        'subscribers'       => 'array',
        'userSubscribed'    => 'bool'
    ];

    protected $builder;
    protected $imageModel;
    protected $userModel;
    protected $subscribeModel;

    public function __construct (array $data = null)
    {
        parent::__construct($data);

        $this->imageModel = new ImageModel();
        $this->userModel = new UserModel();
        $this->subscribeModel = new SubscribeModel();
    }

    /** 
     *  Custom __set Methods
     */
    public function setAge(string $profile)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('users');

        $user = $this->userModel->getUser($profile);

        $month = $user->bday_month;
        $day = $user->bday_day;
        $year = $user->bday_year;

        $bday = Time::create($year, $month, $day);

        $this->attributes['age'] = $bday->toDateTimeString();

    }

    public function setUploads(string $uploader)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('images');

        $this->attributes['uploads'] = $this->imageModel->getThumbnails($uploader);
    }

    public function setSubscribers(string $profile)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('subscribers');

        $this->attributes['subscribers'] = $this->userModel->getSubscribersInfo($profile);
    }

    public function setUserSubscribed(string $profile)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('subscribers');

        $where = [];

        $where = [
            'profile'   => $profile,
            'subscriber'    => session()->get('username'),
        ];

        $userSubscribed = $this->builder
            ->where($where)
            ->countAllResults();

        if ($userSubscribed === 1) {

            $this->attributes['userSubscribed'] = TRUE;
        
        } else {

            $this->attributes['userSubscribed'] = FALSE;
        }
    }

    public function setSubscriberCount(string $profile)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('subscribers');

        $this->attributes['subscriberCount'] = $this->builder
            ->where('profile', $profile)
            ->countAllResults();
    }

    public function setUploadCount(string $uploader)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('images');

        $this->attributes['uploadCount'] = $this->builder
            ->where('uploader', $uploader)
            ->countAllResults();
    }

    public function setProfileViews(string $profile)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('profile');

        $this->attributes['profileViews'] = $this->builder
            ->where('profile', $profile)
            ->countAllResults();
    }

    /**
     *  Custom __get Methods
     */
    public function getLastLogin(string $format = 'words')
    {
        if ($format === 'words') {

            return $this->attributes['lastLogin'] = get_date_words($this->attributes['lastLogin']);
        
        } elseif ($format === 'none') {

            return $this->attributes['lastLogin'];
        }
    }

    public function getAge(string $format = 'words')
    {
        if ($format === 'words' && $this->attributes['age'] !== NULL) {

            return $this->attributes['age'] = get_date_words($this->attributes['age']);
        
        } elseif ($format === 'none' && $this->attributes['birthday'] !== NULL) {

            return $this->attributes['age'];
        }
    }
}