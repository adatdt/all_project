<?php
namespace App\Controllers;
use App\Libraries\log_activitytxt;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Libraries\Aes;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url','nutech_helper']; // load helper
	protected $aes;

	protected $log_activitytxt;

	/**
	 * Constructor.
	 */

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:

        helper('nutech_helper');
        isLogin();
        
		// memanggil service dari codeignater
		

		$this->log_activitytxt= new log_activitytxt();  // memanggil library becrypt		
		$this->input = service('request'); // memangging input
		$this->session = \Config\Services::session();
		$this->validation =  \Config\Services::validation(); // form validation call
        $this->db=\Config\Database::connect(); // connect db
        $this->uri = new \CodeIgniter\HTTP\URI();
        $this->uri= service('uri');
	}

}
