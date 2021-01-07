<?php 

namespace App\Modules\Login\Controllers;

// memanggil file yang dibutuhkan
use App\Modules\Login\Models\LoginModel;
use App\Controllers\BaseLoginController;
use App\Libraries\Bcrypt;

class Login extends BaseLoginController
{
	public function __construct() {
        
 
 		$this->input = service('request'); // memangging input
        $this->viewPage='App\Modules\Login\Views\\'; // path view
        $this->validation =  \Config\Services::validation(); // form validation call
        $this->db=\Config\Database::connect(); // connect db
        $this->bcrypt= new Bcrypt();  // memanggil library becrypt
        $this->loginModel = new LoginModel(); // manggil class model
        $this->session = \Config\Services::session(); // call session

        $this->table="core.t_mtr_user";
    }
	public function index()
	{	
		isLogout();
		$data['title']="Login";
		
		return view($this->viewPage."index",$data);
	}

	public function actionLogin()
	{
		ajaxRequest();
		isLogout();

		$username= $this->input->getPost('username');
		$password= $this->input->getPost('password');

		
		$getUser=array();		

		//checking user juka field user tidak kosong
		if(!empty($username))
		{
			$getDataUser=$this->loginModel->selectData($this->table, " where username='{$username}' and  status=1")->getRow();
			$getUser=$getDataUser;
		}

		$checkUser[]=0;
		$checkPassword[]=0;
		$checkChapt[]=0;

		// check user
		if(count((array)$getUser)>0)
		{
			$checkPass = $this->bcrypt->check_password(strtoupper(md5($password)), $getUser->password);

			if(!$checkPass)
			{
				$checkPassword[]=1;				
			}
		}
		else
		{
			$checkUser[]=1;
		}

		// print_r(menuParent($getUser->user_group_id)); exit;



		if(array_sum($checkUser)>0 || empty($username))
		{
			$return=jsonApi(0,'Username tidak ditemukan');
		}
		else if(array_sum($checkPassword)>0)
		{
			$return=jsonApi(0,'Password salah');
		}
		else
		{

			// handling ketika buka 2 tab halaman login dan salah satu sudah login, (tidak perlu set ulang lagi session)
			if($this->session->get('isLogin')<>1)
			{
				$setSession =array(
					'username'=>$username,
					'groupId'=>$getUser->user_group_id,
					'getMenu'=>menuParent($getUser->user_group_id), // save data menu
					'getLogin'=>1
				);
				$this->session->set($setSession);
			}


			$return=jsonApi(1,'suksess');
		}

		echo $return;


	}

	public function logout()
	{
		$this->session->destroy();
		// return view("App\Modules\Login\Views\index");
		header("Location:".base_url()."/login"); // menggunakan fungsi php murni bukan bawaan ci
		exit();
			
	}

}
