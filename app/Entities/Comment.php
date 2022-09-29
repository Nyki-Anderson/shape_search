<?php

namespace App\Entities;

use App\Models\CommentModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Comments extends Entity 
{
    protected $attributes = [
        'commentID'         => NULL,
        'commenter'         => NULL,
        'commentText'       => NULL,
        'commentCreated'    => NULL,
        'commentModified'   => NULL,
        'parentID'          => NULL,
        'viewkey'           => NULL,
        'avatar'            => NULL,
    ];

    protected $datamap = [
        'comment_id'        => 'commentID',
        'comment_text'      => 'commentText',
        'parent_id'         => 'parentID',
        'comment_created'   => 'commentCreated',
        'comment_modified'  => 'commentModified',
    ];

    protected $dates = ['created', 'modified'];

    protected $builder;
    protected $commentModel;
    protected $userModel;

    public function __construct (array $data = NULL)
    {
        parent::__construct($data);

        $this->commentModel = new CommentModel();
        $this->userModel = new UserModel();
    }

    /** 
     *  Custom __set Methods
     */
    public function setAvatar(string $commenter) 
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('users');

        $this->attributes['avatar'] = $this->builder
            ->select('profile_image')
            ->where('commenter', $commenter)
            ->get()
            ->getResult();
    }
}