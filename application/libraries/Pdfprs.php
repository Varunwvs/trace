<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdfprs extends TCPDF
{
    function __construct()
    {
        parent::__construct();
        ini_set("display_errors", 1);
    }

}
/*Author:Tutsway.com */  
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */

