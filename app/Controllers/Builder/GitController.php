<?php
namespace App\Controllers\Builder;
use App\Controllers\Core\CoreController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Formjos;

class GitController extends CoreController
{   
    use ResponseTrait;
    public function index()
    {
        $data['form'] = new Formjos;
        return $this->get_theme('builder/git/githandler',$data,get_class($this));
    }

    public function git_run()
    {
        $post = $this->request->getPost();
        $output = shell_exec("cd /laragon/www/ci4 && git add . && git commit -m \"".$post['commit']."\" &&git ".$post['git_type']." origin ".$post['branch_name']."");
        // echo "<pre>" . $output . "</pre>";
        return "tester";
    }
}
