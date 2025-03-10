<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Model
 */
class DashboardModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    function prdCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $cp = $this->db->select('*')->from('tarpaulinproduct')
            ->where(array('c_id'=> $_SESSION['comid'], 'status'=>'1'))->get();
            $query = $cp->num_rows();
        }else{
            $userrole = $_SESSION['role'];
            $center = substr($userrole, 0, -6).'admin';
            $ainfo = $this->db->select('id as cid')->from('users')->where('role', $center)->get();
            foreach($ainfo->result() as $arow){
                $cid = $arow->cid;
            }
            $cp = $this->db->select('*')->from('tarpaulinproduct')
            ->where(array('c_id'=> $cid, 'status'=>'1'))->get();
            $query = $cp->num_rows();
        }
        return $query;
    }

    function dprdCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $cp = $this->db->select('*')->from('tarpaulinproduct')
            ->where(array('c_id'=> $_SESSION['comid'], 'status'=>'0'))->get();
            $query = $cp->num_rows();
        }else{
            $userrole = $_SESSION['role'];
            $center = substr($userrole, 0, -6).'admin';
            $ainfo = $this->db->select('id as cid')->from('users')->where('role', $center)->get();
            foreach($ainfo->result() as $arow){
                $cid = $arow->cid;
            }
            $cp = $this->db->select('*')->from('tarpaulinproduct')
            ->where(array('c_id'=> $cid, 'status'=>'0'))->get();
            $query = $cp->num_rows();
        }
        return $query;
    }

    function bthCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $cp = $this->db->select('*')->from('tarpaulinbatch')
            ->where(array('c_id'=> $_SESSION['comid'], 'status'=>'1'))->get();
            $query = $cp->num_rows();
        }else{            
            $cp = $this->db->select('*')->from('tarpaulinbatch')
            ->where(array('c_id'=> $_SESSION['comid'], 'status'=>'1'))->get();
            $query = $cp->num_rows();
        }
        return $query;
    }

    function bthdCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $cp = $this->db->select('*')->from('tarpaulinbatch')
            ->where(array('c_id'=> $_SESSION['comid'], 'status'=>'0'))->get();
            $query = $cp->num_rows();
        }else{            
            $cp = $this->db->select('*')->from('tarpaulinbatch')
            ->where(array('c_id'=> $_SESSION['comid'], 'status'=>'0'))->get();
            $query = $cp->num_rows();
        }
        return $query;
    }

    function cthCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $cp = $this->db->select('*')->from('tarpaulinbatchserial')
            ->where(array('cid'=> $_SESSION['comid']))->get();
            $query = $cp->num_rows();
        }else{            
            $cp = $this->db->select('*')->from('tarpaulincontainer')
            ->where(array('cid'=> $_SESSION['comid']))->get();
            $query = $cp->num_rows();
        }
        return $query;
    }

    function cthdCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $cp = $this->db->select('*')->from('tarpaulincontainer')
            ->where(array('cid'=> $_SESSION['comid'], 'status'=>'0'))->get();
            $query = $cp->num_rows();
        }else{
            $cp = $this->db->select('*')->from('tarpaulincontainer')
            ->where(array('cid'=> $_SESSION['comid'], 'status'=>'0'))->get();
            $query = $cp->num_rows();
        }
        return $query;
    }

    function totCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $query = $_SESSION['comtotprd'];
        }else{
            $userrole = $_SESSION['role'];
            $center = substr($userrole, 0, -6).'admin';
            $ainfo = $this->db->select('id as cid')->from('users')->where('role', $center)->get();
            foreach($ainfo->result() as $arow){
                $cid = $arow->cid;
            }
            $cp = $this->db->select('*')->from('tarpaulinproduct')
            ->where(array('c_id'=> $cid, 'status'=>'1'))->get();
            $query = $cp->num_rows();
        }
        return $query;
    }

    function rtotCount(){
        if($_SESSION['level']==='3' && $_SESSION['comcat']==="7" && 
        ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')){
            $totprd = $_SESSION['comtotprd'];
            $cp = $this->db->select('*')->from('tarpaulinproduct')
            ->where(array('c_id'=> $_SESSION['comid'], 'status'=>'1'))->get();
            $usdprd = $cp->num_rows();
        }
        $query = $totprd - $usdprd;
        return $query;
    }

}