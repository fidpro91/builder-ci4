<?php

namespace App\Controllers\Core;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class CoreController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['fumum_helper','bosstrap_helper','form_helper','html_helper','filesystem'];
    protected $form;
    protected $pagename;
    protected $breadcumbs;
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        Config('App')->headerCss =
        link_tag('assets/themes/extra-libs/toastr/dist/build/toastr.min.css').
        link_tag('assets/themes/libs/sweetalert2/dist/sweetalert2.min.css').
        link_tag('assets/dist/css/style.min.css');

        Config('App')->footerJs     = 
        script_tag("assets/themes/libs/block-ui/jquery.blockUI.js").
        script_tag("assets/themes/extra-libs/crud.js");
        Config('App')->footerJs2    = 
        script_tag("assets/themes/libs/sweetalert2/dist/sweetalert2.all.min.js").
        script_tag("assets/themes/extra-libs/showform.js");
        // Preload any models, libraries, etc, here.

        
        $router = service('router');
        /* $controller  = $router->controllerName();
        $method = $router->methodName(); */
        
        $this->pagename       = class_basename($router->controllerName());
        $this->breadcumbs           = '<li class="breadcrumb-item"><a href="javascript:void(0)">'.$this->pagename.'</a></li>';
        $this->breadcumbs           .= '<li class="breadcrumb-item active">'.$router->methodName().'</li>';

        // $this->set_breadcumb($breadcumbs);
        // E.g.: $this->session = \Config\Services::session();
    }

    public function get_theme($view,$param=[],$class)
    {
        $data['menu']   = $this->get_menu();
        $data['title']  = $this->pagename;
        $data['breadcumbs']  = $this->breadcumbs;
        $data['pageName']  = ucwords($this->pagename);
        if ($param) {
            $data           = array_merge($data,$param);
        }
        return view($view,$data);
    }

    private function get_menu($id=0)
    {
        $db = \Config\Database::connect();
        $menu = $db->table('ms_menu');
        $datam = $menu->where(['menu_parent_id'=>$id,'menu_status'=>'t'])
                        ->orderBy('menu_code')->get()->getResult();
        $menux='';
        foreach ($datam as $key => $value) {
            if ($menu->where('menu_parent_id',$value->menu_id)->countAllResults() > 0) {
                $menux .= "<li class=\"sidebar-item\">
                                <a class=\"sidebar-link has-arrow waves-effect waves-dark\" href=\"javascript:void(0)\"
                                aria-expanded=\"false\">
                                <i class=\"".(!empty($value->menu_icon)?$value->menu_icon:'fa fa-circle-o')."\"></i> <span class=\"hide-menu\">$value->menu_name</span> 
                                </a>
                                <ul aria-expanded=\"false\" class=\"collapse first-level\">";
                $menux .= $this->get_menu($value->menu_id);
                $menux .= "</ul></li>";
            }else{
                $menux .= "<li class=\"sidebar-item\"><a class=\"sidebar-link\" href=\"".base_url($value->menu_url)."\">
                        <i class=\"".(!empty($value->menu_icon)?$value->menu_icon:'fa fa-circle-o')."\"></i> <span class=\"hide-menu\">$value->menu_name</span>
                        </a></li>";
            }
        }
        return $menux;
    }
}
