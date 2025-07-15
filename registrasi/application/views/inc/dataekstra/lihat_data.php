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
                            <li><a href="#">Ekstrakulikuler</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Form Ekstrakulikuler</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="row mb-3 d-flex align-items-center justify-content-center">
                                        <h5 class="card-title text-center">Data Form Ekstrakulikuler&nbsp;<span class="text-success font-weight-bold"><?= $data_ekstra->nama ?></span></h5>
                                    </div>
                                    <div class="row mb-3 d-flex align-items-center justify-content-center">
                                        <div class="col-sm-12">
                                            <button class="btn btn-sm btn-primary btn-tambahkegiatan float-right" ><span class="fas fa-plus"></span>&nbsp;Tambah Form</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="display table table-sm table-striped table-bordered">
                                            <thead style="background-color: #bfdfff">
                                            <tr>
                                                <th align="center">No</th>
                                                <th align="center">Uraian Form</th>
                                                <th align="center">Nama Kolom</th>
                                                <th align="center">Jenis Input</th>
                                                <th align="center">Pilihan Standar</th>
                                                <th align="center" style="width: 20%">Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (count($data_formekstra) > 0){
                                                foreach ($data_formekstra as $key => $kegiatan){ ?>
                                                    <tr>
                                                        <td align="center"><?= $key+1; ?></td>
                                                        <td nowrap><?= $kegiatan->nama; ?></td>
                                                        <td nowrap><?= $kegiatan->kolom; ?></td>
                                                        <td nowrap><?= $kegiatan->jenis_kolom; ?></td>
                                                        <td nowrap>
                                                            <span class="text-muted font-italic text-small">
                                                                <?php if ($kegiatan->jenis_kolom == 'select'){  ?>
                                                                    <?php $pilihan_standar = json_decode($kegiatan->pilihan_standar, true);
                                                                        $jml_pil = count($pilihan_standar);
                                                                        foreach ($pilihan_standar as $key => $value){
                                                                            if ($key == $jml_pil-1){
                                                                                echo $value;
                                                                            }else{
                                                                                echo $value.', ';
                                                                            }
                                                                        }
                                                                    ?>
                                                                <?php } ?>
                                                            </span>
                                                        </td>
                                                        <td align="center" nowrap>
                                                            <span class="btn btn-sm btn-warning edit_kegiatan" data-id="<?= $kegiatan->id_formekstra ?>" data-nama="<?= $kegiatan->nama  ?>"><span class="fas fa-edit"></span>&nbsp;Update</span>
                                                            <span class="btn btn-sm btn-danger hapus_kegiatan" data-id="<?= $kegiatan->id_formekstra ?>" data-nama="<?= $kegiatan->nama  ?>"><span class="fas fa-times"></span>&nbsp;Hapus</span>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }else{ ?>
                                                <tr>
                                                    <td colspan="6" align="center"><span class="font-weight-bold text-danger text-small"><i>Data Form Kosong!</i></span></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Form bisa <b>diubah</b> sesuai kebutuhan dari segi penilaian sisi guru ekstrakulikuler.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <?php $this->load->view('layout/footer') ?>
                <!--  Modal -->
                <div class="modal fade" id="tambah-kegitan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/insertkegiatan', 'id="frm_tambahkegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Form Ekstra</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Uraian Form</label>
                                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kolom</label>
                                        <input type="text" name="nama_kolom" id="nama_kolom" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Input</label>
                                        <select name="jenis_kolom" id="jenis_kolom" class="form-control" onchange="refreshStandarPilihan(this, 'standarpilihan')">
                                            <option value="">-- Pilih Jenis Input</option>
                                            <option value="text">Text</option>
                                            <option value="number">Number</option>
                                            <option value="select">Pilihan</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="standarpilihan" style="display: none">
                                        <label>Standarisasi Pilihan</label>
                                        <select name="standarisasi[]" id="standarisasi" class="form-control tagselect" multiple="multiple" required>

                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_ekstra" value="<?= $id_ekstra ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="update-kegitan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/updatekegiatan', 'id="frm_updatekegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pembaharuan Form Ekstra</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Uraian Form</label>
                                        <input type="text" name="nama_kegiatan" id="nama_kegiatan_update" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kolom</label>
                                        <input type="text" name="nama_kolom" id="nama_kolom_update" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Input</label>
                                        <select name="jenis_kolom" id="jenis_kolom_update" class="form-control" onchange="refreshStandarPilihan(this, 'standarpilihan_update')">
                                            <option value="">-- Pilih Jenis Input</option>
                                            <option value="text">Text</option>
                                            <option value="number">Number</option>
                                            <option value="select">Pilihan</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="standarpilihan_update" style="display: none">
                                        <label>Standarisasi Pilihan</label>
                                        <select name="standarisasi[]" id="standarisasi_update" class="form-control tagselectupdate" multiple="multiple" required>

                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_formekstra" id="id_formekstra">
                        <input type="hidden" name="id_ekstra" value="<?= $id_ekstra ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="hapus-kegiatan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/hapuskegiatan', 'id="frm_hapuskegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Form Ekstra</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah yakin menghapus form <span class="font-weight-bold" id="label_nama_kegiatan_hapus"></span>? </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-danger ml-2" type="submit">Hapus</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_formekstra" id="id_formekstra_hapus">
                        <input type="hidden" name="id_ekstra" value="<?= $id_ekstra ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        let url = "<?= base_url().$controller ?>";

        $(document).ready(function() {
            $(".tagselect").select2({
                tags: true
            });

            $(".tagselectupdate").select2({
                tags: true
            });

            $('.btn-tambahkegiatan').click(function(){
                clearFormStatus("#frm_tambahkegiatan");
                $("#tambah-kegitan").modal('show');
            });

            $('.edit_kegiatan').click(function(){
                clearFormStatus('#frm_updatekegiatan')
                $('#standarpilihan_update').hide()

                let id_formekstra = $(this).data('id')

                $("#id_formekstra").val(id_formekstra);

                $.ajax({
                    url: url + '/editkegiatan/' + $(this).data('id'),
                    type:'GET',
                    dataType: 'json',
                    success: function(data){
                        let data_kegiatan = data['list_edit'];
                        let pilihan_standar = [];

                        if (data_kegiatan['pilihan_standar'] != null){
                            pilihan_standar = JSON.parse(data_kegiatan['pilihan_standar']);
                            pilihan_standar = Object.values(pilihan_standar);
                            $('#standarpilihan_update').show()
                        }

                        console.log(pilihan_standar)

                        $("#nama_kegiatan_update").val(data_kegiatan['nama']);
                        $("#nama_kolom_update").val(data_kegiatan['kolom']);
                        $("#jenis_kolom_update").val(data_kegiatan['jenis_kolom']);


                        $('.tagselectupdate').empty();
                        $.each(pilihan_standar, function (i, item) {
                            $('.tagselectupdate').append($('<option>', {
                                value: item,
                                text : item
                            }));
                        });
                        $('.tagselectupdate').val(pilihan_standar).trigger('change');

                        $("#update-kegitan").modal('show');
                    }
                });
            });

            $('.hapus_kegiatan').click(function(){
                clearFormStatus("#frm_hapuskegiatan");

                let nama_kegiatan = $(this).data('nama')
                let id_kegiatan = $(this).data('id')

                $("#label_nama_kegiatan_hapus").html(nama_kegiatan);
                $("#id_formekstra_hapus").val(id_kegiatan);

                $("#hapus-kegiatan").modal('show');
            });

            $("#frm_tambahkegiatan").validate({
                rules: {
                    nama_kegiatan: {
                        required: true
                    },
                    nama_kolom: {
                        required: true
                    }
                },
                messages: {
                    nama_kegiatan: {
                        required: "Nama Kegiatan harus diisi!"
                    },
                    nama_kolom: {
                        required: "Nama Kolom harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $("#frm_updatekegiatan").validate({
                rules: {
                    nama_kegiatan: {
                        required: true
                    },
                    nama_kolom: {
                        required: true
                    }
                },
                messages: {
                    nama_kegiatan: {
                        required: "Nama Kegiatan harus diisi!"
                    },
                    nama_kolom: {
                        required: "Nama Kolom harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });
        });

        function refreshStandarPilihan(dom, dom_standr){
            let jenis_kolom = $(dom).val();

            if (jenis_kolom === 'select'){
                $('#'+dom_standr).show();
            }else{
                $('#'+dom_standr).hide();
            }
        }

        function clearFormStatus(formId) {
            // Reset the form values
            $(formId)[0].reset();

            // Clear validation messages and error/success classes
            $(formId).find('.valid').removeClass('valid'); // Remove valid class
            $(formId).find('label.error').remove(); // Remove error messages
            $(formId).find('.error').removeClass('error'); // Remove error class
        }
    </script>
</html>