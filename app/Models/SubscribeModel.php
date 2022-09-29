<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class SubscribeModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'subscribers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDelete = false;
    protected $allowedFields = [
        'subscriber',
        'profile',
        'modified_at'
    ];

    protected $builder;
    protected $subscribeModel;

    public function __construct()
    {
        parent::__construct();
    }

    public function updateModified(array $data)
    {
       $modified = Time::now('America/New_York', 'en_US');

       if ($data['modified_at'] === NULL) {

            $data['modified_at'] = $modified;
        
            return $data;
        }
    }

    public function insertSubscriber($request)
    {
        $user = new \App\Entities\User();
        $data = [];

        $request = $this->updateModified($request);

        $data = [
            'subscriber'    => session()->get('username'),
            'profile'  => $request['user_profile'],
            'modified_at'      => $request['modified_at'],
        ];

        switch($request['action']) {

            case 'subscribe':

                $user->setUserSubscribed($request['user_profile']);

                if ($user->userSubscribed === FALSE && ($request['user_profile'] !== session()->get('username'))) {
                    
                    $this->builder()
                        ->insert($data);
                
                } elseif ($request['user_profile'] !== session()->get('username')) {

                    $this->builder()
                        ->where('subscriber', $subscriber)
                        ->update($data);
                }

                unset($user->userSubscribed);

                break;

            case 'unsubscribe':

                $where = [
                    'subscriber'    => session()->get('username'),
                    'profile'       => $request['user_profile'],
                ];

                $this->builder()
                    ->where($where)
                    ->delete();

                break;
        }
        $data = [
            'csrfName'  => csrf_token(),
            'csrfHash'  => csrf_hash(),
        ];

        return json_encode($data);
    }

    public function getSubscriptionList(array $where)
    {
        return $this->builder()
            ->select('subscriber')
            ->where($where)
            ->get()
            ->getResultArray();
    }
}