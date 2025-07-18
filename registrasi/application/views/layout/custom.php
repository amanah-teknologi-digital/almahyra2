<script src="<?= base_url().'dist-assets/'?>js/plugins/jquery-3.3.1.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/plugins/bootstrap.bundle.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/scripts/script.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/scripts/sidebar.compact.script.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/scripts/customizer.script.min.js"></script>

<script src="<?= base_url().'dist-assets/'?>js/plugins/sweetalert2.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/scripts/sweetalert.script.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/custom/custom.modal.script.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/custom/custom.datatables.script.js"></script>

<script src="<?= base_url().'dist-assets/'?>js/plugins/jquery.smartWizard.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/plugins/smart.wizard.script.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/plugins/jquery.validate.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/plugins/quill.min.js"></script>

<!-- select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url().'dist-assets/'?>js/custom/custom.select2.script.js"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoN19J_VK6v-iprG-eYCbmNIvZPhtn0Ww" defer></script>

<script type="text/javascript">
	<?php if (!empty($_SESSION['success'])) { ?>
	   swal({
            title: 'Berhasil',
            text : '<?=$_SESSION["success"] ?>',
            type : 'success',
            confirmButtonColor: '#4fa7f3'
        });
	<?php unset($_SESSION['success']); } ?>

	<?php if (!empty($_SESSION['failed'])) { ?>
		swal({
            title: 'Failed',
            text : '<?=$_SESSION["failed"] ?>',
            type : 'error',
            confirmButtonColor: '#d57171'
        });
	<?php unset($_SESSION['failed']); } ?>

    <?php if (!empty($_SESSION['info'])) { ?>
        swal({
            title: 'Info',
            text : '<?=$_SESSION["info"] ?>',
            type : 'info',
            confirmButtonColor: '#d57171'
        });
    <?php unset($_SESSION['info']); } ?>

    if ('#tbl') {
        $('#tbl').dataTable({
            "ordering": false,
            "searching": true,
            "info": true,
            "lengthMenu": [[15, 25, 50, 100, 200, -1], [15, 25, 50, 100, 200, "Tampilkan Semua"]]
        });
    }

    if ('#tbl-catat') {
        $('#tbl-catat').dataTable({
            "ordering": false,
            "searching": true,
            "info": true,
            "lengthMenu": [[-1], ["Tampilkan Semua"]]
        });
    }

    if ('#tbl2') {
        $('#tbl2').dataTable({
            "ordering": false,
            "searching": true,
            "lengthChange": false,
            "bPaginate": false
        });
    }
</script>