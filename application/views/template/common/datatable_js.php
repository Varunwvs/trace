<!-- DataTables  & Plugins -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/jszip/jszip.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/pdfmake/pdfmake.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/pdfmake/vfs_fonts.js')?>"></script>
<?php if($pgScript==="batchview") : ?>
        
<?php else : ?>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>
<?php endif ?>