<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Container Model
 */
class ContainerModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }    

    function dtContainer(){
        //$id = $_GET['id'];
        //$id = '69';
        $cid = $_SESSION['comid'];
        $bid = $this->input->post('bid');
        $vendor_code = get_settings('vendor_code');
        $ucc_identifier = get_settings('ucc_identifier');
        $primary_identifier = get_settings('primary_identifier');
        $pcode = $primary_identifier.$vendor_code;
        
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $sql="SELECT `sc`.`ctid`, `sc`.`pid`, `sc`.`ucc`, `sc`.`batchno`, `sc`.`serialno`, 
        `sc`.`alias`, GROUP_CONCAT('0110', `sbs`.`alias` SEPARATOR ', ') as palias 
        FROM `seedcontainer` as `sc` LEFT JOIN `seedbatchserial` as `sbs` ON `sbs`.`ucc_id` = `sc`.`ctid` 
        WHERE `sc`.`cid` = $cid AND `sc`.`batchno` = $bid AND `sbs`.batch_id=$bid GROUP BY `sc`.`alias` ORDER BY `sc`.`ucc` ASC";
        $query = $this->db->query($sql);
        $i=1;
        // echo $this->db->last_query();
        $output=[];
        foreach ($query->result() as $row) { 
            $actionButton = '
              <ul class="list-inline">
                <li class="list-inline-item d-print-none"><a class="btn text-info btn-xs" role="button" href="containerqrcode?ctid='.$row->ctid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print Secondary Label"> <span class="fas fa-print"></span></a></li>
                <li class="list-inline-item d-print-none"><a class="btn text-success btn-xs" role="button" href="containernqrcode?ctid='.$row->ctid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print Secondary Label"> <span class="fas fa-print"></span></a></li>
              </ul>';

            $output[] = array(
                $i++,
                $row->ucc,
                $ucc_identifier.$vendor_code.$row->alias,
                $row->palias,
                $actionButton
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $query->num_rows(),
                 "recordsFiltered" => $query->num_rows(),
                 "data" => $output
            );
        return $result;  
        exit();
    }
   

    function showucc(){ 
        $comid = $_SESSION['comid'];
        $comid = sprintf('%04s', $comid);
        $value2 = '';
        $inv = '190089010001'.$comid."0000";
        $invno = $this->db->select('ucc')
                ->from('seedcontainer')
                ->get();
        foreach($invno->result() AS $row){
            $value2 = $row->ucc;            
        }
        if($inv <= $value2){
            $value2 = substr($value2, 16, 20);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = '190089010001'.$comid. sprintf('%04s', $value2);//concatenating incremented value
            $newID = $value2; 
        } else{
            $value2 = '190089010001'.$comid."0001";
            $newID= $value2;
        }
        return $newID;
    }

    function getBinfo(){
        $id=$this->input->post('member_id');
        $bnfo=$this->db->select('id, pid')
                ->from('seedbatch')
                ->where('batch_no', $id)->get();
        return $bnfo->row_array();
    }

    function getSerial(){
        $depart=$this->db->order_by("serialno", "asc")->where('cid', $_SESSION['comid'])->get('seedbatchserial'); 
        return $depart;
    }
    
    public function get_container_maxalias(){
        $this->db->select_max('alias');
        $this->db->from('seedcontainer');
        $res = $this->db->get()->row();
        return $res->alias;
     }

    public function get_serial_no($bid,$c_total){
        $sr_no = array();
        $result = $this->db->select('*')
        ->from('seedbatchserial')
        ->where('batch_id',$bid)
        ->where('ucc_id','0')
        ->order_by('sbsid','asc')
        ->get()->result();
        //echo 'Hi';
        if($result){
            foreach($result as $row){
                $sr_no[] = $row->serialno;
            }
        }
        //var_dump($sr_no);
        return $sr_no;
    }

    public function get_container_serial_no($ctid){
        $sr_no = array();
        $vendor_code = get_settings('vendor_code');
        $primary_identifier = get_settings('primary_identifier');
        $result = $this->db->select('*')
        ->from('seedbatchserial')
        ->where('ucc_id',$ctid)
        ->order_by('sbsid','asc')
        ->get()->result();
        if($result){
            foreach($result as $row){
                $sr_no[] = $primary_identifier.$vendor_code.$row->alias;
            }
        }
        
        return $sr_no;
    }

    public function update_batchserial_container($ser_no,$container_id){
        $data = array('ucc_id'=>$container_id);
        $this->db->where('serialno',$ser_no);
        $this->db->update('seedbatchserial',$data);
    }
    
    public function update_batch_container($bid){
        $data = array('container_status'=>'1');
        $this->db->where('id',$bid);
        $this->db->update('seedbatch',$data);
    }
    
    public function get_empty_containers($container_qty,$bid){
        $result = $this->db->select('ctid')
        ->from('seedcontainer')
        ->where('batchno',$bid)
        ->order_by('ctid','asc')
        ->limit($container_qty)
        ->get()->result_array();
        return $result;
    }
    
//     function addContainer(){
//         $ucc = $this->input->post('ucc');
//         $batchno = $this->input->post('batchno');
//         $s_no_qty = $this->input->post('s_no_qty');
//         $pid = $this->input->post('pid');
//         $bid = $this->input->post('bid');
//         $serialno = $this->input->post('serialno');
//         $ctotal = $this->input->post('ctotal');
//         //$sno = implode(",",$serialno);
//         $cid = $_SESSION['comid'];  

//     if($s_no_qty > $ctotal){
//         $container_qty = $s_no_qty/$ctotal;
//         $container_qty = ceil($container_qty);
//         $remainder = $s_no_qty % $ctotal;
//         //echo $remainder;exit();
//         if($remainder != '0'){
//             $lst_qty = $remainder;
//         }else{
//             $lst_qty = $ctotal;
//         }
//         $datat=array();
//         $max_alias = $this->get_container_maxalias();
//         $comid = $_SESSION['comid'];
//         $inv = '1900';
//         $comid = sprintf("%04d", $cid);
//         $prodid = sprintf("%04d", $pid);
//         $batid = sprintf("%04d", $bid);
//         $x = '1';
//         for($i='1';$i<=$container_qty;$i++){
//             $x = sprintf("%04d", $i);
//             $y = $inv.$comid.$prodid.$batid.$x;
//             $alias = $max_alias + 1;
//             //$ucc = $this->showucc();
//             if($i == $container_qty){
//                 $ctotal = $lst_qty;
//             }
//           //$serial_no =  $this->get_serial_no($bid,$ctotal);
//           //$sno = implode(",",$serial_no);
//             $datat[]=array('pid'=>$pid, 'ucc'=>$y, 'batchno'=>$bid, 'totalno'=>$ctotal, 'cid'=>$cid,'alias' => $alias);

//             // Insert the data
            
//             // $container_id = $this->db->insert_id();
//             // foreach ($serial_no as $ser_no) {
//             //     $this->update_batchserial_container($ser_no,$container_id);
//             // }
//             $max_alias++;
//             $y++;
//         }
//         if($datat){
//             $result = $this->db->insert_batch('seedcontainer',$datat);
//         }

//         $containers = $this->get_empty_containers($container_qty,$bid);
        
//         //print_r($containers);exit();
//         $ctotal = $this->input->post('ctotal');
//         $serial_no =  $this->get_serial_no($bid,$ctotal);

//         $updateArr = array();

//         if($containers){
//             //foreach($containers as $container){
//             //$ctid = $container['ctid'];
//           // for($i='1';$i<=$container_qty;$i++){
//             $i=0;
//             $j=0;
//                 foreach($serial_no as $ser_no){
//                     //$this->update_batchserial_container($ser_no,$ctid);
//                     if($i==$ctotal){
//                         $i=0;
//                         $j++;
//                     }
//                     if(@$containers[$j]){

//                         if($i<$ctotal){
//                             $updateArr[] = array(
//                                 'serialno' => $ser_no,
//                                 'ucc_id' => $containers[$j]['ctid']
//                             );
//                         }

//                     } else {
//                         break;
//                     }

//                     $i++;
                    
//                 }
                
//           //  }
//             $result1 = $this->db->update_batch('seedbatchserial',$updateArr,'serialno');
//             //}
//           // print_r($updateArr);exit();
//         }
        
// //        $serial_no =  $this->get_serial_no($bid,$ctotal);
        
//         if($result1){
//             $this->update_batch_container($bid);
//             $output['success'] = true;
//             $output['messages'] = 'Successfully added!';  
//         }
//         else{
//             $output['success'] = false;
//             $output['messages'] = 'Ooops! something went wrong';
//         }
//     }else{
//         $output['success'] = false;
//         $output['messages'] = 'Batch quantity should be more than total quantity per container';
//     }
//         return $output;
//     }

function addContainer(){
    $ucc = $this->input->post('ucc');
    $batchno = $this->input->post('batchno');
    $s_no_qty = $this->input->post('s_no_qty');
    $pid = $this->input->post('pid');
    $bid = $this->input->post('bid');
    $serialno = $this->input->post('serialno');
    $ctotal = $this->input->post('ctotal');
   
    $cid = $_SESSION['comid'];  

if($s_no_qty > $ctotal){
    $container_qty = $s_no_qty/$ctotal;
    $container_qty = ceil($container_qty);
    $remainder = $s_no_qty % $ctotal;
   
    if($remainder != '0'){
        $lst_qty = $remainder;
    }else{
        $lst_qty = $ctotal;
    }
    $datat=array();
    $max_alias = $this->get_container_maxalias();
    $comid = $_SESSION['comid'];
    $inv = '1900';
    $comid = sprintf("%04d", $cid);
    $prodid = sprintf("%04d", $pid);
    $batid = sprintf("%04d", $bid);
    $x = '1';
    for($i='1';$i<=$container_qty;$i++){
        $x = sprintf("%04d", $i);
        $y = $inv.$comid.$prodid.$batid.$x;
        $alias = $max_alias + 1;
        if($i == $container_qty){
            $ctotal = $lst_qty;
        }
        $datat[]=array('pid'=>$pid, 'ucc'=>$y, 'batchno'=>$bid, 'totalno'=>$ctotal, 'cid'=>$cid,'alias' => $alias);

       
        $max_alias++;
        $y++;
    }
    if($datat){
        $result = $this->db->insert_batch('seedcontainer',$datat);
    }

    $containers = $this->get_empty_containers($container_qty,$bid);
   
    $ctotal = $this->input->post('ctotal');
    $serial_no =  $this->get_serial_no($bid,$ctotal);

    $updateArr = array();
    $result1=array();

    if($containers){
       
        $i=0;
        $j=0;
        $batch_increment=1;
        $array_key=0;
        $total_serialno=sizeof($serial_no);
       
            foreach($serial_no as $ser_no){
               
                if($i==$ctotal){
                    $i=0;
                    $j++;
                }
               
               
               
                if(@$containers[$j]){

                    if($i<$ctotal){
                        $updateArr[] = array(
                            'serialno' => $ser_no,
                            'ucc_id' => $containers[$j]['ctid']
                        );
                    }

                }
               
               
                //spilt
                if($batch_increment==1000 or $array_key+1==$total_serialno){

                    $batch_increment=1;
                   
                    if($updateArr){
$result1 = $this->db->update_batch('seedbatchserial',$updateArr,'serialno');
}
                    $updateArr=array();
                }
               

                $i++;
               
                $batch_increment++;
               
                $array_key++;
            }
           
     
    }
   
   
    if($result1){
        $this->update_batch_container($bid);
        $output['success'] = true;
        $output['messages'] = 'Successfully added!';  
    }
    else{
        $output['success'] = false;
        $output['messages'] = 'Ooops! something went wrong';
    }
}else{
    $output['success'] = false;
    $output['messages'] = 'Batch quantity should be more than total quantity per container';
}
    return $output;
}
    
    function editContainer(){
        $ucc = $this->input->post('ucc');
        $batchno = $this->input->post('batchno');
        $pid = $this->input->post('pid');
        $bid = $this->input->post('bid');
        $serialno = $this->input->post('serialno');
        $ctotal = $this->input->post('ctotal');
        $sno = implode(",",$serialno);
        $cid = $_SESSION['comid'];
        $id = $this->input->post('edit_con_id');

        $serialno_cnt = count($serialno);
        if($serialno_cnt == $ctotal){

            $datat=array('pid'=>$pid, 'ucc'=>$ucc, 'batchno'=>$batchno, 'serialno'=>$sno, 'totalno'=>$ctotal, 'cid'=>$cid);

            // Update data
            $result = $this->db->update('seedcontainer',$datat,array('ctid'=>$id));

            if($result){
                $output['success'] = true;
                $output['messages'] = 'Successfully added!';  
            }
            else{
                $output['success'] = false;
                $output['messages'] = 'Ooops! something went wrong';
            }
        }else{
            $output['success'] = false;
            $output['messages'] = 'Selected count of serial no. and container quantity is not equal!';
        }
        return $output;
    }

    function delContainer(){
        $id=$this->input->post('member_id');
        $this->db->where('ctid', $id);
        $result=$this->db->delete('seedcontainer');
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Removed Container';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing Container!';
        }

        return($output);
    }
    
    public function getContainer($bid){
        // echo $c_id;exit();
        $this->db->select('sc.ctid,sc.alias,sc.ucc,sc.batchno');
        //$this->db->join('seedbatchserial sbs','sbs.batch_id=sc.batchno');
        $this->db->where('sc.api_sent','0');
       // $this->db->where('ctid','17');
       //$this->db->where('sc.batchno','1181');
        $this->db->where('sc.batchno',$bid);
        $this->db->from('seedcontainer sc');
        $containers = $this->db->get()->result();
        return $containers;
    }
    
    // public function get_serno_by_container($ctid){
    //     $result = $this->db->select('serialno') 
    //     ->from('seedbatchserial')
    //     ->where('ucc_id',$ctid)
    //     ->get()->result();
    //     return $result;
    // }
    
    
    
    public function get_serno_by_container($ctid, $bid){
        $this->db->select('b.*,p.p_code as productCode,bs.serialno as sr_no,bs.sbsid as sbsid,bs.alias as palias');
        $this->db->where('b.api_sent','0');
        // $this->db->where('bs.serialno',$sno);
        $this->db->where('b.id', $bid);
        $this->db->join('seedproduct p','p.id = b.pid');
        $this->db->join('seedbatchserial bs','bs.batch_id = b.id');
        $this->db->where('bs.ucc_id', $ctid);
        //$this->db->where('b.ucc_id', $ctid);
        $this->db->from('seedbatch b');
        return $this->db->get()->result();
    }
    
    public function update_container_api($ucc){
        $data = array('api_sent'=>'1');
        $this->db->where('ucc',$ucc);
        $this->db->update('seedcontainer',$data);
    }
    
    public function update_container_api_response($ucc,$response){
        $data = array('api_response'=> $response);
        $this->db->where('ucc',$ucc);
        $this->db->update('seedcontainer',$data);
    }

    public function containerExport($id,$comid){
        $this->db->select('sc.ucc,sc.alias,sc.totalno,bs.batch_no as batchno');
        $this->db->where('sc.batchno',$id);
        $this->db->where('sc.cid',$comid);
        $this->db->join('seedbatch bs','bs.id = sc.batchno');
        $this->db->from('seedcontainer sc');
        return $this->db->get()->result();
    }
}

