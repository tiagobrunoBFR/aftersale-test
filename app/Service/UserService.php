<?php


namespace App\Service;


use App\Models\User;

class UserService
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store($request)
   {
       $user = $this->user->create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => $request->password,
       ]);

     return $user;
   }
}
