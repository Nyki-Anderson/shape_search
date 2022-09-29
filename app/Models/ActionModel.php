<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ActionModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'actions';
    protected $primaryKey = 'action';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $useSoftDelete = false;
    protected $allowedFields = [
        'action',
        'viewkey',
        'username',
        'modified',
    ];

    protected $builder;
    protected $imageModel;

    public function __construct () 
    {
        parent::__construct();

        $this->imageModel = new ImageModel();
    }

    public function updateModified(array $data)
    {
       $modified = Time::now('America/New_York', 'en_US');

       if ($data['modified_at'] === NULL) {

            $data['modified_at'] = $modified;
        
            return $data;
        }
    }

    public function insertAction(array $request)
    {
        $image = new \App\Entities\Image();

        $request = $this->updateModified($request);

        switch($request['action']) {

            case 'dislike':

                $data = [
                    'action'    => 0,
                    'username'  => session()->get('username'),
                    'viewkey'   => $request['viewkey'],
                    'modified_at'  => $request['modified_at'],
                ];

                $image->setUserLiked($request['viewkey']);

                if ($image->userLiked === FALSE) {
                    
                    $this->builder()
                        ->insert($data);
                
                } else {

                    $this->builder()
                        ->set($data)
                        ->where(['action' => 1, 'username' => $data['username'], 'viewkey' => $data['viewkey']])
                        ->replace();
                }

                unset($image->setUserLiked);

                break;

            case 'undislike':

                $this->builder()
                    ->where('action', 0)
                    ->delete();

                break;

            case 'like':

               $data = [
                    'action'    => 1,
                    'username'  => session()->get('username'),
                    'viewkey'   => $request['viewkey'],
                    'modified_at'  => $request['modified_at'],
                ];

                $image->setUserDisliked($request['viewkey']);

                if ($image->userDisliked === FALSE) {
                    
                    $this->builder()
                        ->insert($data);
                
                } else {

                    $this->builder()
                        ->set($data)
                        ->where(['action' => 0, 'username' => $data['username'], 'viewkey' => $data['viewkey']])
                        ->replace();
                }

                unset($image->userDisliked);

                break;

            case 'unlike':

                $this->builder()
                    ->where('action', 1)
                    ->delete();

                break;

            case 'view':

               $data = [
                    'action'    => 2,
                    'username'  => session()->get('username'),
                    'viewkey'   => $request['viewkey'],
                    'modified_at'  => $request['modified_at'],
                ];

                $image->setUserViewed($request['viewkey']);

                if ($image->userViewed == FALSE) {
                    
                    $this->builder()
                        ->insert($data);
                
                } else {

                    $this->builder()
                        ->set(['modified_at' => $data['modified_at']])
                        ->where(['action' => 2, 'username' => session()->get('username'),  'viewkey' => $data['viewkey']])
                        ->update();
                }

                unset($image->userViewed);

                break;

            case 'favorite':

               $data = [
                    'action'    => 3,
                    'username'  => session()->get('username'),
                    'viewkey'   => $request['viewkey'],
                    'modified_at'  => $request['modified_at'],
                ];

                $image->setUserFavorited($request['viewkey']);

                if ($image->userFavorited === FALSE) {
                    
                    $this->builder()
                        ->insert($data);
                }

                unset($image->userFavorited);

                break;

            case 'unfavorite':

                $this->builder()
                    ->where('action', 3)
                    ->delete();

                break;
            
            default:

                break;
        }

        return $this->getActions($request['viewkey']);
    }

    public function getActions(string $viewkey)
    {
        $data = [];

        $image = $this->imageModel->fillImageEntity($viewkey);
        $image->setDislikeCount($viewkey);
        $image->setLikeCount($viewkey);
        $image->setViewCount($viewkey);
        $image->setFavoriteCount($viewkey);

        $data = [
            'csrfName'  => csrf_token(),
            'csrfHash'  => csrf_hash(),
            'dislikes'  => $image->dislikeCount,
            'likes'     => $image->likeCount,
            'views'     => $image->viewCount,
            'favorites' => $image->favoriteCount,
        ];

        unset($image->dislikeCount);
        unset($image->likeCount);
        unset($image->viewCount);
        unset($image->favoriteCount);

        return json_encode($data);
    }

    public function getUserAction(array $where)
    {
        return $this->builder()
            ->where($where)
            ->get()
            ->getResultArray();
        
    }

}