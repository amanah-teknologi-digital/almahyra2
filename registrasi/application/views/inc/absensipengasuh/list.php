<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <style type="text/css">
        .map {
          height: 200px;
          /* The height is 400 pixels */
          width: 100%;
          /* The width is the width of the web page */
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
                            <li><a href="#">Observasi</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Nama</th>
                                                    <th>Panggilan</th>
                                                    <th>Tempat Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= ucwords($row->nama) ?></td>
                                                        <td><?= ucwords($row->nick) ?></td>
                                                        <td><?= ucwords($row->tempat_lahir) ?>, <?= date("d M Y", strtotime($row->tanggal_lahir)) ?> </td>
                                                        <td><?= strtoupper($row->jenis_kelamin) ?></td>
                                                        <td align="center">
                                                            <button class="btn btn-outline-warning btn-icon edit" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Pen-3"></i>
                                                                </span>
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <!--  Modal -->
                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <?php echo form_open_multipart($controller.'/insert'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Absensi</label>
                                                    <select class="form-control" name="jenis" required>
                                                        <option value="1">Check In</option>
                                                        <option value="2">Check Out</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Suhu</label>
                                                    <input class="form-control" type="text" name="suhu" placeholder="36.5 (Gunakan titik untuk koma)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label> Kondisi </label>
                                                    <select class="form-control" name="kondisi" required>
                                                        <option value="1">Sehat</option>
                                                        <option value="2">Kurang Sehat</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label> Status </label>
                                                    <select class="form-control" name="status" required>
                                                        <option value="1">Suspect</option>
                                                        <option value="2">Probable</option>
                                                        <option value="3">Kontak Erat</option>
                                                        <option value="4">Terkonfimasi Covid-19</option>
                                                        <option value="5">Tidak Berstatus</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>  

                                    <div class="modal-footer">
                                        <input type="hidden" name="id_anak" id="id_anak">
                                        <input type="hidden" name="long" id="long">
                                        <input type="hidden" name="lati" id="lati">                                    
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                    </div>

                                    <hr>
                                    <div class="table-responsive">
                                        <h5 id="tanggal_absen"></h5>
                                        <table class="display table table-striped table-bordered" id="tblx" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Waktu</th>
                                                    <th>Suhu</th>
                                                    <th>Kondisi</th>
                                                    <th>Status</th>
                                                    <th>Jenis</th>
                                                    <th>Lokasi</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                            </tbody>
                                        </table>
                                    </div>                                  
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
        
        var role = "<?= $this->session->userdata['auth']->id_role ?>";

        $('.edit').click(function(){
            var id_anak = $(this).data('id') ;
            $("#tblx > tbody").empty();

            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id_anak").val(id_anak);  

                    if (data['list_hasil'].length > 0) {
                        $("#id").val(data['list_edit']['id']);
                        $("#tanggal_absen").text(data['list_hasil'][0]['tanggal']);

                        var status = 'Suspect';

                        $.each(data['list_hasil'], function( index, row ) {
                            console.log(row);
                            switch (row.status) {
                              case '1':
                                status = "Suspect";
                                break;
                              case '2':
                                status = "Probable";
                                break;
                              case '3':
                                 status = "Kontak Erat";
                                break;
                              case '4':
                                status = "Terkonfimasih Covid19";
                                break;
                              case '5':
                                status = "Tidak Berstatus";
                                break;
                            }

                            $("#tblx > tbody").append(
                                "<tr>"+
                                    "<td align='center' width='15%'>"+row.waktu+"</td>"+
                                    "<td align='center' width='15%'>"+row.suhu+"</td>"+
                                    "<td align='center' width='15%'>"+(row.kondisi == 1 ? 'Sehat' : 'Tidak Sehat')+"</td>"+
                                    "<td align='center' width='15%'>"+status+"</td>"+
                                    "<td align='center' width='15%'>"+ (row.jenis == 1 ? 'Check In' : 'Check Out')+"</td>"+
                                    "<td align='center'> <div class='map' id='map_"+index+"'></div> </td>"+
                                "</tr>"
                            );

                            if (row.long !== null && row.lati !== null) {
                                initMap(parseInt(row.long), parseInt(row.lati), index);
                            }
                        });
                        
                    } 

                    $("#updating-modal").modal('show');
                }                
            }); 
        })

        function deleteList(id) {
            swal({
                title: 'Apakah yakin data ini ingin di hapus? ',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
                confirmButtonText: 'Ya, Lanjutkan hapus!',
                cancelButtonText: 'Batal',
            }).then(function () {
                window.location = url + '/delete/' + id ;
            })
        }
        
        // Initialize and add the map
        function initMap(long, lat , id) {
          // The location of Uluru
          // const uluru = { lat: -25.344, lng: 131.031 };

          const uluru = { lat: lat, lng: long };

          console.log(uluru, lat, long , typeof lat, typeof long);
          // The map, centered at Uluru
          const map = new google.maps.Map(document.getElementById("map_"+id), {
            zoom: 4,
            center: uluru,
          });
          // The marker, positioned at Uluru
          const marker = new google.maps.Marker({
            position: uluru,
            map: map,
          });
        }

        $(function() {
            getCurrentLocation();
        });        
    </script>

    <script>
        /* Get current location*/
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success,showError);
            } else {
                alert("Geolocation is not supported on your browser!");
            }

            function success(position) {
                console.log("Latitude: " + position.coords.latitude +" Longitude: " + position.coords.longitude);
                $("#lati").val(position.coords.latitude);
                $("#long").val(position.coords.longitude);
            }

            function showError(error) {
                switch(error.code) {
                  case error.PERMISSION_DENIED:
                    alert("Lokasi tidak terdeteksi, Mohon mengijinkan aplikasi mengakses lokasi anda. https://support.google.com/chrome/answer/142065?hl=id&co=GENIE.Platform%3DDesktop");
                    break;
                  case error.POSITION_UNAVAILABLE:
                    alert("Lokasi tidak terdeteksi, Mohon mengijinkan aplikasi mengakses lokasi anda. https://support.google.com/chrome/answer/142065?hl=id&co=GENIE.Platform%3DDesktop");
                    break;
                  case error.TIMEOUT:
                    alert("Lokasi tidak terdeteksi, Mohon mengijinkan aplikasi mengakses lokasi anda. https://support.google.com/chrome/answer/142065?hl=id&co=GENIE.Platform%3DDesktop");
                    break;
                  case error.UNKNOWN_ERROR:
                    alert("Lokasi tidak terdeteksi, Mohon mengijinkan aplikasi mengakses lokasi anda. https://support.google.com/chrome/answer/142065?hl=id&co=GENIE.Platform%3DDesktop");
                    break;
                }

                window.location.replace("dashboard");
            }
        }
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            