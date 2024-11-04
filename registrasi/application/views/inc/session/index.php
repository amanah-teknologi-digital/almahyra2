<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <body>
        <div class="auth-layout-wrap" style="background-image: url(<?= base_url().'dist-assets/'?>images/bg_login.png)">
            <div class="auth-content">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-6">                                    
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <img src="<?= base_url().'dist-assets/'?>images/logo_namira.png" alt=""/>
                                </div>

                                <?php echo form_open_multipart($controller.'/login'); ?>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input class="form-control form-control-rounded" name="email" type="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input class="form-control form-control-rounded" name="password" type="password">
                                    </div>
                                    <button class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6" 
                        style="background-size: cover;background-image: url(<?= base_url().'dist-assets/'?>images/photo-long-3.jpg)">
                            <div class="auth-right">
                                <button class="btn btn-rounded btn-outline-success btn-outline-email btn-block btn-icon-text" data-toggle="modal" data-target="#adding-modal">
                                    <i class="i-Mail-with-At-Sign"></i> Sign up with Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="adding-modal" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/register'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Registrasi</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">                                   
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input class="form-control" type="text" required name="name">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" required name="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" type="password" required name="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control" required name="id_role">
                                                <option>Pilih Role</option>
                                                <option value="3">Pengasuh</option>
                                                <option value="4">Orang Tua</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>No. Whatsapp</label>
                                            <input class="form-control" type="text" required name="phone">
                                        </div>
                                        <div class="form-group">
                                            <label>Tujuan Mendaftar</label>
                                            <textarea class="form-control" type="text" required name="purpose"></textarea>
                                        </div>
                                    </fieldset>                                    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <?php $this->load->view('layout/custom') ?>
</html>