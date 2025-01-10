<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>
    <style>
        .callout {
            background-color: #fff;
            border: 1px solid #e4e7ea;
            border-left: 4px solid #c8ced3;
            border-radius: .25rem;
            margin: 1rem 0;
            padding: .75rem 1.25rem;
            position: relative;
        }

        .callout h4 {
            font-size: 1.3125rem;
            margin-top: 0;
            margin-bottom: .8rem
        }
        .callout p:last-child {
            margin-bottom: 0;
        }

        .callout-default {
            border-left-color: #777;
            background-color: #f4f4f4;
        }
        .callout-default h4 {
            color: #777;
        }

        .callout-primary {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #17a2b8;
        }
        .callout-primary h4 {
            color: #20a8d8;
        }

        .callout-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            border-left-color: #28a745;
        }
        .callout-success h4 {
            color: #3c763d;
        }

        .callout-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            border-left-color: #d32535;
        }
        .callout-danger h4 {
            color: #a94442;
        }

        .callout-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            border-left-color: #edb100;
        }
        .callout-warning h4 {
            color: #f0ad4e;
        }

        .callout-info {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #148ea1;
        }
        .callout-info h4 {
            color: #31708f;
        }

        .callout-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: .75rem 1.25rem;
            color: inherit;
        }
    </style>
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
                            <li><a href="#">Medical Checkup</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Detail Hasil Checkup</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="row text-center d-flex align-items-center justify-content-center">
                                        <div class="col-sm-12">
                                            <h5 class="card-title mb-1">Pencatatan Barang Hari&nbsp;<b><?= format_date_indonesia($data_checkup->tanggal).', '.date('d-m-Y', strtotime($data_checkup->tanggal)) ?></b></h5>
                                            <h5 class="card-title mb-1">a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_checkup->nama_anak ?></span> <span class="text-muted">(<?= $data_checkup->nama_kelas ?>)</span></h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h5><span class="fas fa-briefcase"></span>&nbsp;List Barang</h5>
                                        </div>
                                        <?php if ($data_checkup->is_aprove == 0){ ?>
                                            <div class="col-sm-4">
                                                <button class="btn btn-sm btn-primary float-right" id="btn-tambahbarang"><span class="fas fa-plus"></span>&nbsp;Tambah Barang</button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <p><span class="text-muted" style="font-size: smaller"><i>terakhir update <?= empty($data_checkup->updated_at)? timeAgo($data_checkup->created_at):timeAgo($data_checkup->updated_at); ?> </i></span></p>
                                    <div class="row">
                                        <?php if ($data_checkup->is_aprove == 1){ ?>
                                            <div class="col-sm-6">
                                        <?php }else{ ?>
                                            <div class="col-sm-12">
                                        <?php } ?>
                                                <table class="table-sm table table-bordered">
                                                    <thead style="background-color: #bfdfff">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 20%">Nama Barang</th>
                                                        <th style="width: 15%">Kondisi</th>
                                                        <th style="width: 15%">Jumlah</th>
                                                        <th style="width: 30%">Keterangan</th>
                                                        <th style="width: 15%">Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if (count($data_rinciancheckup) > 0){ ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center">Data kosong</td>
                                                        </tr>
                                                    <?php }else{ ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center">Data kosong</td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php if ($data_checkup->is_aprove == 1){ ?>
                                            <div class="col-sm-6"></div>
                                        <?php } ?>
                                    </div>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Pencatatan barang bisa dilakukan selama <b>belum ada approve</b>. dan pencatatan barang waktu pulang harus dalam keaadaan <b>sudah approve</b> terlebih dahulu.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <div class="modal fade" id="tambah-barang" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/insertbarang', 'id="frm_tambahbarang"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Absensi Barang</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Pilih Nama Barang</label>
                                        <select name="barang" id="barang_tambah" class="form-control select2" required onchange="getListKondisi(this)">
                                            <option value="">-- Pilih Barang --</option>
                                            <?php foreach ($list_barang as $key => $row) { ?>
                                                <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Barang</label>
                                        <input type="text" name="jumlah" id="jumlah_tambah" class="form-control" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Kondisi Barang</label>
                                        <select name="kondisi" id="kondisi_tambah" class="form-control" required></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan Masuk<i>(Optional)</i></label>
                                        <textarea class="form-control" name="keterangan" id="keterangan_tambah" cols="30" rows="5" autocomplete="off"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_absensi" value="<?= $id_absensi ?>" >
                        </form>
                    </div>
                </div>
                <?php $this->load->view('layout/footer') ?>
                <!--  Modal -->
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <?php $this->load->view('layout/file_upload') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        let url = "<?= base_url().$controller ?>";

        $(document).ready(function() {
            $(".select2").select2();

            $.validator.addMethod("decimal", function(value, element) {
                // Regular expression for decimal values (including optional negative sign)
                return this.optional(element) || /^-?\d+(\.\d+)?$/.test(value);
            }, "Please enter a valid decimal number.");

            $('#btn-tambahbarang').click(function(){
                clearFormStatus("#frm_tambahbarang");

                $('#barang_tambah').val('').trigger('change');
                $('#kondisi_tambah').html('');
                $('#keterangan_tambah').val('');

                $("#tambah-barang").modal('show');
            });

            $("#frm_tambahbarang").validate({
                rules: {
                    barang: {
                        required: true
                    },
                    jumlah: {
                        required: true,
                        decimal: true
                    },
                    kondisi: {
                        required: true
                    }
                },
                messages: {
                    barang: {
                        required: "Barang harus dipilih!"
                    },
                    jumlah: {
                        required: "Jumlah Barang harus diisi!",
                        decimal: "Jumlah Barang harus berupa angka!"
                    },
                    kondisi: {
                        required: "Kondisi barang harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });
        });

        function getListKondisi(dom){
            let id_barang = $(dom).val();
            $('#kondisi_tambah').html('');

            if (id_barang != '') {
                $.ajax({
                    url: url + '/getDataBarang/' + id_barang,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        let standar_pilihan = {};
                        let standar = data['pilihan'];
                        if (standar != '' || standar != null) {
                            console.log(standar);
                            standar_pilihan = JSON.parse(standar);
                            standar_pilihan = Object.values(standar_pilihan);
                        }

                        $.each(standar_pilihan, function (i, val) {
                            $('#kondisi_tambah').append('<option value="' + val + '">' + val + '</option>');
                        });
                    }
                });
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