<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'users';
    protected $allowedFields = ['user_name', 'user_email', 'user_password', 'user_created_at'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        $data['data']['user_created_at'] = date('Y-m-d H:i:s');

        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['user_password']))
            $data['data']['user_password'] = password_hash($data['data']['user_password'], PASSWORD_DEFAULT);

        return $data;
    }
    
    // RECOVERY PASSWORD 
    static function recoverPassword(array $data)
    {
        return true;
        
    }
}
