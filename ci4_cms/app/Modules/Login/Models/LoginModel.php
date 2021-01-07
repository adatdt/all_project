<?php 

namespace App\Modules\Login\Models;
use CodeIgniter\Model;
 
class LoginModel extends Model
{
    public function __construct() {
 
        $this->db=\Config\Database::connect();
        $this->input = service('request');
        
    }    

    public function insertData($table,$data)
    {
        $this->db->table($table)->insert($data);
    }

    public function updateData($table, $data, $where)
    {

        $this->db->table($table)->update($data, $where);
    }

    public function selectData($table,$where="")
    {
        $sql="select * from {$table} {$where}";

        // die($sql);
        return $result=$this->db->query($sql);

    }
    public function deleteData($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }    
}