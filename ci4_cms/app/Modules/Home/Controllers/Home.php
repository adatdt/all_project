<?php 

namespace App\Modules\Home\Controllers;

use App\Modules\Home\Models\HomeModel;
use App\Controllers\BaseController;

class Home extends BaseController
{
	public function __construct() {
 
        $this->viewPage='App\Modules\Home\Views';
        // Mendeklarasikan class ProductModel menggunakan $this->product
        $this->home = new HomeModel();
        /* Catatan:
        Apa yang ada di dalam function construct ini nantinya bisa digunakan
        pada function di dalam class Product 
        */
        	
        // $this->session = \Config\Services::session(); // call session
    }
	public function index()
	{
		// $db = \Config\Database::connect();
		// $this->connections[$homeModel] = $this->home;
	
		$data['content']=$this->viewPage."\index";
		$data['username']=$this->session->get('username');
		
		return view('template/page',$data);
	}

	//--------------------------------------------------------------------

}
