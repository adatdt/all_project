<?php 

namespace App\Modules\Home\Models;
 
use CodeIgniter\Model;
 
class HomeModel extends Model
{
     
    public function getProduct()
    {
        $builder = $this->db->table('app.t_mtr_product');
        $builder->select('*');
        return $builder->get();
    }
 
   
}