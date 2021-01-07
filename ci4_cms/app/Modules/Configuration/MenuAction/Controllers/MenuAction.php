<?php 

namespace App\Modules\Configuration\MenuAction\Controllers;

// memanggil file yang dibutuhkan
use App\Modules\Configuration\MenuAction\Models\MenuActionModel;
use App\Controllers\BaseController;

class MenuAction extends BaseController
{
	public function __construct() {
 
        $this->viewPage='App\Modules\Configuration\MenuAction\Views\\'; // path view        
       	$this->menuActionModel = new MenuActionModel(); // manggil class model
       	$this->table= 'core.t_mtr_menu_action';
    }
	public function index()
	{

		if ($this->request->isAJAX()) {
            $rows = $this->menuActionModel->getData();
            echo json_encode($rows);
            exit;
        }

		$data['content']=$this->viewPage."index";
		$data['title']="Aksi Menu";
		
		return view('template/page',$data);
	}

	public function add()
	{
		ajaxRequest();
		$data['title']="Add Action";
		return view($this->viewPage."add",$data);	
	}

	public function actionAdd()
	{
		$actionName=$this->input->getPost("actionName");

		$dataPost=[
					'actionName'=>$actionName,
				];

		// seting validasi form ci
		$this->validation->setRules([
		        'actionName' => [
		            'label'  => 'Nama Aksi',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ]		    ]
		);		


		$insertData=array(
			'action_name'=>$actionName,
			'created_on'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->get('username'),
			'status'=>1
		);

		$checkName=$this->menuActionModel->selectData("core.t_mtr_menu_action"," where upper(action_name)=upper('".$actionName."') and status <>'-5' ")->getResult();

		if($this->validation->run($dataPost)==false)
		{
			$return=jsonApi(0,$this->validation->listErrors());
		}
		else if(count((array)$checkName)>0)
		{
			$return=jsonApi(0," Nama Sudah Ada");
		}	
		else
		{

			$this->db->transBegin();

			$data=$this->menuActionModel->insertData($this->table, $insertData);

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
		}	

		echo $return ;

		$createdBy   = $this->session->get('username');
        $logUrl      = $this->viewPage."actionAdd";
        $logMethod   = 'ADD';
        $logParam    = json_encode(array($insertData));
        $logResponse = $return;

	    $this->log_activitytxt->createLog($createdBy, $logUrl, $logMethod, $logParam, $logResponse);    
		

	}

	public function edit($id)
	{
		ajaxRequest();
		$decodeId=decrypt($id);		

		$rows = $this->menuActionModel->selectData("core.t_mtr_menu_action"," where id={$decodeId} ")->getRow();

		$data['title']="Edit Aksi";
		$data['data']=$rows;
		$data['id']=$id;

		// print_r($data); exit;
		return view($this->viewPage."edit",$data);	
	}	

	public function actionEdit()
	{
		ajaxRequest();

		$actionName=$this->input->getPost("actionName");
		$decodeId=decrypt($this->input->getPost('idData'));

		$dataPost=[
					'actionName'=>$actionName,
					'idData'=>$decodeId,
				];

		// seting validasi form ci
		$this->validation->setRules([
		        'actionName' => [
		            'label'  => 'Nama Aksi',
		            'rules'  => 'required',
		            'errors' => ['required' => msgErr("required",'{field}')],
		       	],
		       	'idData' => [
		            'label'  => 'Id',
		            'rules'  => 'required',
		            'errors' => ['required' => msgErr("required",'{field}')],
		       	],		    
		    ]
		);		


		$updateData=array(
			'action_name'=>$actionName,
			'updated_on'=>date('Y-m-d H:i:s'),
			'updated_by'=>$this->session->get('username'),
		);

		$checkName = $this->menuActionModel->selectData($this->table," where upper(action_name)=upper('{$actionName}') and status<>'-5' and id<>{$decodeId} ")->getResult();

		if($this->validation->run($dataPost)==false)
		{
			$return=jsonApi(0,$this->validation->listErrors());
		}
		else if(count((array)$checkName)>0)
		{
			$return=jsonApi(0,"Nama sudah ada");	
		}
		else
		{

			$this->db->transBegin();

			$this->menuActionModel->updateData($this->table,$updateData,['id'=>$decodeId]);

			if ($this->db->transStatus() === FALSE)
			{
			    $this->db->transRollback();
			    $return=jsonApi(0,"Data gagal");
			}
			else
			{
			    $this->db->transCommit();
			    $return=jsonApi(1,"Berhasil Update Data");
			}			
		}

		echo $return;	

		$createdBy   = $this->session->get('username');
        $logUrl      = $this->viewPage."actionEdit";
        $logMethod   = 'EDIT';
        $logParam    = json_encode(array($updateData));
        $logResponse = $return;

	    $this->log_activitytxt->createLog($createdBy, $logUrl, $logMethod, $logParam, $logResponse);   		
	}	

	public function actionDelete($id)
	{
		$decodeId=decrypt($id);

		$checkId=$this->menuActionModel->selectData($this->table, " where id={$decodeId}")->getRow();

		$updateData=array(
			'status'=>'-5',
			'updated_on'=>date('Y-m-d H:i:s'),
			'updated_by'=>$this->session->get('username')
		);

		
		if(count((array)$checkId)<1)
		{
			$return=jsonApi(0,"Data tidak ada");
		}
		else
		{
			$this->db->transBegin();

			$this->menuActionModel->updateData($this->table,$updateData,['id'=>$decodeId]);

			if ($this->db->transStatus() === FALSE)
			{
			    $this->db->transRollback();
			    $return=jsonApi(0,"Data gagal");
			}
			else
			{
			    $this->db->transCommit();
			    $return=jsonApi(1,"Berhasil Update Data");
			}			
		}

		echo $return;	

		$createdBy   = $this->session->get('username');
        $logUrl      = $this->viewPage."actionEdit";
        $logMethod   = 'EDIT';
        $logParam    = json_encode(array($updateData));
        $logResponse = $return;

	    $this->log_activitytxt->createLog($createdBy, $logUrl, $logMethod, $logParam, $logResponse);   	
	}	

	function actionChangeStatus($param)
	{
		/* $paramDecode[0] : id
			$paramDecode[1] : status
		*/

		$decode=decrypt($param);

		$paramDecode=explode("|", $decode);
		$checkId=$this->menuActionModel->selectData($this->table, " where id={$paramDecode[0]}")->getRow();
		$status= $paramDecode[1]==1?0:1;

		$updateData=array(
			'status'=>$status,
			'updated_on'=>date('Y-m-d H:i:s'),
			'updated_by'=>$this->session->get('username')
		);

		
		if(count((array)$checkId)<1)
		{
			$return=jsonApi(0,"Data tidak ada");
		}
		else
		{
			$this->db->transBegin();

			$this->menuActionModel->updateData($this->table,$updateData,['id'=>$paramDecode[0]]);

			if ($this->db->transStatus() === FALSE)
			{
			    $this->db->transRollback();
			    $return=jsonApi(0,"Data gagal");
			}
			else
			{
			    $this->db->transCommit();
			    $return=jsonApi(1,"Berhasil Update Data");
			}			
		}

		echo $return;	

		$createdBy   = $this->session->get('username');
        $logUrl      = $this->viewPage."actionChangeStatus";
        $logMethod   = $paramDecode[1]==1?'DISABLED':'ENABLED';
        $logParam    = json_encode(array($updateData));
        $logResponse = $return;

	    $this->log_activitytxt->createLog($createdBy, $logUrl, $logMethod, $logParam, $logResponse); 

	}

}
