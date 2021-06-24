<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules
{

  public function validateUser(string $str, string $fields, array $data){
      
    $model = new UserModel();
    $user = $model->where('user_email', $data['user_email'])
                  ->first();
                  
    if(!$user)
      return false;
    return password_verify($data['user_password'], $user['user_password']);
  }
}