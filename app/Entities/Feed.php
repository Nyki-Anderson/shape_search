<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\ImageModel;
use App\Models\UserModel;
use App\Models\ActionModel;
use App\Models\SubscribeModel;
use App\Models\CommentModel;

use CodeIgniter\I18n\Time;

class Feed extends Entity
{
    protected $attributes = [
        'feed' => NULL,
    ];

    protected $casts = [
        'feed' => 'array',
    ];

    protected $builder;
    protected $imageModel;
    protected $userModel;
    protected $actionModel;
    protected $subscribeModel;
    protected $commentModel;

    public function __construct (array $data = null)
    {
        parent::__construct($data);

        $this->imageModel = new ImageModel();
        $this->userModel = new UserModel();
        $this->actionModel = new ActionModel();
        $this->subscribeModel = new SubscribeModel();
        $this->commentModel = new CommentModel();
    }

     /** 
     *  Custom __set Methods
     */
    public function setFeed(string $member)
    {
        $subscribers = $this->subscribeModel->getSubscriptionList(['profile' => $member]);

        $i=0;

        if (! empty($subscribers)) {
            foreach ($subscribers as $subscriber) {

                $this->attributes['feed'][$i] = [                      
                    'subscribedTo'      => $this->subscribeModel->getSubscriptionList(['subscriber' => $subscriber]),
                    'uploaded'          => $this->imageModel->getImage(['uploader' => $subscriber]),
                    'disliked'          => $this->actionModel->getUserAction(['username' => $subscriber, 'action' => 0]),
                    'liked'             => $this->actionModel->getUserAction(['username' => $subscriber, 'action' => 1]),
                    'viewed'            => $this->actionModel->getUserAction(['username' => $subscriber, 'action' => 2]),
                    'favorited'         => $this->actionModel->getUserAction(['username' => $subscriber, 'action' => 3]),
                    //'commented'         => $this->commentModel->getUserComments(['commenter', $subscriber]),
                ];

                $i++;
            }
        }

        $this->attributes['feed'][$member] = [
            'subscribedTo'      => $this->subscribeModel->getSubscriptionList(['subscriber' => $member]),
            'uploaded'          => $this->imageModel->getImage(['uploader' => $member]),
            'disliked'          => $this->actionModel->getUserAction(['username' => $member, 'action' => 0]),
            'liked'             => $this->actionModel->getUserAction(['username' => $member, 'action' => 1]),
            'viewed'            => $this->actionModel->getUserAction(['username' => $member, 'action' => 2]),
            'favorited'         => $this->actionModel->getUserAction(['username' => $member, 'action' => 3]),
            //'commented'         => $this->getUserComments(['commenter' => $member]),
        ];


    }
}