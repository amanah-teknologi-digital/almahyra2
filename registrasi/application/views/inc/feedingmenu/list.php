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
                            <li><a href="#">Rencana Belajar</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
<!--                                <div class="card-header">-->
<!--                                    <p class="card-title mb-0">Filter</p>-->
<!--                                </div>-->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php echo form_open_multipart($controller); ?>
                                            <table style="width: 100%;padding: 10px 10px;">
                                                <colgroup>
                                                    <col style="width: 20%">
                                                    <col style="width: 80%">
                                                </colgroup>
                                                <tr>
                                                    <td>
                                                        <label>Tahun</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="tahun" name="tahun" required onchange="getDataTanggal(this)">
                                                            <?php foreach ($tahun as $key => $value) { ?>
                                                                <option value="<?= $value->tahun ?>" <?= $tahun_selected == $value->tahun ? 'selected' : '' ?>><?= $value->tahun ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Tanggal</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="id_rincianjadwal_mingguan" name="id_rincianjadwal_mingguan" required onchange="getDataKelas(this)">
                                                            <?php foreach ($tanggal as $key => $value) { ?>
                                                                <option value="<?= $value->id_rincianjadwal_mingguan ?>" <?= $id_rincianjadwal_mingguan == $value->id_rincianjadwal_mingguan ? 'selected' : '' ?>><?= 'Tema: '.$value->nama_tema.', '.format_date_indonesia($value->tanggal).' '.date('d-m-Y', strtotime($value->tanggal)).' ('.$value->nama_subtema.')' ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Kelas</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="id_jadwalharian" name="id_jadwalharian" required>
                                                            <?php foreach ($kelas as $key => $value) { ?>
                                                                <option value="<?= $value->id_jadwalharian ?>" <?= $id_jadwalharian == $value->id_jadwalharian ? 'selected' : '' ?>><?= $value->nama_kelas ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" >
                                                        <button class="btn btn-sm btn-primary mt-4">Tampilkan</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <hr>
                                        <div class="table-responsive">
                                            <h5><b>Data Feeding Menu <span class="text-success"><?= $nama_kelas ?></span> <?= 'Tema: '.$nama_tema.', '.format_date_indonesia($tanggal_selected).' '.date('d-m-Y', strtotime($tanggal_selected)).' <span class="font-italic text-muted">('.$nama_subtema.')</span>' ?></b></h5>
                                            <?php echo form_open_multipart($controller.'/update','id="frm_updatetemplate"'); ?>
                                                <fieldset class="mt-4">
                                                    <div class="form-group">
                                                        <label>Uraian Feeding Menu</label>
                                                        <div id="editor_update" style="height: 200px;"><?= !empty($feedingmenu)? $feedingmenu->uraian:''; ?></div>
                                                        <input type="hidden" name="editorContent" id="editorContent_update" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan <i>(Optional)</i></label>
                                                        <textarea class="form-control" name="keterangan" id="keterangan_update" cols="30" rows="10" autocomplete="off"><?= !empty($feedingmenu)? $feedingmenu->keterangan:''; ?></textarea>
                                                    </div>
                                                </fieldset>
                                                <input type="hidden" name="id_jadwalharian" id="id_jadwalharian" value="<?= $id_jadwalharian ?>" />
                                                <div class="text-center mt-3">
                                                    <button type="submit" class="btn btn-success btn-upload-4"><i class="fa fa-file-archive"></i> Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Feeding Menu Anak <b>per Kelas per Hari!</b></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>

    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";

        $(document).ready(function() {
            let quill_update = new Quill('#editor_update', {
                theme: 'snow',  // You can also choose 'bubble'
                modules: {
                    toolbar: [
                        [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['bold', 'italic', 'underline'],
                        [{ 'align': [] }],
                        ['link'],
                        ['image'],
                        ['blockquote']
                    ]
                }
            });

            $("#frm_updatetemplate").validate({
                rules: {},
                messages: {},
                submitHandler: function(form, event) {
                    let content = quill_update.getText().trim();
                    let htmlcontent = quill_update.root.innerHTML;

                    if (htmlcontent === "<p><br></p>" || content === ""){
                        alert('Uraian Feeding Menu harus diisi!');
                        event.preventDefault();  // Prevent form submission
                        return false;  // Prevent default action
                    }

                    $('#editorContent_update').val(htmlcontent);
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });
        });

        function resetInput(){
            $('#id_rincianjadwal_mingguan').html('');
            $('#id_jadwalharian').html('');
        }

        function getDataTanggal(dom){
            let tahun = $(dom).val();
            resetInput();

            $.ajax({
                url: url+'/getDataTanggal',
                type: 'POST',
                data: {tahun: tahun},
                success: function(data){
                    let data_tanggal = data['tanggal'];
                    let data_kelas = data['kelas'];

                    $.each(data_tanggal, function(key, value){
                        $('#id_rincianjadwal_mingguan').append('<option value="'+value.id_rincianjadwal_mingguan+'">Tema: '+value.nama_tema+', '+ value.nama_hari + ' ' +value.tanggal+' ('+value.nama_subtema+')</option>');
                    });

                    $.each(data_kelas, function(key, value){
                        $('#id_jadwalharian').append('<option value="'+value.id_jadwalharian+'">'+value.nama_kelas+'</option>');
                    });
                }
            });
        }

        function getDataKelas(dom){
            let id_rincianjadwal_mingguan = $(dom).val();
            $('#id_jadwalharian').html('');

            $.ajax({
                url: url+'/getDataKelas',
                type: 'POST',
                data: {id_rincianjadwal_mingguan: id_rincianjadwal_mingguan},
                success: function(data){
                    let data_kelas = data['kelas'];

                    $.each(data_kelas, function(key, value){
                        $('#id_jadwalharian').append('<option value="'+value.id_jadwalharian+'">'+value.nama_kelas+'</option>');
                    });
                }
            });
        }
    </script>
</html>