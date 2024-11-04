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
                                        <?php echo form_open_multipart('hasil-laporan-rencana-belajar'); ?>
                                            <fieldset>

                                                <div class="form-group col-md-6">
                                                    <label>Tahun</label>
                                                    <select class="form-control" type="text" required name="tanggal">
                                                        <?php for ($i = date("Y")-5; $i <=date("Y"); $i++) { ?>
                                                            <option value="<?= $i ?>"> <?= $i ?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <button class="btn btn-primary" type="submit">Cari</button>
                                                </div>
                                                
                                            </fieldset>                                    
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


                                                                
                                                                    
                                                                
                                                            