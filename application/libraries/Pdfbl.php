<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdfbl extends TCPDF
{
    function __construct()
    {
        parent::__construct();
        ini_set("display_errors", 1);
    }

    // public function Header() {
    //     // Path to your background image
    //     $pageWidth = $this->getPageWidth();
    //     $pageHeight = $this->getPageHeight();
        
    //     // Set the desired width and height for the image
    //     $imageWidth = 140.2; // for example, 100 units wide
    //     $imageHeight = 75.2; // for example, 100 units high
        
    //     // Calculate x and y coordinates to center the image
    //     $x = ($pageWidth - $imageWidth) / 2;
    //     $y = ($pageHeight - $imageHeight) / 2;
    //     $img_file = './assets/images/bluelab.jpg'; // or use the absolute path
    //     if (file_exists($img_file)) {
    //         $this->Image($img_file, 0, 0, $pageWidth, $pageHeight, '', '', '', false, 300, '', false, false, 0);
    //     }
    // }

}
/*Author:Tutsway.com */  
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */

