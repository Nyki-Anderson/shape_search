<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\ImageModel;
use App\Models\CommentModel;
use App\Models\SubscribeModel;
use App\Models\ProfileModel;

class Image extends Entity
{
    protected $attributes = [
        'viewkey'           => NULL,
        'id'                => NULL,
        'uploader'          => NULL,
        'filename'          => NULL,
        'title'             => NULL,
        'tags'              => NULL,
        'albumName'         => NULL,
        'createdAt'         => NULL,
        'modifiedAt'        => NULL,
        'likeCount'         => NULL,
        'dislikeCount'      => NULL,
        'viewCount'         => NULL,
        'favoriteCount'     => NULL,
        'commentCount'      => NULL,
        'rating'            => NULL, 
        'userLiked'         => NULL,
        'userDisliked'      => NULL,
        'userViewed'        => NULL,
        'userFavorited'     => NULL,
        'userCommented'     => NULL,
        'userSubscribed'    => NULL,
        'action'            => NULL,
        'isUploader'        => NULL,
    ];

    protected $datamap = [
        'created_at'    => 'createdAt',
        'modified_at'   => 'modifiedAt',
        'album_name'    => 'albumName',
    ]; 

    protected $casts = [
        'likeCount'         => 'int',
        'dislikeCount'      => 'int',
        'viewCount'         => 'int',
        'favoriteCount'     => 'int',
        'commentCount'      => 'int',
        'rating'            => 'string',
        'userDisliked'      => 'bool',
        'userLiked'         => 'bool',
        'userViewed'        => 'bool',
        'userFavorited'     => 'bool',
    ];

    protected $builder;

    public function __construct (array $data = NULL)
    {
        parent::__construct($data);
    }

    /** 
     *  Custom __set Methods
     */
    public function setDislikeCount(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'action'    => 0,
        ];

        $this->attributes['dislikeCount'] = $this->builder
            ->where($where)
            ->countAllResults();
    }

    public function setLikeCount(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'action'    => 1,
        ];

        $this->attributes['likeCount'] = $this->builder
            ->where($where)
            ->countAllResults();
    }

    public function setViewCount(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'action'    => 2,
        ];

        $this->attributes['viewCount'] = $this->builder
            ->where($where)
            ->countAllResults();
    }

    public function setFavoriteCount(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'action'    => 3,
        ];

        $this->attributes['favoriteCount'] = $this->builder
            ->where($where)
            ->countAllResults();
    }

    public function setCommentCount(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('comments');

        $this->attributes['commentCount'] = $this->builder
            ->where('viewkey', $viewkey)
            ->countAllResults();
    }

    public function setRating(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        helper('arithmetic');

        $whereDislike = $whereLike = [];

        $whereDislike = [
            'viewkey'   => $viewkey,
            'action'    => 0,
        ];

        $dislikes = $this->builder
            ->where($whereDislike)
            ->countAllResults();

        $whereLike = [
            'viewkey'   => $viewkey,
            'action'    => 1,
        ];

        $likes = $this->builder
            ->where($whereLike)
            ->countAllResults();

        $this->attributes['rating'] = get_percentage(($likes + $dislikes), $likes, 2);
    }

    public function setUserDisliked(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'username'  => session()->get('username'),
            'action'    => 0,
        ];

        $userDisliked = $this->builder
            ->where($where)
            ->countAllResults();

        if ($userDisliked === 1) {

            $this->attributes['userDisliked'] = TRUE;

        
        } else {

            $this->attributes['userDisliked'] = FALSE;
        }
    }

    public function setUserLiked(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'username'  => session()->get('username'),
            'action'    => 1,
        ];

        $userLiked = $this->builder
            ->where($where)
            ->countAllResults();

        if ($userLiked === 1) {

            $this->attributes['userLiked'] = TRUE;

        
        } else {

            $this->attributes['userLiked'] = FALSE;
        }
    }

    public function setUserViewed(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'username'  => session()->get('username'),
            'action'    => 2,
        ];

        $userViewed = $this->builder
            ->where($where)
            ->countAllResults();

        if ($userViewed === 1) {

            $this->attributes['userViewed'] = TRUE;

        
        } else {

            $this->attributes['userViewed'] = FALSE;
        }
    }

    public function setUserFavorited(string $viewkey)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('actions');

        $where = [];

        $where = [
            'viewkey'   => $viewkey,
            'username'  => session()->get('username'),
            'action'    => 3,
        ];

        $userFavorited = $this->builder
            ->where($where)
            ->countAllResults();

        if ($userFavorited === 1) {

            $this->attributes['userFavorited'] = TRUE;

        
        } else {

            $this->attributes['userFavorited'] = FALSE;
        }
    }

    public function setUserCommented(string $subscriber)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('comments');

        $userCommented = $this->builder
            ->where('commenter')
            ->countAllResults();

        if ($userCommented === 1) {

            $this->attributes['userCommented'] = TRUE;
        
        } else {

            $this->attributes['userCommented'] = FALSE;
        }

    }

    public function setUserSubscribed(string $uploader)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('subscribers');

        $where = [];

        $where = [
            'profile'   => $uploader,
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

    public function setIsUploader(string $viewkey)
    {   
        $db = \Config\Database::connect();
        $this->builder = $db->table('images');

        $image = $this->builder
            ->where(['viewkey' => $viewkey])
            ->get()
            ->getRow();

        if ($image->uploader === session()->get('username')) {

            $this->attributes['isUploader'] = TRUE;
        
        } else {

            $this->attributes['isUploader'] = FALSE;
        }
    }

    public function setAlbumName(string $viewkey, string $owner)
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('albums');

        $albumList = $this->builder
            ->where('owner', $owner)
            ->get()
            ->getResult();

        if (! empty($albumList)) {
            foreach ($albumList as $album) {

                $viewkeyList = explode(",", $album->viewkeys);

                if (in_array($viewkey, $viewkeyList, TRUE)) {

                    $this->attributes['albumName'] = $album->album_name;
                }
            }
        } else {

            $this->attributes['albumName'] = 'None';
        }
    }

    /**
     *  Custom __get Methods
     */

    public function getDislikeCount(string $format = 'words')
    {
        if ($format === 'words') {

            return get_num_words($this->attributes[
            'dislikeCount']);
        
        } else {

            return $this->attributes['dislikeCount'];
        }

    }

    public function getLikeCount(string $format = 'words')
    {
        if ($format === 'words') {

            return get_num_words($this->attributes[
            'likeCount']);
        
        } elseif ($format === 'none') {

            return $this->attributes['likeCount'];
        }

    }

    public function getViewCount(string $format = 'words')
    {
        if ($format === 'words') {

            return get_num_words($this->attributes[
            'viewCount']);
        
        } elseif ($format === 'none') {

            return $this->attributes['viewCount'];
        }

    }

    public function getFavoriteCount(string $format = 'words')
    {
        if ($format === 'words') {

            return get_num_words($this->attributes[
            'favoriteCount']);
        
        } else {

            return $this->attributes['favoriteCount'];
        }

    }

    public function getCommentCount(string $format = 'words')
    {
        if ($format === 'words') {

            return get_num_words($this->attributes[
            'commentCount']);
        
        } elseif ($format === 'none') {

            return $this->attributes['commentCount'];
        }

    }

    public function getModifiedAt(string $format = 'words')
    {
        if ($format === 'words') {

            return $this->attributes['modifiedAt'] = get_date_words($this->attributes['modifiedAt']);
        
        } elseif ($format === 'none') {

            return $this->attributes['modifiedAt'];
        }
    }

    public function getCreatedAt(string $format = 'words')
    {
        if ($format === 'words') {

            return $this->attributes['createdAt'] = get_date_words($this->attributes['createdAt']);
        
        } else {

            return $this->attributes['createdAt'];
        }
    }

}   