<?php 

function successLabel($text)
{
  return "<span class='label label-success'>" . $text . "<span>";
}

function failedLabel($text)
{
  return "<span class='label label-danger'>" . $text . "<span>";
}

function warningLabel($text)
{
  return "<span class='label label-warning'>" . $text . "<span>";
}


function jsonApi($code, $message, $data = '')
{
    if($data == '') {
    	$array = array
    	(
        	'code'  => $code,
        	'message' => $message
      	);
    }
    else
    {
     	$array = array
     	(
        	'code'  => $code,
        	'message' => $message,
        	'data'   => $data
      	);
    }

    return json_encode($array);
	}


if (!function_exists('jsonApi')) {
 	function jsonApi($code, $message, $data = '')
	{
	    if($data == '') {
	    	$array = array
	    	(
	        	'code'  => $code,
	        	'message' => $message
	      	);
	    }
	    else
	    {
	     	$array = array
	     	(
	        	'code'  => $code,
	        	'message' => $message,
	        	'data'   => $data
	      	);
	    }

	    return json_encode($array);
  	}
}


if (!function_exists('ajaxRequest')) {
 	function ajaxRequest()
	{
		$request = service('request'); // memanggi request
		if(!$request->isAJAX())
		{
			echo "error";
			exit;
		}
  	}
}


if (!function_exists('checkAccess')) {
 	function checkAccess()
	{
		$request = service('request'); // memanggi request
		if(!$request->isAJAX())
		{
			echo "error";
			exit;
		}
  	}
}

$key="nutech2020encrypturlCode";

if (!function_exists('encrypt')) {

	function encrypt($string)
	{
		$encrypt_method = "AES-256-CBC";
	    $secret_key = 'nutechasdp2020';
	    $secret_iv = 'nutechIntegras1';
	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;

	}

}

if (!function_exists('decrypt')) { 

	function decrypt($string)
	{
		$encrypt_method = "AES-256-CBC";
	    $secret_key = 'nutechasdp2020';
	    $secret_iv = 'nutechIntegras1';

	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;

	}
}

if (!function_exists('msgErr')) { 

	function msgErr($string,$param="")
	{
		$return="";

		if($string=="required")
		{
			$return=" {$param} tidak boleh kosong ";
		}

		if($string=="min")
		{
			$return=" Minimal {$param} Karakter";
		}		

		if($string=="max")
		{
			$return=" Maximal {$param} Karakter";
		}				

		if($string=="numeric")
		{
			$return="{$param} Harus angka";
		}						


        return $return;

	}
}


if (!function_exists('menuParent')) { 

	function menuParent($userGroupId="")
	{
				
		$db=\Config\Database::connect();
		$getParent=$db->query(" 
								SELECT 
									m.id, 
									m.name, 
									m.icon , 
									m.slug 
								from 
									core.t_mtr_menu_web m
									join core.t_mtr_menu_detail_web md on m.id=md.menu_id and md.status=1
									join core.t_mtr_menu_action ma on md.action_id=ma.id and ma.action_name='view' and ma.status=1
									join core.t_mtr_privilege_web pv on md.id=pv.menu_detail_id and pv.status=1
									where m.status=1 and m.parent_id=0 
									and pv.user_group_id={$userGroupId} 
									order by m.order asc "
									)->getResult();
        
        $data=array();

		foreach ($getParent as $key => $value)
		{
		 //   $checkChild=$db->query(' SELECT id, name, icon , slug from core.t_mtr_menu_web where status=1 and parent_id='.$value->id.' order by "order" asc
			// ')->getResult();

		   $checkChild=$db->query("
		   						SELECT 
									m.id, 
									m.name, 
									m.icon , 
									m.slug 
								from 
									core.t_mtr_menu_web m
									join core.t_mtr_menu_detail_web md on m.id=md.menu_id and md.status=1
									join core.t_mtr_menu_action ma on md.action_id=ma.id and ma.action_name='view' and ma.status=1
									join core.t_mtr_privilege_web pv on md.id=pv.menu_detail_id and pv.status=1
									where m.status=1 and m.parent_id=$value->id 
									and pv.user_group_id={$userGroupId}
									order by ".'"order"'." 
			")->getResult();			

			if(count((array)$checkChild)>0)
			{
				foreach ($checkChild as $keyChild => $valueChild ) {
					$getChild=menuChild($valueChild->id, $userGroupId);
					$value->child[]=$getChild;
				}
			}
			else
			{
				$value->child=array();
			}

			$data[]=(array)$value;		
		}

        return $data;

	}
}

if (!function_exists('menuChild')) { 

	function menuChild($childId="", $userGroupId="")
	{
		$db=\Config\Database::connect();
		$data=array();

		// $getChildParent=$db->query(' SELECT id, name, icon , slug from core.t_mtr_menu_web where  id='.$childId)->getRow();
		$getChildParent=$db->query("
								SELECT 
									m.id, m.name, m.icon , m.slug
								from 
									core.t_mtr_menu_web m
									join core.t_mtr_menu_detail_web md on m.id=md.menu_id and md.status=1
									join core.t_mtr_menu_action ma on md.action_id=ma.id and ma.action_name='view' and ma.status=1
									join core.t_mtr_privilege_web pv on md.id=pv.menu_detail_id and pv.status=1
									where m.status=1 
									and m.id={$childId} 
									and pv.user_group_id={$userGroupId}
									order by ".'"order"')->getRow();

		// $checkChild=$db->query(' SELECT id, name, icon , slug from core.t_mtr_menu_web where status=1 and parent_id='.$childId.' order by "order" asc')->getResult();

		$checkChild=$db->query("
								SELECT 
									m.id, m.name, m.icon , m.slug
								from 
									core.t_mtr_menu_web m
									join core.t_mtr_menu_detail_web md on m.id=md.menu_id and md.status=1
									join core.t_mtr_menu_action ma on md.action_id=ma.id and ma.action_name='view' and ma.status=1
									join core.t_mtr_privilege_web pv on md.id=pv.menu_detail_id and pv.status=1
									where m.status=1 
									and parent_id={$childId} 
									and pv.user_group_id={$userGroupId}
									order by ".'"order"')->getResult();


		if(count((array)$checkChild)>0)
		{
			foreach ($checkChild as $keyChild => $valueChild ) {
				$getChild=menuChild($valueChild->id);

				$getChildParent->child[]=$getChild;
			}
		}
		else
		{
			$getChildParent->child=array();
			
		}

		$data=(array)$getChildParent;

        return $data;

	}
}


if (!function_exists('getMenu')){

	function getMenu($userGroupId=""){

		$session = \Config\Services::session();

		if (empty($session->get('getMenu'))) {
			return parentData(menuParent($userGroupId));
		}
		else
		{
			return parentData($session->get('getMenu'));
		}
	}

}

if (!function_exists('parentData')) { 
    function parentData($menu)
    {
        $menuHtml ='<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">';
        $data=array();
        foreach ($menu  as $key => $value) {
            

             $menuChild=$value['child'];
            if(count((array)$value['child'])>0)
            {
            	$menuHtml .="<li class='nav-item' ><a href='javascript:;' href='".base_url($value['slug'])."' class='nav-link nav-toggle'><span class='title'>".$value['name']."</span><span class='arrow'></span></a>";
                
                $menuHtml .=childData($menuChild);            
            }
            else
            {

				$menuHtml .="<li class='nav-item' ><a href='".base_url($value['slug'])."' class='nav-link nav-toggle'><span class='title'>".$value['name']."</span></a>";
            }

        }
        $menuHtml .="</li></ul>";
        
        return $menuHtml ;        
	}
}		

if (!function_exists('childData')) {
    function childData($menuChild)
    {
        $menuHtml ="<ul class='sub-menu'>";
        for ($i=0; $i < count((array)$menuChild); $i++) 
        { 

        	$count=count((array)$menuChild[$i]['child']);
        	

        	if ($count>0) 
        	{
        		$menuHtml .="<li class='nav-item'  > <a class='nav-link' href='".base_url($menuChild[$i]['slug'])."' > <span class='nav-link'  >".$menuChild[$i]['name']."</span><span class='arrow'></span></a> ";

        		$menuHtml .=childData($menuChild[$i]['child']);
        	}
        	else
        	{
        		$menuHtml .="<li class='nav-item'  > <a class='nav-link' href='".base_url($menuChild[$i]['slug'])."' > <span class='nav-link'  >".$menuChild[$i]['name']."</span></a> ";	
        	}
        }

        return $menuHtml .="</li></ul>";
    }
}

if (!function_exists('isLogin')) {
    function isLogin()
    {
    	$session = \Config\Services::session(); // call session	

    	if($session->get('getLogin')<>1)
    	{
    		
			header("Location:".base_url()."/login"); // menggunakan fungsi php murni bukan bawaan ci
			exit();
    	}
    }
}

if (!function_exists('isLogout')) {
    function isLogout()
    {
    	$session = \Config\Services::session(); // call session	

    	if($session->get('getLogin')==1)
    	{
			header("Location:".base_url()."/home"); // menggunakan fungsi php murni bukan bawaan ci
			exit();
    	}
    }
}





