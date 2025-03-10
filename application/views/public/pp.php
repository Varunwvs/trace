<?php
    $cid = $this->uri->segment('2');
    $pid = $this->uri->segment('3');
    $upc = $this->uri->segment('4');
    $bid = $this->uri->segment('5');
    $alias = $this->uri->segment('6');
    $bst = $_GET['11'];  
    $cinfo = $this->db->select('name, address, category, contact_person, email, contact, website')->from('users')->where('id', $cid)->get();
    foreach($cinfo->result() as $crow){
        $name = $crow->name;
        $address = $crow->address;
        $category = $crow->category;
        $contact_person = $crow->contact_person;
        $email = $crow->email;
        $contact = $crow->contact;
        $website = $crow->website;
    }

    if($category==="1"){
        $pinfo = $this->db->select('marketed_by, p_code, p_name,prd_leaflet,prd_video,usage_instructions,prod_description,registration_no,gi_checkbox,gi_description,gi_geographical_area,gi_latitude,gi_longitude,gi_product_specifications,gi_packed_date,gi_expire_date,gi_processing_facility,gi_origin_country,gi_authorities_certificate,gi_source_info,gi_fssai_license_no,fssai_checkbox,fs_license_no,fs_ingredients,fs_nutri_info,fs_allergens,fs_allergen_warning,usfda_checkbox,us_fda_no,us_ingredients,us_nutri_info,us_allergens,us_allergen_warning,us_storage_info')->from('seedproduct')
        ->where(array('id'=>$pid, 'c_id'=> $cid))->get();
        $binfo = $this->db->select('batch_no, s_no_qty, mfd_date, exp_date,processed_lot_no,lab_certification')->from('seedbatch')
        ->where(array('id'=>$bid, 'c_id'=> $cid, 'pid'=>$pid))->get();
    }
    elseif($category==="2" || $category==="6"){
        $pinfo = $this->db->select('marketed_by, p_code, p_name')->from('fertilizerproduct')
        ->where(array('id'=>$pid, 'c_id'=> $cid))->get();
        $binfo = $this->db->select('batch_no, s_no_qty, mfd_date, exp_date')->from('fertilizerbatch')
        ->where(array('id'=>$bid, 'c_id'=> $cid, 'pid'=>$pid))->get();
    }
    elseif($category==="5"){
        $logo = 'uploads/logo.png';
        $pinfo = $this->db->select('pp.marketed_by, pp.p_code, pp.p_name, pp.cibno, pp.mlno,pp.formulation, pp.caution, pp.leaflet, pp.antst')
        ->from('publicproduct pp')
        ->where(array('pp.id'=>$pid, 'pp.c_id'=> $cid))->get();
        $binfo = $this->db->select('batch_no, s_no_qty, mfd_date, exp_date')->from('publicbatch')
        ->where(array('id'=>$bid, 'c_id'=> $cid, 'pid'=>$pid))->get();
    }

   

    //product
    foreach($pinfo->result() as $prow){
        $marketed_by = $prow->marketed_by;
        $p_code = $prow->p_code;
        $p_name = $prow->p_name;
        $cibno = $prow->cibno;
        $mlno = $prow->mlno;
        $formulation = $prow->formulation;
        $leaflet = $prow->leaflet;
        $caution = $prow->caution;
        $antst = $prow->antst;
        $prd_leaflet = $prow->prd_leaflet;
        $prd_video = $prow->prd_video;
        $usage_instructions = $prow->usage_instructions;
        $registration_no = $prow->registration_no;
        $prod_description = $prow->prod_description;
        $gi_checkbox=  $prow->gi_checkbox;
        $gi_description =  $prow->gi_description;
        $gi_geographical_area = $prow->gi_geographical_area;
        $gi_latitude = $prow->gi_latitude;
        $gi_longitude = $prow->gi_longitude;
        $gi_product_specifications = $prow->gi_product_specifications;
        $gi_packed_date = date('d-m-Y', strtotime($prow->gi_packed_date));
        $gi_expire_date = date('d-m-Y', strtotime($prow->gi_expire_date));
        $gi_processing_facility = $prow->gi_processing_facility;
        $gi_origin_country = $prow->gi_origin_country;
        $gi_authorities_certificate = $prow->gi_authorities_certificate;
        $gi_source_info = $prow->gi_source_info;
        $gi_fssai_license_no = $prow->gi_fssai_license_no;
        $fssai_checkbox = $prow->fssai_checkbox;
        $fs_license_no = $prow->fs_license_no;
        $fs_ingredients = $prow->fs_ingredients;
        $fs_nutri_info = $prow->fs_nutri_info;
        $fs_allergens = $prow->fs_allergens;
        $fs_allergen_warning = $prow->fs_allergen_warning;
        $usfda_checkbox = $prow->usfda_checkbox;
        $us_fda_no = $prow->us_fda_no;
        $us_ingredients = $prow->us_ingredients;
        $us_nutri_info = $prow->us_nutri_info;
        $us_allergens = $prow->us_allergens;
        $us_allergen_warning = $prow->us_allergen_warning;
        $us_storage_info = $prow->us_storage_info;
    }
    
  
    //Batch
    foreach($binfo->result() as $brow){
        $batch_no = $brow->batch_no;
        $s_no_qty = $brow->s_no_qty;
        $mfd_date = $brow->mfd_date;
        $exp_date = $brow->exp_date;
        $processed_lot_no = $brow->processed_lot_no;
        $lab_certification=$brow->lab_certification;
    }

    $sourcing_lot_id = $this->db->select('sourcing_lot_id')->from('processing')->where(array('processed_lot_no'=>$processed_lot_no))->get()->row()->sourcing_lot_id;
    
    $vendor_code = get_settings('vendor_code');
    $primary_identifier = get_settings('primary_identifier');
    // $alias=$this->db->select('alias')->from('seedbatchserial')->where(array('batch_id'=>$bid))->get()->row()->alias;

    $alias_no=$primary_identifier.$vendor_code.$alias;

?>

<style>
    .company-box {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 35vw;
    }
    .pl-5{
        padding-left:1.985rem !important;
    }
    .pr-5{
        padding-right:1.985rem !important;
    }
    img.logo {
        width: 7rem;
    }
    p.logotxt {
        font-size: 1.675rem !important;
        color: #002160 !important;
        padding: 1rem;
        font-weight: 700 !important;
    }
    .card {
        flex: 1;
    }
    .card-header {
        order: 1; /* Move card-header to the top */
    }
    .card-body {
        order:2;
        overflow-y: scroll; /* Enable scrolling for content */
        height: 50vh;
    }
    .company-box .card a{color:#686968 !important;}
    .company-box .card .small{font-size: 0.875rem !important;}
    .company-box .card h5 {
        font-size: .985rem;
        font-weight: 700;
        color: #686968;
        width: 63%;
        padding-left: 10px;
    }
    .company-box .card .phead {
        font-size: .875rem;
        font-weight: 700;
        color: #686968;
        width: 32%;
    }
    .company-box .card .pcontent {
        font-size: .875rem;
        font-weight: 700;
        color: #29875a;
        width: 67%;
    }
    .card-footer {
        order: 3; /* Move card-footer to the bottom */
    }
   
    /* Style for the popup */
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border: 1px solid #ccc;
      z-index: 1000;
    }

    /* Style for the overlay background */
    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 900;
    }

    /* Style for the close button */
    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
    }
    .logo-img{
        margin-bottom: 0rem;
        padding-bottom: 0rem;
        border-bottom: none;
    }
    .mmb{
            /* border-bottom: 1px solid #636363; */
            margin-bottom: 0.575rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    @media screen and (max-width: 767px){
        .company-box {
            display: flex;
            flex-direction: column;
            height: 100vh; /* 100% viewport height */
        }
        .logo-img {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #888686;
        }
        img.logo {
            width: 7rem;
        }
        p.logotxt {
            font-size: 1.275rem !important;
            color: #002160 !important;
            padding: 1rem;
            font-weight: 700 !important;
        }
        .mmb{
            /* border-bottom: 1px solid #636363; */
            margin-bottom: 0.575rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 7px;
            height: 7px;
            -webkit-overflow-scrolling: auto;
        }
        ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0,0,0,.5);
            -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
        }
        .card {
            flex: 1;
        }
    
        .card-header {
            order: 1; /* Move card-header to the top */
        }
    
        .card-body {
            order:2;
            overflow-y: scroll; /* Enable scrolling for content */
            height: 63vh;
        }
        
        .company-box .card a{color:#686968 !important;}
        .company-box .card .small{font-size: 0.825rem !important;}
        .company-box .card h5 {
            font-size: .985rem;
            font-weight: 700;
            color: #686968;
            width: 68%;
            padding-left: 10px;
        }
        .company-box .card .phead {
            font-size: .875rem;
            font-weight: 700;
            color: #686968;
            width: 32%;
        }
        .company-box .card .pcontent {
            font-size: .875rem;
            font-weight: 700;
            color: #29875a;
            width: 68%;
        }
    
        .card-footer {
            order: 3; /* Move card-footer to the bottom */
        }
    }
    
    .accordion-item {
    border-radius: 10px !important; /* Adjust the value as needed */
    overflow: hidden; /* Ensures child elements respect border-radius */
    border: 1px solid #ccc; /* Optional: Adds a border */
    }
    
    .accordion-button {
        border-radius: 10px !important; /* Rounds the button */
    }
    
    .accordion-button:not(.collapsed) {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
  </style>

<div class="company-box">
  <!-- /.login-logo -->
  <div class="card mt-2" style="background-color: #ffffff8c;">
    <!-- <div class="card-header text-center text-white" style="background:rgba(254, 254, 253, 0.4);">
        <img class="logo" style="width: 50px; height: 80px;" src="<?php echo base_url();?>/uploads/Logo -Lion Agri Ventures.png" alt="company logo">
        <p class="logotxt"><strong></strong>SYNERGY INSECTICIDES PVT LTD</strong></p>
        <p class="logotxt"><strong></strong><?php echo $name ?></strong></p>
    </div> -->
    <div class="card-header d-flex align-items-center justify-content-between text-white" 
        style="background:rgba(254, 254, 253, 0.4);backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <?php if($name == 'Two Brothers Organic Farms'){ ?>
        <!--<img class="logo" style="width: 50px; height: 80px;" src="<?php echo base_url();?>/uploads/Logo -Lion Agri Ventures.png" alt="company logo">-->
        <img class="logo" style="width: 57px; height: 35px;" src="<?php echo base_url();?>/uploads/logo-2_brothers.png" alt="company logo">

        <p class="logotxt m-0 flex-grow-1">
            <strong><?php echo $name ?></strong>
        </p>
        <?php }else{ ?>
          <img class="logo" style="width: 43px; height: 45px;" src="<?php echo base_url();?>/uploads/scalion-logo.png" alt="company logo">

        <p class="logotxt m-0 flex-grow-1">
            <strong><?php echo $name ?></strong>
        </p>
        
        <?php }?>

        <div class="d-flex justify-content-end">
            <a href="#" title="Warranty Registration" data-bs-toggle="modal" data-bs-target="#registerProductModal" class="me-3 btn-sm btn btn-success">
                <i class="fa fa-file-alt text-white"></i>
            </a>
            <a href="#" title="Support Requests" data-bs-toggle="modal" data-bs-target="#supportRequestModal" class="btn btn-sm btn-primary">
                <i class="fa fa-headset text-white"></i>
            </a>
        </div>

    </div>


    <div class="card-body mt-2 mb-3">
    <div class="col-12">
        <div class="row">
            <!-- Product Details Accordion -->
            <div class="col-lg-12 col-md-12 col-sm-12 pl-5 pr-5">
               
                <div class="accordion" id="productAccordion"> <!-- Single accordion container -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProductInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductInfo" aria-expanded="true" aria-controls="collapseProductInfo">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;  Product Details
                            </button>
                        </h2>
                        <div id="collapseProductInfo" class="accordion-collapse collapse" aria-labelledby="headingProductInfo">
                            <div class="accordion-body">
                                <div class="row plabel">
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Product Name</p>
                                        <p class="pcontent"><?php echo $p_name ?></p>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">U.I.D(Unique ID No.)</p>
                                        <p class="pcontent"><?php echo $bst ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Product Id</p>
                                        <p class="pcontent"><?php echo $p_code ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Registration No.</p>
                                        <p class="pcontent"><?php echo $registration_no ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Alias No.</p>
                                        <p class="pcontent"><?php echo $alias_no ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">MFG. Date</p>
                                        <p class="pcontent"><?php echo date('d-m-Y', strtotime($mfd_date)) ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Expiry Date</p>
                                        <p class="pcontent"><?php echo date('d-m-Y', strtotime($exp_date)) ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Product Description</p>
                                        <p class="pcontent"><?php echo $prod_description ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Manufacturer Details Accordion -->
                    <div class="accordion-item  mt-3">
                        <h2 class="accordion-header" id="headingManufacturerInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseManufacturerInfo" aria-expanded="true" aria-controls="collapseManufacturerInfo">
                            <i class="fa fa-gear" aria-hidden="true"></i> &nbsp; Manufacturer Details 
                            </button>
                        </h2>
                        <div id="collapseManufacturerInfo" class="accordion-collapse collapse" aria-labelledby="headingManufacturerInfo">
                            <div class="accordion-body">
                                <div class="row mdlabel">
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Manufactured By</p>
                                        <p class="pcontent small"><?php echo strtoupper($name) ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Marketed By</p>
                                        <p class="pcontent small"><?php echo strtoupper($marketed_by) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Instructions Accordion -->
                    <div class="accordion-item  mt-3">
                        <h2 class="accordion-header" id="headingUsageInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsageInfo" aria-expanded="true" aria-controls="collapseUsageInfo">
                            <i class="fa fa-book" aria-hidden="true"></i> &nbsp; Usage Instructions 
                            </button>
                        </h2>
                        <div id="collapseUsageInfo" class="accordion-collapse collapse" aria-labelledby="headingUsageInfo">
                            <div class="accordion-body">
                                <div class="row ulabel">
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Usage Instructions</p>
                                        <p class="pcontent"><?php echo $usage_instructions ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	

                    <!-- Media Links Accordion -->
                    <div class="accordion-item  mt-3">
                        <h2 class="accordion-header" id="headingMediaInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMediaInfo" aria-expanded="true" aria-controls="collapseMediaInfo">
                            <i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp; Media Links 
                            </button>
                        </h2>
                        <div id="collapseMediaInfo" class="accordion-collapse collapse" aria-labelledby="headingMediaInfo">
                            <div class="accordion-body">
                                <div class="row mlabel">
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Product Leaflet</p>
                                        <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo $prd_leaflet ?>" target="_blank" id="openPopup">View Product Leaflet</a></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Product Video</p>
                                        <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo $prd_video ?>" target="_blank" id="openPopup">View Product Video</a></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Lab Certification</p>
                                            <?php if(!empty($lab_certification)){?>
                                                <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo base_url('uploads/lab_certification/'.$lab_certification)  ?>"  target="_blank" >View Certificate</a></p>
                                            <?php }else{ ?>
                                                <p class="pcontent" ><a style="color: #29875a !important; text-decoration: none !important;"  href="#"  disabled >View Certificate</a></p>
                                            <?php } ?>

                                        </div>

                                       
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tracing Information Accordion -->
                    <div class="accordion-item  mt-3">
                        <h2 class="accordion-header" id="headingTracingInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTracingInfo" aria-expanded="true" aria-controls="collapseTracingInfo">
                            <i class="fa fa-sliders" aria-hidden="true"></i>&nbsp; Tracing Information 
                            </button>
                        </h2>
                        <div id="collapseTracingInfo" class="accordion-collapse collapse" aria-labelledby="headingTracingInfo">
                            <div class="accordion-body">
                                <div class="row tlabel">
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Source Lot Reference No.</p>
                                        <p class="pcontent"><?php echo $sourcing_lot_id ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Processed Lot No.</p>
                                        <p class="pcontent"><?php echo $processed_lot_no ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Batch No.</p>
                                        <p class="pcontent"><?php echo $batch_no ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php if(!empty($gi_checkbox)){?>
                     <!-- GI Tag Information Accordion -->
                     <div class="accordion-item  mt-3">
                        <h2 class="accordion-header" id="headingGiTagInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGiTagInfo" aria-expanded="true" aria-controls="collapseGiTagInfo">
                            <i class="fa fa-file-shield" aria-hidden="true"></i>&nbsp; GI Tag Information 
                            </button>
                        </h2>
                        <div id="collapseGiTagInfo" class="accordion-collapse collapse" aria-labelledby="headingGiTagInfo">
                            <div class="accordion-body">
                                <div class="row tlabel">
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Geographical Area:</p>
                                        <p class="pcontent"><?php echo $gi_geographical_area; ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Sourcing Geo Latitude:</p>
                                        <p class="pcontent"><?php echo $gi_latitude; ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Sourcing Geo Longitude:</p>
                                        <p class="pcontent"><?php echo $gi_longitude; ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Origin Country:</p>
                                        <p class="pcontent"><?php echo $gi_origin_country; ?></p>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Packed Date:</p>
                                        <p class="pcontent"><?php echo $gi_packed_date; ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Expire Date:</p>
                                        <p class="pcontent"><?php echo $gi_expire_date; ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Processing Facility Info:</p>
                                        <p class="pcontent"><?php echo $gi_processing_facility; ?></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Product Specifications:</p>
                                        <p class="pcontent"><?php echo $gi_product_specifications; ?></p>
                                    </div>

                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Description:</p>
                                        <p class="pcontent"><?php echo $gi_description; ?></p>
                                    </div>

                                    <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Authority Certificate</p>
                                            <?php if(!empty($gi_authorities_certificate)){?>
                                                <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo base_url('uploads/gi_authorities_certificate/'.$gi_authorities_certificate)  ?>"  target="_blank" >View Certificate</a></p>
                                            <?php }else{ ?>
                                                <p class="pcontent" ><a style="color: #29875a !important; text-decoration: none !important;"  href="#"  disabled >View Certificate</a></p>
                                            <?php } ?>

                                        </div>
                                        <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">Source Info</p>
                                            <?php if(!empty($gi_source_info)){?>
                                                <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo base_url('uploads/gi_source_info/'.$gi_source_info)  ?>"  target="_blank" >View Info</a></p>
                                            <?php }else{ ?>
                                                <p class="pcontent" ><a style="color: #29875a !important; text-decoration: none !important;"  href="#"  disabled >View Info</a></p>
                                            <?php } ?>

                                        </div>

                                        <div class="col-md-12 col-sm-6 mmb">
                                        <p class="phead">FSSAI License No:</p>
                                        <p class="pcontent"><?php echo $gi_fssai_license_no; ?></p>
                                    </div>
                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if(!empty($fssai_checkbox)){?>
                       <!-- FSSAI Information Accordion -->
                       <div class="accordion-item  mt-3">
                        <h2 class="accordion-header" id="headingFssaiInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFssaiInfo" aria-expanded="true" aria-controls="collapseFssaiInfo">
                            <i class="fa fa-file-shield" aria-hidden="true"></i>&nbsp; FSSAI Information 
                            </button>
                        </h2>
                        <div id="collapseFssaiInfo" class="accordion-collapse collapse" aria-labelledby="headingFssaiInfo">
                            <div class="accordion-body">
                                <div class="row tlabel">
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">FSSAI License No.</p>
                                    <p class="pcontent"><?php echo $fs_license_no ?></p>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Ingredients</p>
                                    <?php if(!empty($fs_ingredients)){?>
                                                <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo base_url('uploads/fs_ingredients/'.$fs_ingredients)  ?>"  target="_blank" >View Ingredients</a></p>
                                            <?php }else{ ?>
                                                <p class="pcontent" ><a style="color: #29875a !important; text-decoration: none !important;"  href="#"  disabled >View Ingredients</a></p>
                                            <?php } ?>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Nutritional Info</p>
                                    <?php if(!empty($fs_nutri_info)){?>
                                                <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo base_url('uploads/fs_nutri_info/'.$fs_nutri_info)  ?>"  target="_blank" >View Nutritional Info</a></p>
                                            <?php }else{ ?>
                                                <p class="pcontent" ><a style="color: #29875a !important; text-decoration: none !important;"  href="#"  disabled >View Nutritional Info</a></p>
                                            <?php } ?>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Allergens</p>
                                    <p class="pcontent"><?php echo $fs_allergens ?></p>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Allergen Warning</p>
                                    <p class="pcontent"><?php echo $fs_allergen_warning ?></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>

                    <?php if(!empty($usfda_checkbox)){?>
                       <!-- US FDA Information Accordion -->
                       <div class="accordion-item  mt-3">
                        <h2 class="accordion-header" id="headingUsfdaInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsfdaInfo" aria-expanded="true" aria-controls="collapseUsfdaInfo">
                            <i class="fa fa-file-shield" aria-hidden="true"></i>&nbsp; US FDA Information 
                            </button>
                        </h2>
                        <div id="collapseUsfdaInfo" class="accordion-collapse collapse" aria-labelledby="headingUsfdaInfo">
                            <div class="accordion-body">
                                <div class="row tlabel">
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">US FDA Approval No.</p>
                                    <p class="pcontent"><?php echo $us_fda_no ?></p>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Ingredients</p>
                                    <?php if(!empty($us_ingredients)){?>
                                    <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo base_url('uploads/us_ingredients/'.$us_ingredients)  ?>"  target="_blank" >View Ingredients</a></p>
                                            <?php }else{ ?>
                                                <p class="pcontent" ><a style="color: #29875a !important; text-decoration: none !important;"  href="#"  disabled >View Ingredients</a></p>
                                            <?php } ?>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Nutritional Info</p>
                                    <?php if(!empty($us_nutri_info)){?>
                                                <p class="pcontent"><a style="color: #29875a !important; text-decoration: none !important;"   href="<?php echo base_url('uploads/us_nutri_info/'.$us_nutri_info)  ?>"  target="_blank" >View Nutritional Info</a></p>
                                            <?php }else{ ?>
                                                <p class="pcontent" ><a style="color: #29875a !important; text-decoration: none !important;"  href="#"  disabled >View Nutritional Info</a></p>
                                            <?php } ?>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Allergens</p>
                                    <p class="pcontent"><?php echo $us_allergens ?></p>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Allergen Warning</p>
                                    <p class="pcontent"><?php echo $us_allergen_warning ?></p>
                                </div>
                                <div class="col-md-12 col-sm-6 mmb">
                                    <p class="phead">Storage Instructions</p>
                                    <p class="pcontent"><?php echo $us_storage_info ?></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>




                    <!-- Customer Care Accordion -->
                    <div class="accordion-item mt-3">
                        <h2 class="accordion-header" id="headingCustomerCare">
                        
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomerCare" aria-expanded="true" aria-controls="collapseCustomerCare">
                            <i class="fa fa-phone-square" aria-hidden="true"></i> &nbsp; Contact Information
                            </button>
                        </h2>
                        <div id="collapseCustomerCare" class="accordion-collapse collapse" aria-labelledby="headingCustomerCare">
                            <div class="accordion-body">
                                <?php if($name == 'Two Brothers Organic Farms'){ ?>
                                <div class="row">
                                    <div class="col-md-12 col-sm-6">
                                        <p class="phead" style="width:100%;">Customer Care</p>
                                        <p class="phead" style="width:100%">Manager - TWO BROTHERS ORGANIC FARMS.,</p>
                                        <p class="phead" style="width:100%">
                                            <a href="tel:0836-2356704">
                                                <i class="fas fa-mobile"></i> : 0836-2356704
                                            </a>
                                        </p>
                                        <p class="phead" style="width:100%">
                                            <a href="mailto:lion.agri@lionsagri.com">
                                                <i class="fas fa-envelope"></i> : info@twobrothersindia.com
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-12 col-sm-6">
                                        <p class="phead" style="width:100%">Maharashtra</p>
                                    </div>
                                </div>
                                <?php }else{ ?>
                                 <div class="row">
                                    <div class="col-md-12 col-sm-6">
                                        <p class="phead" style="width:100%;">Customer Care</p>
                                        <p class="phead" style="width:100%">Manager - <?= $name ?></p>
                                        <p class="phead" style="width:100%">
                                            <a href="tel:0836-2356704">
                                                <i class="fas fa-mobile"></i> : +91-<?= $contact ?>
                                            </a>
                                        </p>
                                        <p class="phead" style="width:100%">
                                            <a href="mailto:lion.agri@lionsagri.com">
                                                <i class="fas fa-envelope"></i> : <?= $email ?>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-12 col-sm-6">
                                        <p class="phead" style="width:100%"><?= $address ?></p>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>



                    
                </div> <!-- End of single accordion container -->
            </div>

        </div>
    </div>
</div>

    <!-- /.card-body -->
    <div class="card-footer" style="background:rgba(254, 254, 253, 0.4);backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <div class="row text-center" >
            <div class="col-md-12 col-sm-12">
                <br>
                <!-- <span>Powered By &nbsp;&nbsp; <img src="https://www.scalion.com/kisaanqr/assets/images/logo.png" style="width: 7rem;"/></span> -->
                <span>Powered By &nbsp;&nbsp; <img src="<?php echo base_url('assets/images/trace-logo.png') ?>" style="width: 7rem;"/></span>

            </div>
        </div>
    </div>
  </div>
  <!-- /.card -->
</div>

<!-- register product modal -->
<div class="modal fade" id="registerProductModal" tabindex="-1" aria-labelledby="registerProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerProductModalLabel">Warranty Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form -->
                        <form id="registerProductForm" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name"  name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile *</label>
                                <input type="tel" class="form-control" id="mobile"   name="mobile" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location *</label>
                                <input type="text" class="form-control" id="location"   name="location" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"  >
                            </div>
                            <div class="mb-3">
                                <label for="productPurchased" class="form-label">Product Purchased</label>
                                <input type="text" class="form-control" id="productpurchased" name="product_purchased"  >
                            </div>
                            <div class="mb-3">
                                <label for="batchNumber" class="form-label">Product/Batch Number</label>
                                <input type="text" class="form-control" id="batchNumber"  name="batch_no" >
                                <div id="batchValidation" class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="purchaseSource" class="form-label">Where did you buy it from?</label>
                                <input type="text" class="form-control" id="purchaseSource" name="purchase_source" >
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Request Modal -->
<div class="modal fade" id="supportRequestModal" tabindex="-1" aria-labelledby="supportRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supportRequestModalLabel">Support Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supportRequestForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="relatedTo" class="form-label">Related To</label>
                        <select class="form-control" id="relatedTo" name="relatedTo" required>
                            <option value="">Select an option</option>
                            <option value="Sales">Sales</option>
                            <option value="Support">Support</option>
                            <option value="Technical">Technical</option>
                            <option value="Complaints">Complaints</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- /.company-box -->  
<!-- <div class="overlay" id="overlay"></div> -->
  <div class="popup" id="popup">
    <!-- <span class="close" onclick="closePopup()">&times;</span> -->
    
    <?php
    // Assuming $leaflet contains the file name with extension (e.g., file.pdf or file.png)
    // $fileExtension = pathinfo($leaflet, PATHINFO_EXTENSION);
    
    // // Define an array of allowed file extensions
    // $allowedImageExtensions = ['png', 'jpeg', 'jpg', 'gif'];
    
    // if (in_array($fileExtension, $allowedImageExtensions)) {
    //     // Display as an image for allowed file types
    //     echo '<img src="' . base_url() . '/uploads/' . $leaflet . '" alt="Image">';
    // } elseif ($fileExtension === 'pdf') {
    //     // Display as a link for PDF files
    //     echo '<a href="' . base_url() . '/uploads/' . $leaflet . '" target="_blank">View PDF</a>';
    // } else {
    //     // Handle other file types if needed
    //     echo 'Unsupported file type';
    // }
?>
</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js" ></script>
<script>
    // Function to open the popup
    function openPopup() {
      document.getElementById('overlay').style.display = 'block';
      document.getElementById('popup').style.display = 'block';
    }

    // Function to close the popup
    function closePopup() {
      document.getElementById('overlay').style.display = 'none';
      document.getElementById('popup').style.display = 'none';
    }

    // Attach click event to the link
    document.getElementById('openPopup').addEventListener('click', openPopup);

//     $(document).on('click','#productinfo',function(){
// 	$(".plabel").toggleClass("hidden");
// });

// $(document).on('click','#usageinfo',function(){
// 	$(".ulabel").toggleClass("hidden");
// });
// $(document).on('click','#mediainfo',function(){
// 	$(".mlabel").toggleClass("hidden");
// });
// $(document).on('click','#manufacturerinfo',function(){
// 	$(".mdlabel").toggleClass("hidden");
// });


// $(document).on('click','#tracinginfo',function(){
// 	$(".tlabel").toggleClass("hidden");
// });

//     $(document).on('click','#bluelabel',function(){
//         $(".blabel").toggleClass("hidden");
//     });

$(document).ready(function () {
    $('#registerProductForm').on('submit', function (e) {
        e.preventDefault();
        console.log('hey');

        $.ajax({
            url: "<?php echo base_url('PublicController/register_product'); ?>",
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status) {
                    // alert(response.message);
                    $('#registerProductModal').modal('hide');
                    $('#registerProductForm')[0].reset();
                    Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Product registered successfully!',                  
                    showConfirmButton: false,
                    timer: 3000
                  }); 
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('An error occurred while processing the request.');
            }
        });
    });
});




  </script>