<?php 

namespace App\Modules\Configuration\User\Models;
use CodeIgniter\Model;
 
class UserModel extends Model
{
    public function __construct() {
 
        $this->db=\Config\Database::connect();
        $this->input = service('request');
        
    }    
 
    public function getData_()
    {
        $sql= " select * from core.t_mtr_user ";
        $query=$this->db->query($sql);
        $result=$query->getResult();

        print_r($result); exit;
    } 

    public function getData()
    {        

        $start        = $this->input->getPost('start');
        $length       = $this->input->getPost('length');
        $draw         = $this->input->getPost('draw');
        $search       = $this->input->getPost('search');
        $order        = $this->input->getPost('order');
        $order_column = $order[0]['column'];
        $order_dir = strtoupper($order[0]['dir']);
        $iLike        = trim(strtoupper($search['value']));

        $field = array(
            0=>'id',           
        );        

        $order_column = $field[$order_column];

        $sql=" select * from core.t_mtr_user ";

        $result=$this->db->query($sql)->getResult();


        $records_total = count((array)$result);
        $sql .= " ORDER BY ".$order_column." {$order_dir}";

        // return $result;

        if($length != -1){
            $sql .=" LIMIT {$length} OFFSET {$start}";          
        }

        $rowsData = $this->db->query($sql)->getResult();

        $returnData=array();
        foreach ($rowsData as $key => $value) {
            
            $value->action="";

            $urlEdit ="'user/edit/".encrypt($value->id)."'";

            $actionEdit ='<button onclick="showModal('.$urlEdit.')" class="btn btn-sm btn-warning btn-circle" title="Edit"><i class="fa fa-pencil"></i> Edit</button>';
            $actionDelete ='<button onclick="showModal(user/add)" class="btn btn-sm btn-danger btn-circle" title="Delete"><i class="fa fa-trash-o"></i> Delete</button>';
            $actionEnable ='<button onclick="showModal(user/add)" class="btn btn-sm btn-danger btn-circle" title="Enable"><i class="fa fa-ban"></i> Enable</button>';
            $actionDisable ='<button onclick="showModal(user/add)" class="btn btn-sm btn-warning btn-circle" title="Disable"><i class="fa fa-check"></i> Disable</button>';

            $value->action .=$actionEdit." ".$actionDelete." ".$actionEnable;


            $returnData[]=$value;
        }


        $return = array(
            'draw'           => $draw,
            'recordsTotal'   => $records_total,
            'recordsFiltered'=> $records_total,
            'data'           => $returnData
        );

        return $return;

        // return "ini adalah model user";
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
        return $result=$this->db->query(" select * from {$table} {$where} ");

    }
    public function deleteData($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }    
}