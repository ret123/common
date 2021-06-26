<?php

namespace Microservices;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class UserService
{
    private $endpoint;

    public function __contruct()
    {
        $this->endpoint = env('USERS_ENDPOINT');
    }

    public function headers()
    {
        return [
            'Authorization' => request()->headers->get('Authorization'),

        ];
    }

    public function getUser(): User
    {
        $response = \Http::withHeaders($this->headers())->get("{$this->endpoint}/user")->json();
        return  new User($response);
    }

    public function isAdmin()
    {
        return  \Http::withHeaders($this->headers())->get("{$this->endpoint}/admin")->successful();
    }

    public function isInfluencer()
    {
        return  \Http::withHeaders($this->headers())->get("{$this->endpoint}/influencer")->successful();
    }

    public function allows($ability, $arguments)
    {
        return Gate::forUser($this->getUser())->authorize($ability, $arguments);
    }

    public function allUsers($page)
    {
        return Http::withHeaders($this->headers())->get("{$this->endpoint}/users?page={$page}")->json();
    }

    public function get($id): User
    {
        $data =  Http::withHeaders($this->headers())->get("{$this->endpoint}/users/{$id}")->json();
        return new User($data);
    }

    public function create($data): User
    {
        $data =  Http::withHeaders($this->headers())->post("{$this->endpoint}/users,$data")->json();
        return new User($data);
    }

    public function update($id, $data): User
    {
        $data =  Http::withHeaders($this->headers())->put("{$this->endpoint}/users/{$id},$data")->json();
        return new User($data);
    }

    public function delete($id)
    {
        return Http::withHeaders($this->headers())->delete("{$this->endpoint}/users/{$id}")->successful();
    }
}
