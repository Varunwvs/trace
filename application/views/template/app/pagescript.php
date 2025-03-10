<?php
    if($_SESSION['comcat']==="1"){
        $fname = "seed";
    }
    elseif($_SESSION['comcat']==="2"){
        $fname = "fertilizer";
    }
    elseif($_SESSION['comcat']==="3"){
        $fname = "microirrigation";
    }
    if($_SESSION['comcat']==="4"){
        $fname = "chemicals";
    }
    if($_SESSION['comcat']==="5"){
        $fname = "pesticide";
    }
    if($_SESSION['comcat']==="6"){
        $fname = "fertilizer";
    }
    if($_SESSION['comcat']==="7"){
        $fname = "tarpaulin";
    }
?>
<script src="<?php echo base_url('assets/js/app/'.$fname.'/'.$pgScript.'.js')?>"></script>