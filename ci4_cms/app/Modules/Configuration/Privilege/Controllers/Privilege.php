<?php 

namespace App\Modules\Configuration\Privilege\Controllers;

// memanggil file yang dibutuhkan
use App\Modules\Configuration\Privilege\Models\PrivilegeModel;
use App\Controllers\BaseController;

class Privilege extends BaseController
{
	public function __construct() {
 
 		// $this->input = service('request'); // memangging input
   //      $this->validation =  \Config\Services::validation(); // form validation call
   //      $this->db=\Config\Database::connect(); // connect db
        
        $this->viewPage='App\Modules\Configuration\Privilege\Views\\'; // path view
        $this->privilegeModel = new PrivilegeModel(); // manggil class model
    }
	public function index()
	{

		if ($this->request->isAJAX()) {
            $rows = $this->privilegeModel->getData();
            // print_r(menuParent()); exit;
                        
            echo json_encode($rows);
            exit;		
        }

        $group=$this->privilegeModel->selectData("core.t_mtr_user_group", "where status=1 order by name asc")->getResult();


        $dataGroup[""]="Pilih";
        foreach ($group as $key => $value) {
        	$dataGroup[encrypt($value->id)]=strtoupper($value->name);
        }

		$data['content']=$this->viewPage."index";
		$data['group']=$dataGroup;
		$data['title']="Privilege";
		
		return view('template/page',$data);
	}


	public function edit()
	{
		// id parameter di sini gak di pake

		ajaxRequest();
		$decodeMenuId=decrypt($this->input->getPost('id'));
		$decodeGroupId=decrypt($this->input->getPost('userGroup'));

		if(empty($decodeMenuId) or empty($decodeGroupId))
		{
			echo jsonApi(0,"gagal Simpan Data");
			exit;
		}

		$checkPrivilege=$this->privilegeModel->selectData("core.t_mtr_privilege_web", " where user_group_id={$decodeGroupId} and menu_detail_id={$decodeMenuId} ")->getRow();

		if(count((array)$checkPrivilege)>1)
		{
			$data =$this->actionEdit($checkPrivilege->id, $checkPrivilege->status, $decodeGroupId);
			// $data="hai";
			
		}
		else
		{
			$data = $this->actionAdd($decodeMenuId, $decodeGroupId);
			
		}

	}	

	public function actionEdit($id, $status, $userGroup)
	{

			$data=array(
					"status"=>$status=="1"?"0":"1",
					"updated_on"=>date("Y-m-d H:i:s"),
					"updated_by"=>"admin"
			);

			$this->db->transBegin();

			$this->privilegeModel->updateData("core.t_mtr_privilege_web",$data,['id'=>$id]);
			$data=$this->privilegeModel->getData(encrypt($userGroup));

			if ($this->db->transStatus() === FALSE)
			{
			    $this->db->transRollback();
			    $return=jsonApi(0,"Data gagal");
			}
			else
			{
			    $this->db->transCommit();
			    $return=jsonApi(1,"Berhasil Simpan Data", $data);
			}			

			echo $return;

	        // $createdBy   = "admin";
	        // $logUrl      = 'transaction/extend_ticket/action_add_passanger';
	        // $logMethod   = 'ADD';
	        // $logParam    = json_encode(array());
	        // $logResponse = $return;

	        // $this->log_activitytxt->createLog($createdBy, $logUrl, $logMethod, $logParam, $logResponse);     			
	}


	public function actionAdd($menuDetailId, $userGroup)
	{

		$checkMenuDetail=$this->privilegeModel->selectData("core.t_mtr_menu_detail_web", " where id={$menuDetailId} ")->getRow();

			$data=array(
					"user_group_id"=>$userGroup,
					"menu_id"=>$checkMenuDetail->menu_id,
					"menu_detail_id"=>$menuDetailId,
					"status"=>1,
					"created_on"=>date("Y-m-d H:i:s"),
					"created_by"=>"admin"
			);

			$this->db->transBegin();

			// $this->privilegeModel->updateData("core.t_mtr_privilege_web",$data,['id'=>$decodeId]);
			$data=$this->privilegeModel->getData(encrypt($userGroup));

			if ($this->db->transStatus() === FALSE)
			{
			    $this->db->transRollback();
			    $return=jsonApi(0,"Data gagal");
			}
			else
			{
			    $this->db->transCommit();
			    $return=jsonApi(1,"Berhasil Simpan Data",$data);
			}

			echo $return;			

	}




}
