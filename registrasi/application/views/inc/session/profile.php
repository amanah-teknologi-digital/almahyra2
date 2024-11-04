<!DOCTYPE html>
<html lang="en" dir="/">
    <?php $this->load->view('layout/head') ?>

    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            <?php $this->load->view('layout/navigation') ?>

            <div class="main-content-wrap d-flex flex-column">
                <?php $this->load->view('layout/header') ?>
                <!-- ============ Body content start ============= -->                
                <div class="main-content">
                    <div class="breadcrumb">
                        <h1>User Profile</h1>
                    </div>

                    <?php if ($this->session->userdata('auth')->activation == '0'): ?>                    
                        <p class="text-danger">
                            Anda belum bisa menggunakan sistem sebelum melakukan update gmail pada email anda. <br>
                            Silahkan masukan alamat gmail anda pada column email.
                        </p>
                    <?php endif ?>

                    <div class="separator-breadcrumb border-top"></div>
                    <div class="card user-profile o-hidden mb-4">
                        <div class="header-cover" style="background-image: url('<?= base_url().'dist-assets/'?>images/photo-wide-4.jpg')"></div>
                        <div class="user-info">
                            <div class="profileImage"><?= strtoupper(substr($this->session->userdata('auth')->name, 0,2)) ?></div>
                            <p class="m-0 text-24"><?= ucwords($this->session->userdata('auth')->name) ?> </p>
                            <p class="text-muted m-0"><?= ucwords($this->session->userdata('auth')->nip) ?> </p>
                        </div>
                        <div class="card-body">
                           <?php echo form_open_multipart($controller.'/update'); ?>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="nip">NIP</label>
                                        <input class="form-control" value="<?= $profile->nip ?>" disabled>
                                    </div>
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="name">Nama</label>
                                        <input class="form-control" id="name" type="text" name="name" required value="<?= $profile->name ?>">
                                    </div>
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="id_unit">Unit</label>
                                        <select class="form-control" required name="id_unit">
                                            <?php foreach ($unit as $key => $d): ?>
                                                <option value="<?= $d->id ?>" 
                                                    <?= $profile->id_unit == $d->id ? 'selected': '' ?> > 
                                                    <?= ($d->name) ?> 
                                                </option>
                                            <?php endforeach ?>
                                            <option value="0" <?= $profile->id_unit == 0 ? 'selected': '' ?> >Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="id_perwakilan">Jabatan</label>
                                        <select class="form-control" required name="id_jabatan">
                                            <?php foreach ($jabatan as $key => $d): ?>
                                                <option value="<?= $d->id ?>" <?= $profile->id_jabatan == $d->id ? 'selected': '' ?> >  <?= ($d->name) ?> </option>
                                            <?php endforeach ?>
                                            <option value="0" <?= $profile->id_jabatan == 0 ? 'selected': '' ?> >Lainnya</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">No Whatsapp</label>
                                        <input class="form-control" id="phone" name="phone" required value="<?= $profile->phone ?>">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="email">Email</label>
                                        <input class="form-control" id="email" type="email" name="email" required value="<?= $profile->email ?>">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">NIP Panjang</label>
                                        <input class="form-control" id="fullnip" name="fullnip" type="text" required value="<?= $profile->fullnip ?>">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">Password</label>
                                        <input class="form-control" id="password" name="password" type="password">
                                    </div>

                                    <div class="col-md-12">
                                        <input type="hidden" name="id" id="id" value="<?= $profile->id ?>">
                                        <button class="btn btn-primary" type="Submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- end of main-content -->
                    <!-- Footer Start -->
                    <div class="flex-grow-1"></div>
                </div>

                <?php $this->load->view('layout/footer') ?>
            </div>            
        </div>
    </body>

    <?php $this->load->view('layout/custom') ?>
</html>