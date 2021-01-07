<?php 

namespace App\Modules\Configuration\User\Controllers;

// memanggil file yang dibutuhkan
use App\Modules\Configuration\User\Models\UserModel;
use App\Controllers\BaseController;

class User extends BaseController
{
	public function __construct() {
 
 		$this->input = service('request'); // memangging input
        $this->viewPage='App\Modules\Configuration\User\Views\\'; // path view
        $this->validation =  \Config\Services::validation(); // form validation call
        $this->db=\Config\Database::connect(); // connect db
        
        $this->userModel = new UserModel(); // manggil class model
    }
	public function index()
	{

		if ($this->request->isAJAX()) {
            $rows = $this->userModel->getData();
            echo json_encode($rows);
            exit;
        }

		$data['content']=$this->viewPage."index";
		$data['title']="User";
		
		return view('template/page',$data);
	}

	public function add()
	{
		ajaxRequest();

		$data['title']="Add User";

		return view($this->viewPage."add",$data);	
	}

	public function actionAdd()
	{
		$username=$this->input->getPost("username");
		$firstName=$this->input->getPost("firstName");
		$lastName=$this->input->getPost("lastName");
		$email=$this->input->getPost("email");
		$password=$this->input->getPost("password");

		$dataPost=[
					'username'=>$username,
					'firstName'=>$firstName,
					'lastName'=>$lastName,
					'email'=>$email,
					'password'=>$password
				];


		// seting validasi form ci
		$this->validation->setRules([
		        'username' => [
		            'label'  => 'Username',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],
		        'password' => [
		        	'label'  => 'Password',
		            'rules'  => 'required|min_length[10]',
		            'errors' => [
		                'min_length' => msgErr("min",'{field}')
		            ]
		        ],
		       	'firstName' => [
		            'label'  => 'Nama Depan',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],
		       	'lastName' => [
		            'label'  => 'Nama Belakang',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],
		       	'email' => [
		            'label'  => 'Email',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],		        		        
		    ]
		);		

		if($this->validation->run($dataPost)==false)
		{
			$return=jsonApi(0,$this->validation->listErrors());
		}	
		else
		{
			$return=jsonApi(1,'suksess');
		}	

		echo $return ;

	}

	public function edit($id)
	{
		ajaxRequest();

		$decodeId=decrypt($id);

		$rows = $this->userModel->selectData("core.t_mtr_user"," where id={$decodeId} ")->getRow();

		$data['title']="Edit User";
		$data['data']=$rows;
		$data['id']=$id;

		return view($this->viewPage."edit",$data);	
	}	

	public function actionEdit()
	{
		ajaxRequest();


		$decodeId=decrypt($this->input->getPost('idData'));
		$firstName=$this->input->getPost("firstName");
		$lastName=$this->input->getPost("lastName");
		$email=$this->input->getPost("email");

		$dataPost=[
			'id'=>$decodeId,
			'firstName'=>$firstName,
			'lastName'=>$lastName,
			'email'=>$email
		];

		$data=[
			'first_name'=>$firstName,
			'last_name'=>$lastName,
			'email'=>$email,
			'updated_on'=>date("Y-m-d H:i:s"),
			'updated_by'=>'admin'];

		// seting validasi form ci
		$this->validation->setRules([
		        'id' => [
		            'label'  => 'Id',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],
		       	'firstName' => [
		            'label'  => 'Nama Depan',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],
		       	'lastName' => [
		            'label'  => 'Nama Belakang',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],
		       	'email' => [
		            'label'  => 'Email',
		            'rules'  => 'required',
		            'errors' => [
		                'required' => msgErr("required",'{field}')
		            ]
		        ],		        		        
		    ]
		);				
	
		$rows = $this->userModel->selectData("core.t_mtr_user"," where id={$decodeId} ")->getRow();

		if($this->validation->run($dataPost)==false)
		{
			$return=jsonApi(0,$this->validation->listErrors());
		}
		else if(count((array)$rows)<1)
		{
			$return=jsonApi(0,"Data tidak di temukan");	
		}
		else
		{

			$this->db->transBegin();

			$this->userModel->updateData("core.t_mtr_user",$data,['id'=>$decodeId]);

			if ($this->db->transStatus() === FALSE)
			{
			    $this->db->transRollback();
			    $return=jsonApi(0,"Data gagal");
			}
			else
			{
			    $this->db->transCommit();
			    $return=jsonApi(1,"Berhasil Simpan Data");
			}			
		}

		echo $return;	
	}		

}
