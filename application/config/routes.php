<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*=-=-=-=-=- Starts Login / Signup -=-=-=-=-=*/
    $route['default_controller'] = 'HomeController';
    $route['home'] = 'HomeController';
    $route['logout'] = 'HomeController/logout';
    $route['signup'] = 'HomeController/signup';
/*=-=-=-=-=- Ends Login / Signup -=-=-=-=-=*/

/*=-=-=-=-=- Starts Super Admin -=-=-=-=-=*/
    $route['super_admin_dashboard'] = 'SuperAdminController';
    $route['manageseedcompany'] = 'SuperAdminController/manageseedcompany';
    $route['manageseedrcholder'] = 'SuperAdminController/manageseedrcholder';
    $route['manageflcompany'] = 'SuperAdminController/manageflcompany';
    $route['manageflrcholder'] = 'SuperAdminController/manageflrcholder';
    $route['managepscompany'] = 'SuperAdminController/managepscompany';
    $route['managepsrcholder'] = 'SuperAdminController/managepsrcholder';
    $route['managetpcompany'] = 'SuperAdminController/managetpcompany';
    $route['managetprcholder'] = 'SuperAdminController/managetprcholder';
    $route['managemicompany'] = 'SuperAdminController/managemicompany';
    $route['managemircholder'] = 'SuperAdminController/managemircholder';
    $route['companyadd'] = 'SuperAdminController/companyadd';
    $route['companyedit'] = 'SuperAdminController/companyedit';
    $route['rcholderadd'] = 'SuperAdminController/rcholderadd';
    $route['rcholderedit'] = 'SuperAdminController/rcholderedit';
    $route['manageadmin'] = 'SuperAdminController/manageadmin';
    $route['adminadd'] = 'SuperAdminController/adminadd';
    $route['centerview'] = 'SuperAdminController/centerview';
    $route['adminedit'] = 'SuperAdminController/adminedit';
    $route['super_admin_profile'] = 'SuperAdminController/super_admin_profile';
    $route['client_report'] = 'SuperAdminController/client_report';
/*=-=-=-=-=- Ends Super Admin -=-=-=-=-=*/

/*=-=-=-=-=- Starts Admin -=-=-=-=-=*/
    $route['admin_dashboard'] = 'AdminController';
    $route['admin_manage_center'] = 'AdminController/admin_manage_center';
    $route['admin_add_center'] = 'AdminController/admin_add_center';
    $route['admin_view_center'] = 'AdminController/admin_view_center';
    $route['admin_edit_center'] = 'AdminController/admin_edit_center';
    $route['admin_manage_product'] = 'AdminController/admin_manage_product';
    $route['admin_add_product'] = 'AdminController/admin_add_product';
    $route['admin_view_product'] = 'AdminController/admin_view_product';
    $route['admin_edit_product'] = 'AdminController/admin_edit_product';
    $route['admin_import_product'] = 'AdminController/admin_import_product';
    $route['admin_profile'] = 'AdminController/admin_profile';
    //mi product
    $route['admin_add_product_mi'] = 'AdminController/admin_add_product_mi';
/*=-=-=-=-=- Ends Admin -=-=-=-=-=*/

/*=-=-=-=-=- Starts Seed -=-=-=-=-=*/
    $route['sdashboard'] = 'SeedController';
    $route['help'] = 'SeedController/help';
    $route['searchresult'] = 'SeedController/searchresult';
    $route['productimport'] = 'SeedController/productimport';
    $route['userprofile'] = 'SeedController/userprofile';
    //product starts
    $route['productmanages'] = 'SeedController/productmanages';
    $route['productmanage'] = 'SeedController/productmanage';
    $route['productentry'] = 'SeedController/productentry';
    $route['productedit'] = 'SeedController/productedit';
    $route['productview'] = 'SeedController/productview';
    //Batch Starts
    $route['batchentry'] = 'SeedController/batchentry';
    $route['batchview'] = 'SeedController/batchview';
    $route['batchedit'] = 'SeedController/batchedit';
    $route['serialqrcodeprint'] = 'SeedController/serialqrcodeprint';
    $route['serialnqrcodeprint'] = 'SeedController/serialnqrcodeprint';
    $route['serialgqrcodeprint'] = 'SeedController/serialgqrcodeprint';
    $route['batchfullqrcode'] = 'SeedController/batchfullqrcode';
    $route['batchsmallqrcode'] = 'SeedController/batchsmallqrcode';
    $route['batchxsmallqrcode'] = 'SeedController/batchxsmallqrcode';
    $route['batchgreenqrcode'] = 'SeedController/batchgreenqrcode';
    $route['batchexport'] = 'SeedBulkImport/batch_export';
    //Containers Starts
    $route['containermanage'] = 'SeedController/containermanage';
    $route['containerentry'] = 'SeedController/containerentry';
    $route['containeredit'] = 'SeedController/containeredit';
    $route['containerqrcode'] = 'SeedController/containerqrcode';
    $route['containernqrcode'] = 'SeedController/containernqrcode';
    $route['containersmallqrcode'] = 'SeedController/containersmallqrcode';
    $route['containerexport'] = 'SeedBulkImport/container_export';
    $route['help'] = 'SeedController/help';
    //kkisan seed api
    $route['save_secondary_container_details'] = 'SeedController/get_container_code';
    $route['kkisaanapi'] = 'ApiController/api';
    $route['kkisaanapi_post'] = 'ApiController/api_post';
    $route['generate_token'] = 'ApiController/generate_token';
    $route['unit_measurement'] = 'ApiController/getUnitOfMeasurements';
    $route['save_product_master'] = 'ApiController/saveProductMaster';
    $route['save_qr_detail'] = 'ApiController/saveQRDetail';
    $route['save_secondary_container_detail'] = 'ApiController/get_container_code';
    $route['kkisaanapi_batch_post'] = 'ApiController/batch_api_post';
    //private product starts
    $route['psdproductmanage'] = 'SeedController/psdproductmanage';
    $route['psdproductentry'] = 'SeedController/psdproductentry';
    $route['psdproductview'] = 'SeedController/psdproductview';
    $route['psdbatchentry'] = 'SeedController/psdbatchentry';
    $route['psdbatchview'] = 'SeedController/psdbatchview';
    $route['psdpublicpageqrcode'] = 'SeedController/publicpageqrcode';
    //last year data
    $route['lyproductmanage'] = 'SeedController/lyproductmanage';
    $route['lyproductview'] = 'SeedController/lyproductview';
    $route['lybatchview'] = 'SeedController/lybatchview';

    $route['batchsmallqrcodepri_sec'] = 'SeedController/batchsmallqrcodepri_sec';
    
/*=-=-=-=-=- Ends Seed -=-=-=-=-=*/

/*=-=-=-=-=- Starts Fertilizer -=-=-=-=-=*/
    $route['fldashboard'] = 'FertilizerController';
    $route['flsearchresult'] = 'FertilizerController/searchresult';
    $route['flproductimport'] = 'FertilizerController/productimport';
    $route['fluserprofile'] = 'FertilizerController/userprofile';
    //product starts
    $route['flproductmanage'] = 'FertilizerController/productmanage';
    $route['flproductentry'] = 'FertilizerController/productentry';
    $route['flproductedit'] = 'FertilizerController/productedit';
    $route['flproductview'] = 'FertilizerController/productview';
    //Batch Starts
    $route['flbatchentry'] = 'FertilizerController/batchentry';
    $route['flbatchview'] = 'FertilizerController/batchview';
    $route['flbatchedit'] = 'FertilizerController/batchedit';
    $route['flprimarysinglesmallqrcode'] = 'FertilizerController/primarysinglesmallqrcode';
    $route['flprimarysinglefullqrcode'] = 'FertilizerController/primarysinglefullqrcode';
    $route['flprimaryfullsmallqrcode'] = 'FertilizerController/primaryfullsmallqrcode';
    $route['flprimaryfullbatchqrcode'] = 'FertilizerController/primaryfullbatchqrcode';
    $route['flbatchgreenqrcode'] = 'FertilizerController/batchgreenqrcode';
    $route['flbatchxsmallqrcode'] = 'FertilizerController/batchxsmallqrcode';
    $route['flcontainerentry'] = 'FertilizerController/containerentry';
    $route['flsecondaryfullqrcode'] = 'FertilizerController/secondaryfullqrcode';
    $route['flhelp'] = 'FertilizerController/help';
    $route['flbatchexport'] = 'FertilizerBulkImport/batch_export';
    //kkisan seed api
    $route['fl_save_secondary_container_details'] = 'FertilizerController/get_container_code';
    $route['flkkisaanapi'] = 'FlApiController/api';
    $route['flkkisaanapi_post'] = 'FlApiController/api_post';
    $route['flgenerate_token'] = 'FlApiController/generate_token';
    $route['flunit_measurement'] = 'FlApiController/getUnitOfMeasurements';
    $route['flsave_product_master'] = 'FlApiController/saveProductMaster';
    $route['flsave_qr_detail'] = 'FlApiController/saveQRDetail';
    $route['flsave_secondary_container_detail'] = 'FlApiController/get_container_code';
    $route['flkkisaanapi_batch_post'] = 'FlApiController/batch_api_post';
    $route['flkkisaanapi_item_details'] = 'ApiDataController/item_details';
    $route['flkkisaanapi_item_sub_cat'] = 'ApiDataController/item_sub_cat';
    $route['flyproductmanage'] = 'FertilizerController/lyproductmanage';
    $route['flyproductview'] = 'FertilizerController/lyproductview';
    $route['flybatchview'] = 'FertilizerController/lybatchview';
/*=-=-=-=-=- Ends Fertilizer -=-=-=-=-=*/

/*=-=-=-=-=- Starts Pesticide -=-=-=-=-=*/
    $route['psdashboard'] = 'PesticideController';
    $route['pssearchresult'] = 'PesticideController/searchresult';
    $route['psproductimport'] = 'PesticideController/productimport';
    $route['psbproductimport'] = 'PesticideController/psbproductimport';
    $route['psuserprofile'] = 'PesticideController/userprofile';
    //product starts
    $route['psproductmanage'] = 'PesticideController/productmanage';
    $route['psproductentry'] = 'PesticideController/productentry';
    $route['psproductedit'] = 'PesticideController/productedit';
    $route['psproductview'] = 'PesticideController/productview';
    //Batch Starts
    $route['psbatchentry'] = 'PesticideController/batchentry';
    $route['psbatchview'] = 'PesticideController/batchview';
    $route['psbatchedit'] = 'PesticideController/batchedit';
    $route['psprimarysinglesmallqrcode'] = 'PesticideController/primarysinglesmallqrcode';
    $route['psprimarysinglefullqrcode'] = 'PesticideController/primarysinglefullqrcode';
    $route['psprimaryfullsmallqrcode'] = 'PesticideController/primaryfullsmallqrcode';
    $route['psprimaryfullbatchqrcode'] = 'PesticideController/primaryfullbatchqrcode';
    $route['psbatchxsmallqrcode'] = 'PesticideController/batchxsmallqrcode';
    $route['pspublicpageqrcode'] = 'PesticideController/publicpageqrcode';
    
    $route['batchblueqrcode'] = 'SeedController/batchblueqrcode';
    
    //Container starts
    $route['pscontainerentry'] = 'PesticideController/containerentry';
    $route['pssecondaryfullqrcode'] = 'PesticideController/secondaryfullqrcode';
    $route['pssecondarysinglefullqrcode'] = 'PesticideController/secondarysinglefullqrcode';
    $route['pssecondarysingleqrcode'] = 'PesticideController/secondarysingleqrcode';
    $route['psbatchexport'] = 'PSBulkImport/batch_export';
    $route['ppsbatchexport'] = 'PSBulkImport/pbatch_export';
    //private product starts
    $route['ppsproductmanage'] = 'PesticideController/ppsproductmanage';
    $route['ppsproductentry'] = 'PesticideController/ppsproductentry';
    $route['ppsproductview'] = 'PesticideController/ppsproductview';
    $route['ppsbatchentry'] = 'PesticideController/ppsbatchentry';
    $route['ppsbatchview'] = 'PesticideController/ppsbatchview';
    $route['pshelp'] = 'PesticideController/help';
    $route['plybatchxsmallqrcode'] = 'PesticideController/plybatchxsmallqrcode';
    //kkisan seed api
    $route['ps_save_secondary_container_details'] = 'PesticideController/get_container_code';
    $route['pskkisaanapi'] = 'PSApiController/api';
    $route['pskkisaanapi_post'] = 'PSApiController/api_post';
    $route['psgenerate_token'] = 'PSApiController/generate_token';
    $route['psunit_measurement'] = 'PSApiController/getUnitOfMeasurements';
    $route['pssave_product_master'] = 'PSApiController/saveProductMaster';
    $route['pssave_qr_detail'] = 'PSApiController/saveQRDetail';
    $route['pssave_secondary_container_detail'] = 'PSApiController/get_container_code';
    $route['pskkisaanapi_batch_post'] = 'PSApiController/batch_api_post';
    $route['pskkisaanapi_item_details'] = 'ApiDataController/item_details';
    $route['pskkisaanapi_item_sub_cat'] = 'ApiDataController/item_sub_cat';
    $route['plyproductmanage'] = 'PesticideController/lyproductmanage';
    $route['plyproductview'] = 'PesticideController/lyproductview';
    $route['plybatchview'] = 'PesticideController/lybatchview';
/*=-=-=-=-=- Ends Pesticide -=-=-=-=-=*/

$route['containerapi'] = 'CronController/auto_send_container_api';

/*=-=-=-=-=- Starts Tarpaulin -=-=-=-=-=*/
    $route['tpdashboard'] = 'TarpaulinController';
    $route['tpsearchresult'] = 'TarpaulinController/searchresult';
    $route['tpproductimport'] = 'TarpaulinController/productimport';
    $route['tpuserprofile'] = 'TarpaulinController/userprofile';
    //product starts
    $route['tpproductmanage'] = 'TarpaulinController/productmanage';
    $route['tpproductentry'] = 'TarpaulinController/productentry';
    $route['tpproductedit'] = 'TarpaulinController/productedit';
    $route['tpproductview'] = 'TarpaulinController/productview';    
    //Batch Starts
    $route['tpbatchentry'] = 'TarpaulinController/batchentry';
    $route['tpbatchview'] = 'TarpaulinController/batchview';
    $route['tpbatchedit'] = 'TarpaulinController/batchedit';
    $route['tpprimarysinglesmallqrcode'] = 'TarpaulinController/primarysinglesmallqrcode';
    $route['tpprimarysinglefullqrcode'] = 'TarpaulinController/primarysinglefullqrcode';
    $route['tpprimaryfullsmallqrcode'] = 'TarpaulinController/primaryfullsmallqrcode';
    $route['tpprimaryfullbatchqrcode'] = 'TarpaulinController/primaryfullbatchqrcode';
    $route['tpbatchxsmallqrcode'] = 'TarpaulinController/batchxsmallqrcode';
    $route['tppublicpageqrcode'] = 'TarpaulinController/publicpageqrcode';
    $route['tppublicpageqrcodev'] = 'TarpaulinController/publicpageqrcodev';
    //Container starts
    $route['tpcontainerentry'] = 'TarpaulinController/containerentry';
    $route['tpsecondaryfullqrcode'] = 'TarpaulinController/secondaryfullqrcode';
    $route['tpsecondarysinglefullqrcode'] = 'TarpaulinController/secondarysinglefullqrcode';
    $route['tpsecondarysingleqrcode'] = 'TarpaulinController/secondarysingleqrcode';
    $route['tpbatchgreyqrcode'] = 'TarpaulinController/batchgreyqrcode';
    $route['tpbatchexport'] = 'tpBulkImport/batch_export';
    $route['tphelp'] = 'TarpaulinController/help';
    //private product starts
    $route['ptpproductmanage'] = 'TarpaulinController/ptpproductmanage';
    $route['ptpproductentry'] = 'TarpaulinController/ptpproductentry';
    $route['ptpproductview'] = 'TarpaulinController/ptpproductview';
    $route['ptpbatchentry'] = 'TarpaulinController/ptpbatchentry';
    $route['ptpbatchview'] = 'TarpaulinController/ptpbatchview';
    //kkisan seed api
    $route['tp_save_secondary_container_details'] = 'TarpaulinController/get_container_code';
    $route['tpkkisaanapi'] = 'TPApiController/api';
    $route['tpkkisaanapi_post'] = 'TPApiController/api_post';
    $route['tpgenerate_token'] = 'TPApiController/generate_token';
    $route['tpunit_measurement'] = 'TPApiController/getUnitOfMeasurements';
    $route['tpsave_product_master'] = 'TPApiController/saveProductMaster';
    $route['tpsave_qr_detail'] = 'TPApiController/saveQRDetail';
    $route['tpsave_secondary_container_detail'] = 'TPApiController/get_container_code';
    $route['tpkkisaanapi_batch_post'] = 'TPApiController/batch_api_post';
    $route['tpkkisaanapi_item_details'] = 'ApiDataController/item_details';
    $route['tpkkisaanapi_item_sub_cat'] = 'ApiDataController/item_sub_cat';
    $route['tlyproductmanage'] = 'TarpaulinController/lyproductmanage';
    $route['tlyproductview'] = 'TarpaulinController/lyproductview';
    $route['tlybatchview'] = 'TarpaulinController/lybatchview';
/*=-=-=-=-=- Ends Tarpaulin -=-=-=-=-=*/

/*=-=-=-=-=- Starts Micro Irrigation -=-=-=-=-=*/
    $route['midashboard'] = 'MicroirrigationController';
    $route['misearchresult'] = 'MicroirrigationController/searchresult';
    $route['miproductimport'] = 'MicroirrigationController/productimport';
    $route['miuserprofile'] = 'MicroirrigationController/userprofile';
    //product starts
    $route['miproductmanage'] = 'MicroirrigationController/productmanage';
    $route['miproductentry'] = 'MicroirrigationController/productentry';
    $route['miproductedit'] = 'MicroirrigationController/productedit';
    $route['miproductview'] = 'MicroirrigationController/productview';    
    //Batch Starts
    $route['mibatchentry'] = 'MicroirrigationController/batchentry';
    $route['mibatchview'] = 'MicroirrigationController/batchview';
    $route['mibatchedit'] = 'MicroirrigationController/batchedit';
    $route['miprimarysinglesmallqrcode'] = 'MicroirrigationController/primarysinglesmallqrcode';
    $route['miprimarysinglefullqrcode'] = 'MicroirrigationController/primarysinglefullqrcode';
    $route['miprimaryfullsmallqrcode'] = 'MicroirrigationController/primaryfullsmallqrcode';
    $route['miprimaryfullbatchqrcode'] = 'MicroirrigationController/primaryfullbatchqrcode';
    $route['mibatchxsmallqrcode'] = 'MicroirrigationController/batchxsmallqrcode';
    $route['milybatchxsmallqrcode'] = 'MicroirrigationController/milybatchxsmallqrcode';
    $route['mipublicpageqrcode'] = 'MicroirrigationController/publicpageqrcode';
    $route['mipublicpageqrcodev'] = 'MicroirrigationController/publicpageqrcodev';
    //Container starts
    $route['micontainerentry'] = 'MicroirrigationController/containerentry';
    $route['misecondaryfullqrcode'] = 'MicroirrigationController/secondaryfullqrcode';
    $route['misecondarysinglefullqrcode'] = 'MicroirrigationController/secondarysinglefullqrcode';
    $route['misecondarysingleqrcode'] = 'MicroirrigationController/secondarysingleqrcode';
    $route['eibarcode'] = 'MicroirrigationController/eibarcode';
    $route['mibatchexport'] = 'MIBulkImport/batch_export';
    $route['mihelp'] = 'MicroirrigationController/help';
    //kkisan seed api
    $route['mi_save_secondary_container_details'] = 'MicroirrigationController/get_container_code';
    $route['mikkisaanapi'] = 'MIApiController/api';
    $route['mikkisaanapi_post'] = 'MIApiController/api_post';
    $route['migenerate_token'] = 'MIApiController/generate_token';
    $route['miunit_measurement'] = 'MIApiController/getUnitOfMeasurements';
    $route['misave_product_master'] = 'MIApiController/saveProductMaster';
    $route['misave_qr_detail'] = 'MIApiController/saveQRDetail';
    $route['misave_secondary_container_detail'] = 'MIApiController/get_container_code';
    $route['mikkisaanapi_batch_post'] = 'MIApiController/batch_api_post';
    $route['mikkisaanapi_item_details'] = 'ApiDataController/item_details';
    $route['mikkisaanapi_item_sub_cat'] = 'ApiDataController/item_sub_cat'; 
    $route['mlyproductmanage'] = 'MicroirrigationController/lyproductmanage';
    $route['mlyproductview'] = 'MicroirrigationController/lyproductview';
    $route['mlybatchview'] = 'MicroirrigationController/lybatchview';
/*=-=-=-=-=- Ends Micro Irrigation -=-=-=-=-=*/

/*=-=-=-=-=- Public Routes -=-=-=-=*/
$route['k'] = 'PublicController';
$route['pv'] = 'PublicController/productview';
$route['bv'] = 'PublicController/batchview';
$route['sb/(.+)'] = 'PublicController/pp';
$route['sb1/(.+)'] = 'PublicController/pps';

$route['qrcodecheck']='PublicController/qrcodecheck';
$route['getApiData']='PublicController/get_api_data';


$route['productcheck']='PublicController/productcheck';
$route['getProductData']='PublicController/get_product_data';




// sourcing categorymanage
$route['categorymanage']='SeedController/categorymanage';
$route['categoryentry']='SeedController/categoryentry';
$route['categoryedit']='SeedController/categoryedit';
$route['subcategoryedit']='SeedController/subcategoryedit';

//vendor
$route['vendormanage']='SeedController/vendormanage';
$route['vendorentry']='SeedController/vendorentry';
$route['vendoredit']='SeedController/vendoredit';

$route['rawmaterialmanage']='SeedController/rawmaterialmanage';
$route['rawmaterialentry']='SeedController/rawmaterialentry';
$route['rawmaterialedit']='SeedController/rawmaterialedit';

$route['sourcingmanage']='SeedController/sourcingmanage';
$route['sourcingentry']='SeedController/sourcingentry';
$route['sourcingedit']='SeedController/sourcingedit';

$route['processingmanage']='SeedController/processingmanage';
$route['processingentry']='SeedController/processingentry';
$route['processingedit']='SeedController/processingedit';
$route['addmoresourcing']='SeedController/processingentry';


// Farmer Module
$route['farmermanage']='FarmerController/farmermanage';
$route['farmerprofileentry']='FarmerController/farmerprofileentry';

$route['cropmanage']='FarmerController/cropmanage';
$route['cropentry']='FarmerController/cropentry';

$route['farmingactivitymanage']='FarmerController/farmingactivitymanage';
$route['farmingactivityentry']='FarmerController/farmingactivityentry';

$route['inputmanage']='FarmerController/inputmanage';
$route['inputentry']='FarmerController/inputentry';

// export and import
$route['eiprofilemanage']='FarmerController/eiprofilemanage';
$route['eiprofileentry']='FarmerController/eiprofileentry';

//orders
$route['ordersmanage']='FarmerController/ordersmanage';
$route['orderentry']='FarmerController/orderentry';

//dispatch
$route['dispatchmanage']='FarmerController/dispatchmanage';
$route['dispatchentry']='FarmerController/dispatchentry';


//Logistics
$route['vehiclemanage']='LogisticsController/vehiclemanage';
$route['vehicleentry']='LogisticsController/vehicleentry';
$route['drivermanage']='LogisticsController/drivermanage';
$route['driverentry']='LogisticsController/driverentry';


//dealer
$route['dealermanage']='FarmerController/dealermanage';
$route['dealerentry']='FarmerController/dealerentry';

//location
$route['locationmanage']='FarmerController/locationmanage';
$route['locationentry']='FarmerController/locationentry';

//registered product from public page 
$route['regproductmanage']='FarmerController/regproductmanage';

//harvesting manage
$route['harvestingmanage']='FarmerController/harvestingmanage';
$route['harvestentry']='FarmerController/harvestentry';

// labourmanage
$route['labourmanage']='FarmerController/labourmanage';
$route['labourentry']='FarmerController/labourentry';
$route['labourhygiene']='FarmerController/labourhygiene';



// taskmanage
$route['taskmanage']='FarmerController/taskmanage';
$route['taskentry']='FarmerController/taskentry';

// warehousemanage
$route['warehousemanage']='FarmerController/warehousemanage';
$route['warehouseentry']='FarmerController/warehouseentry';

// transfermanage
$route['transfermanage']='FarmerController/transfermanage';
$route['transferentry']='FarmerController/transferentry';

//trace product manage
$route['tproductmanage'] = 'SeedController/tproductmanage';
$route['tproductentry'] = 'SeedController/tproductentry';
$route['tproductview'] = 'SeedController/tproductview';
$route['tproductedit'] = 'SeedController/tproductedit';


//Carbon Accounting
$route['ca_locationmanage'] = 'CarbonAccountingController/calocationmanage';
$route['calocationentry'] = 'CarbonAccountingController/calocationentry';
$route['ca_vehiclemanage'] = 'CarbonAccountingController/cavehiclemanage';
$route['cavehicleentry'] = 'CarbonAccountingController/cavehicleentry';
$route['ca_equipmentmanage'] = 'CarbonAccountingController/caequipmentmanage';
$route['caequipmententry'] = 'CarbonAccountingController/caequipmententry';
$route['scope1entry'] = 'CarbonAccountingController/scope1entry';
$route['scope2entry'] = 'CarbonAccountingController/scope2entry';
$route['scope3entry'] = 'CarbonAccountingController/scope3entry';

//Live Stock Management
$route['animalregistrationmanage'] = 'LiveStockManagementController/animalregistrationmanage';
$route['animalregistrationentry'] = 'LiveStockManagementController/animalregistrationentry';
$route['animalvaccinationmanage'] = 'LiveStockManagementController/animalvaccinationmanage';
$route['animalvaccinationentry'] = 'LiveStockManagementController/animalvaccinationentry';

$route['animaldewormingmanage'] = 'LiveStockManagementController/animaldewormingmanage';
$route['animaldewormingentry'] = 'LiveStockManagementController/animaldewormingentry';
$route['animalveterinarymanage'] = 'LiveStockManagementController/animalveterinarymanage';
$route['animalveterinaryentry'] = 'LiveStockManagementController/animalveterinaryentry';
$route['animalmedicationmanage'] = 'LiveStockManagementController/animalmedicationmanage';
$route['animalmedicationentry'] = 'LiveStockManagementController/animalmedicationentry';
$route['animaldiseasemanage'] = 'LiveStockManagementController/animaldiseasemanage';
$route['animaldiseaseentry'] = 'LiveStockManagementController/animaldiseaseentry';
$route['animalmortalitymanage'] = 'LiveStockManagementController/animalmortalitymanage';
$route['animalmortalityentry'] = 'LiveStockManagementController/animalmortalityentry';

$route['animalbreedingmanage'] = 'LiveStockManagementController/animalbreedingmanage';
$route['animalbreedingentry'] = 'LiveStockManagementController/animalbreedingentry';
$route['animalfeedingmanage'] = 'LiveStockManagementController/animalfeedingmanage';
$route['animalfeedingentry'] = 'LiveStockManagementController/animalfeedingentry';
$route['animaldairymanage'] = 'LiveStockManagementController/animaldairymanage';
$route['animaldairyentry'] = 'LiveStockManagementController/animaldairyentry';
$route['milkingmanage'] = 'LiveStockManagementController/milkingmanage';
$route['animalinventorymanage'] = 'LiveStockManagementController/animalinventorymanage';
$route['animalinventoryentry'] = 'LiveStockManagementController/animalinventoryentry';
$route['animalfinancemanage'] = 'LiveStockManagementController/animalfinancemanage';
$route['animalfinanceentry'] = 'LiveStockManagementController/animalfinanceentry';
$route['animallabourmanage']='LiveStockManagementController/animallabourmanage';
$route['animallabourentry']='LiveStockManagementController/animallabourentry';





//for batch controller api management
$route['api/auth'] = 'AuthController/login';
$route['api/batch-insert'] = 'SeedBatchApiController/batch_insert';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
