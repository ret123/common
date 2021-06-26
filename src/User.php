<?php

namespace Microservices;

class User
{

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $is_influencer;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->is_influencer = $data['is_influencer'] ?? 0;
    }




    public function isAdmin(): bool
    {
        return $this->is_influencer === 0;
    }

    public function isInfluencer(): bool
    {
        return $this->is_influencer ===  1;
    }


    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
