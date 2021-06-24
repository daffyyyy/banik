<?php

namespace App\Models;

use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'logs';
    protected $allowedFields = ['user_id', 'action', 'ip', 'timestamp'];
    protected $beforeInsert;
    protected $beforeUpdate;

    static function addLog(array $data)
    {
        $logs = new LogsModel();
        // Log data
        if (empty($data['action'])) $data['action'] = 'Nieznana akcja';
        $data['user_id'] = session()->get('user_id');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        // Insert log to db
        $logs->insert($data);
    }
}
