<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ProfileModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'profile';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = FALSE;
    protected $returnType       = \App\Entities\User::class;
    protected $useSoftDelete    = FALSE;
    protected $allowedFields    = [
        'profile',
        'viewer',
        'modified_at',
    ];

    protected $userModel;

    public function __construct() 
    {
        parent::__construct(); 

        $this->userModel = new UserModel();
    }

    public function updateModified(array $data)
    {
       $modified = Time::now('America/New_York', 'en_US');

       if ($data['modified_at'] === NULL) {

            $data['modified_at'] = $modified;
        
            return $data;
        }
    }

    public function viewProfile(array $data)
    {
        $data = $this->updateModified($data);

        $viewedAlready = $this->builder()
            ->where(['profile' => $data['profile'], 'viewer' => $data['viewer']])
            ->countAllResults();

        if ($viewedAlready === 0) {

            $this->builder()
                ->insert($data);

        } elseif ($viewedAlready === 1) {

            $this->builder()
                ->set('modified_at', $data['modified_at'])
                ->where(['profile' => $data['profile'], 'viewer' => $data['viewer']])
                ->update();
        }

        return $this->getProfileViews($data['profile']);
    }

    public function getProfileViews(string $profile)
    {
        $data = [];

        $user = $this->userModel->fillUserEntity($profile);

        $data = [
            'csrfName'      => csrf_token(),
            'csrfHash'      => csrf_hash(),
            'viewCount'     => $user->profileViews,
        ];

        unset($user->profileViews);

        return json_encode($data);
    }

    public function getUserHistory(string $username)
    {
        $viewedProfiles = [];

        $profileList = $this->builder('profile')
            ->where(['viewer' => $username])
            ->orderBy('modified_at', 'DESC')
            ->get()
            ->getResult();

        if (! empty($profileList)) {

            foreach ($profileList as $viewed) {

                $viewedProfiles[$viewed->id] = $this->userModel->fillUserEntity($viewed->profile);
            }

            return $viewedProfiles;
        
        } else {

            return NULL;
        }
    }
}