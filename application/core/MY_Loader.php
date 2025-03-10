<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

    function __construct() {
        parent::__construct();

        $CI =& get_instance();
        $CI->load = $this;
    }

    //Login/Regster Screen Template
    public function home_template($template_name, $vars = array(), $return = TRUE){
        $content  = $this->view('template/home/header', $vars, $return);

        if(is_array($template_name)) { //return all values in contents
            foreach($template_name as $file_to_load) {
                $content .= $this->view($file_to_load, $vars, $return);
            }
        }else{
            $content .= $this->view($template_name, $vars, $return);
        }            
            $content .= $this->view('template/home/script', $vars, $return);
            $content .= $this->view('template/home/footer', $vars, $return);

        echo $content;
    }
    
    //Public Screen Template
    public function public_template($template_name, $vars = array(), $return = TRUE){
        $content  = $this->view('template/public/header', $vars, $return);
        $content  .= $this->view('template/public/datatable_css', $vars, $return);
        $content  .= $this->view('template/public/datecss', $vars, $return);
        $content  .= $this->view('template/public/headerend', $vars, $return);

        if(is_array($template_name)) { //return all values in contents
            foreach($template_name as $file_to_load) {
                $content .= $this->view($file_to_load, $vars, $return);
            }
        }else{
            $content .= $this->view($template_name, $vars, $return);
        }            
            $content .= $this->view('template/public/script', $vars, $return);
            $content .= $this->view('template/public/datatable_js', $vars, $return);
            $content .= $this->view('template/public/datejs', $vars, $return);
            $content .= $this->view('template/public/pagescript', $vars, $return);
            $content .= $this->view('template/public/footer', $vars, $return);

        echo $content;
    }

    //Dashboard Screen Template
    public function dashboard_template($template_name, $vars = array(), $return = TRUE){
        $content  = $this->view('template/common/header', $vars, $return);
        $content  .= $this->view('template/common/headerend', $vars, $return);
        if($_SESSION['level']==='1'){
            $content  .= $this->view('template/superadmin/navbar', $vars, $return);
            $content  .= $this->view('template/superadmin/sidebar', $vars, $return);
        }
        elseif($_SESSION['level']==='2'){
            $content  .= $this->view('template/admin/navbar', $vars, $return);
            $content  .= $this->view('template/admin/sidebar', $vars, $return);
        }else{
            $content  .= $this->view('template/app/navbar', $vars, $return);
            $content  .= $this->view('template/app/sidebar', $vars, $return);
        }        

        if(is_array($template_name)) { //return all values in contents
            foreach($template_name as $file_to_load) {
                $content .= $this->view($file_to_load, $vars, $return);
            }
        }else{
            $content .= $this->view($template_name, $vars, $return);
        }            
            $content .= $this->view('template/common/footer', $vars, $return);
            $content .= $this->view('template/common/script', $vars, $return);
            if($_SESSION['level']==='1'){
                $content .= $this->view('template/superadmin/pagescript', $vars, $return);
            }
            elseif($_SESSION['level']==='2'){
                $content .= $this->view('template/admin/pagescript', $vars, $return);
            }
            else{
                $content .= $this->view('template/app/pagescript', $vars, $return);
            }
            $content .= $this->view('template/common/footerend', $vars, $return);

        echo $content;
    }

    //Datatable Screen Template
    public function datatable_template($template_name, $vars = array(), $return = TRUE){
        $content  = $this->view('template/common/header', $vars, $return);
        $content  .= $this->view('template/common/datatable_css', $vars, $return);
        $content  .= $this->view('template/common/datecss', $vars, $return);
        $content  .= $this->view('template/common/sweetalert_css', $vars, $return);
        $content  .= $this->view('template/common/headerend', $vars, $return);
        if($_SESSION['level']==='1'){
            $content  .= $this->view('template/superadmin/navbar', $vars, $return);
            $content  .= $this->view('template/superadmin/sidebar', $vars, $return);
        }
        elseif($_SESSION['level']==='2'){
            $content  .= $this->view('template/admin/navbar', $vars, $return);
            $content  .= $this->view('template/admin/sidebar', $vars, $return);
        }else{
            $content  .= $this->view('template/app/navbar', $vars, $return);
            $content  .= $this->view('template/app/sidebar', $vars, $return);
        }         

        if(is_array($template_name)) { //return all values in contents
            foreach($template_name as $file_to_load) {
                $content .= $this->view($file_to_load, $vars, $return);
            }
        }else{
            $content .= $this->view($template_name, $vars, $return);
        }            
            $content .= $this->view('template/common/footer', $vars, $return);
            $content .= $this->view('template/common/script', $vars, $return);
            $content .= $this->view('template/common/datatable_js', $vars, $return);
            $content .= $this->view('template/common/datejs', $vars, $return);
            $content .= $this->view('template/common/sweetalert_js', $vars, $return);
            if($_SESSION['level']==='1'){
                $content .= $this->view('template/superadmin/pagescript', $vars, $return);
            }
            elseif($_SESSION['level']==='2'){
                $content .= $this->view('template/admin/pagescript', $vars, $return);
            }
            else{
                $content .= $this->view('template/app/pagescript', $vars, $return);
            }
            $content .= $this->view('template/common/footerend', $vars, $return);

        echo $content;
    }

    //Form Entry Screen Template
    public function formentry_template($template_name, $vars = array(), $return = TRUE){
        $content  = $this->view('template/common/header', $vars, $return);
        $content  .= $this->view('template/common/select2css', $vars, $return);
        $content  .= $this->view('template/common/datecss', $vars, $return);
        $content  .= $this->view('template/common/sweetalert_css', $vars, $return);
        $content  .= $this->view('template/common/headerend', $vars, $return);
        if($_SESSION['level']==='1'){
            $content  .= $this->view('template/superadmin/navbar', $vars, $return);
            $content  .= $this->view('template/superadmin/sidebar', $vars, $return);
        }
        elseif($_SESSION['level']==='2'){
            $content  .= $this->view('template/admin/navbar', $vars, $return);
            $content  .= $this->view('template/admin/sidebar', $vars, $return);
        }else{
            $content  .= $this->view('template/app/navbar', $vars, $return);
            $content  .= $this->view('template/app/sidebar', $vars, $return);
        }

        if(is_array($template_name)) { //return all values in contents
            foreach($template_name as $file_to_load) {
                $content .= $this->view($file_to_load, $vars, $return);
            }
        }else{
            $content .= $this->view($template_name, $vars, $return);
        }            
            $content .= $this->view('template/common/footer', $vars, $return);
            $content .= $this->view('template/common/script', $vars, $return);
            $content .= $this->view('template/common/select2js', $vars, $return);
            $content .= $this->view('template/common/datejs', $vars, $return);
            $content .= $this->view('template/common/sweetalert_js', $vars, $return);
            if($_SESSION['level']==='1'){
                $content .= $this->view('template/superadmin/pagescript', $vars, $return);
            }
            elseif($_SESSION['level']==='2'){
                $content .= $this->view('template/admin/pagescript', $vars, $return);
            }
            else{
                $content .= $this->view('template/app/pagescript', $vars, $return);
            }
            $content .= $this->view('template/common/footerend', $vars, $return);

        echo $content;
    }
    
    public function api_template($template_name, $vars = array(), $return = TRUE){
       $content  = $this->view('template/common/header', $vars, $return);
        $content  .= $this->view('template/common/headerend', $vars, $return);

        if(is_array($template_name)) { //return all values in contents
            foreach($template_name as $file_to_load) {
                $content .= $this->view($file_to_load, $vars, $return);
            }
        }else{
            $content .= $this->view($template_name, $vars, $return);
        }            
            $content .= $this->view('template/common/footer', $vars, $return);
            $content .= $this->view('template/common/script', $vars, $return);
          
            $content .= $this->view('template/common/footerend', $vars, $return);

        echo $content;
    }

}