<?php 

namespace App\Modules\Configuration\Privilege\Models;
use CodeIgniter\Model;
 
class PrivilegeModel extends Model
{
    public function __construct() {
 
        $this->db=\Config\Database::connect();
        $this->input = service('request');
        
    }    

    public function getData($groupId="")
    {
        if(!empty($groupId))
        {
            $userGroup=decrypt($groupId);
        }
        else
        {
            $userGroup=decrypt($this->input->getGet('userGroup'));
        }

        // exit;

        $where =" where mw.status=1 ";
        
        if (!empty($userGroup))
        {
            $where .= " and ug.id={$userGroup}  ";
        } 

        // get menu
        $getMenu = $this->db->query(' SELECT * from core.t_mtr_menu_web where status=1 order by parent_id, "order" asc ' )->getResult();

        $getAllAction= $this->db->query(" SELECT ma.action_name,mdw.menu_id, mdw.id as menu_detail_id from core.t_mtr_menu_detail_web  mdw
                                        join core.t_mtr_menu_action ma on mdw.action_id=ma.id and ma.status=1
                                        order by action_name desc " )->getResult();

        $getChecked= $this->db->query(" SELECT ma.action_name, mw.id, mwd.action_id , pv.status, ug.name from core.t_mtr_menu_web mw
                                        left join core.t_mtr_privilege_web pv on mw.id=pv.menu_id 
                                        left join core.t_mtr_user_group ug on pv.user_group_id=ug.id 
                                        left join core.t_mtr_menu_detail_web mwd on pv.menu_detail_id=mwd.id
                                        left join core.t_mtr_menu_action ma on mwd.action_id=ma.id 
                                        $where
                                    ")->getResult();

        // die($getChecked);

        $data=array();
        foreach ($getMenu as $key => $value) {
            
            $dataTemp['id']=(int)$value->id;
            $dataTemp['pid']=(int)$value->parent_id;
            $dataTemp['name']=$value->name;
            $dataTemp['dataEmpty']="";
            $dataTemp["checkAction"]='<div class="checkbox">
                            <label>
                                <input type="checkbox" value="'.encrypt($value->id).'" name="check" class="myCheck"  onClick=myData.confirmAction() >
                                <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                            </label>
                        </div>';


            $action="";       

            foreach ($getAllAction as $keyAction => $valueAction)
            {
                if($valueAction->menu_id==$value->id)
                {

                    $checked="";

                    // checking di mana saja dia dapat privilege
                    foreach ($getChecked as $keyChecked => $valueChecked) {
                        if($valueChecked->action_name==$valueAction->action_name &&  $valueChecked->status==1 && $valueChecked->id==$valueAction->menu_id)
                        {
                            $checked=" checked  {$valueChecked->name} ";
                        }
                    }    

                    $action .= " ".$valueAction->action_name.' : <label class="switch">
                                        <input type="checkbox" id="togBtn" '.$checked.' onClick=myData.editData("'.encrypt($valueAction->menu_detail_id).'")>
                                        <div class="slider round">
                                            <span class="on">ON</span>
                                            <span class="off">OFF</span>
                                        </div>
                                    </label>  ';
                }
            }

            $dataTemp['action']=$action;

            $data[]=$dataTemp;
        }

        return $data;
    }     


    public function getData_backup()
    {
        $userGroup=decrypt($this->input->getGet('userGroup'));

        $where =" where mw.status=1 ";
        
        if (!empty($userGroup))
        {
            $where .= " and ug.id={$userGroup}  ";
        } 

        $sql= " 
                    SELECT pv.status as status_privilege, ma.action_name, mw.* from core.t_mtr_menu_web mw
                    left join core.t_mtr_privilege_web pv on mw.id=pv.menu_id 
                    left join core.t_mtr_user_group ug on pv.user_group_id=ug.id 
                    left join core.t_mtr_menu_detail_web mwd on pv.menu_detail_id=mwd.id
                    left join core.t_mtr_menu_action ma on mwd.action_id=ma.id
                    {$where}
                ";

        // $sql= " 
        //         SELECT mw.* from core.t_mtr_menu_web a 
        //         left join(
        //             SELECT pv.status as status_privilege, ma.action_name, mw.* from core.t_mtr_menu_web mw
        //             left join core.t_mtr_privilege_web pv on mw.id=pv.menu_id 
        //             left join core.t_mtr_user_group ug on pv.user_group_id=ug.id 
        //             left join core.t_mtr_menu_detail_web mwd on pv.menu_detail_id=mwd.id
        //             left join core.t_mtr_menu_action ma on mwd.action_id=ma.id
        //             {$where}
        //             ) mw on a.id=mw.id

        //         ";                

         // die($sql);           

        $query=$this->db->query($sql);
        $result=$query->getResult();

        $arrayUnique=array();
        $data=array();
        foreach ($result as $key => $value) {
                     
            $dataTempt['id']=(int)$value->id;
            $dataTempt['pid']=(int)$value->parent_id;
            $dataTempt['name']=$value->name;
            $arrayUnique[]=$dataTempt;

        }

        // print_r(array_unique($arrayUnique,SORT_REGULAR)); exit;

        foreach(array_unique($arrayUnique,SORT_REGULAR) as $key=>$value)
        {
            $actionName="";
            $value["checkAction"]='<div class="checkbox">
                            <label>
                                <input type="checkbox" value="'.encrypt($value['id']).'" name="check" class="myCheck"  >
                                <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                            </label>
                        </div>';


            foreach ($result as $keyResult => $valueResult) {
                                
                if((int)$valueResult->id==$value['id'])
                {
                    $valueResult->status_privilege==1?$checked="checked":$checked="";   
                    $actionName .=$valueResult->action_name.'<label class="switch">
                                        <input type="checkbox" id="togBtn" '.$checked.' >
                                        <div class="slider round">
                                            <span class="on">ON</span>
                                            <span class="off">OFF</span>
                                        </div>
                                    </label> ';
                }   

                $value["action"]=$actionName;     
            }

            $data[]=$value;
        }


        return $data; 
    }     


    public function getAction($id)
    {
        return $this->selectData("core.t_mtr_privilege_web"," where menu_id={$id} and user_group_id=1 ")->getResult();
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