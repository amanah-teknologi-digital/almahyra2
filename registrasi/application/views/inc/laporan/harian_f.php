<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            <?php $this->load->view('layout/navigation') ?>     

            <!-- =============== Horizontal bar End ================-->
            <div class="main-content-wrap d-flex flex-column">
                <?php $this->load->view('layout/header') ?>
                <!-- ============ Body content start ============= -->
                <div class="main-content">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="#">Laporan</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php echo form_open_multipart($controller.'/harianrppform'); ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Laporan Harian</h5>
                                                </div>
                                                <div class="modal-body">                                   
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label>Nama Anak</label>
                                                            <select class="form-control" type="text" required name="id">
                                                                <?php foreach ($list as $key =>$row) { ?>
                                                                    <option value="<?= ucwords($row->id) ?>"> <?= ucwords($row->nama) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Tanggal</label>
                                                            <input class="form-control" type="date" required name="tanggal">
                                                        </div>
                                                    </fieldset>     
                                                     <div class="modal-footer">
                                                        <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                                    </div>                               
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        var url = "<?= base_url() ?>";

        $('.edit').click(function(){
            
            window.location.href = url + 'hasil-laporan-harian/' + $(this).data('id');
            
            return false;
        })

    </script>
</html>


                                                                
                                                                    
                                                                
                                                            