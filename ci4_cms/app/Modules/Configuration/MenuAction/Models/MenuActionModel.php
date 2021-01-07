<?php 

namespace App\Modules\Configuration\MenuAction\Models;
use CodeIgniter\Model;
 
class MenuActionModel extends Model
{
    public function __construct() {
 
        $this->db=\Config\Database::connect();
        $this->input = service('request');
        
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

        $where=" where status !='-5' ";

        $sql=$this->qry($where);

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

            $urlDelete ="action/action_delete/".encrypt($value->id);
            $urlChangeStatus ="action/action_change_status/".encrypt($value->id."|".$value->status);
            $urlEdit ="'action/edit/".encrypt($value->id)."'";

            $value->action="";
            
            $actionEdit ='<button onclick="showModal('.$urlEdit.')" class="btn btn-sm btn-warning btn-circle" title="Edit"><i class="fa fa-pencil"></i> Edit</button>';
            $actionDisable ='<button onclick="confirmAction('."'apakah anda yakin ingin non aktifkan data ini'".','."'".$urlChangeStatus."'".')" class="btn btn-sm btn-danger btn-circle" class="btn btn-sm btn-warning btn-circle" title="Disable"><i class="fa fa-ban"></i> Disable</button>';
            $actionEnable ='<button onclick="confirmAction('."'apakah anda yakin ingin aktifkan data ini'".','."'".$urlChangeStatus."'".')" class="btn btn-sm btn-success btn-circle" title="Enable"><i class="fa fa-check"></i> Enable</button>';      
            $actionDelete ='<button onclick="confirmAction('."'apakah anda yakin ingin menhapus data ini'".','."'".$urlDelete."'".')" class="btn btn-sm btn-danger btn-circle" title="Delete"><i class="fa fa-trash-o"></i> Delete</button>';
            

            if($value->status==1)
            {
                $value->action .=$actionEdit." ".$actionDisable;

                $value->status=successLabel("Aktif");
            }
            else
            {
                $value->action .=$actionEnable;
                $value->status=failedLabel("Non Aktif");
            }


            $value->action .=$actionDelete;


            $returnData[]=$value;
        }


        $return = array(
            'draw'           => $draw,
            'recordsTotal'   => $records_total,
            'recordsFiltered'=> $records_total,
            'data'           => $returnData
        );

        return $return;

    } 

    public function qry($where)
    {
        
        $sql=" select * from core.t_mtr_menu_action ".$where;

        return $sql;
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