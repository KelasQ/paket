<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>Tambah Data User</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Form Input</h3>
                    </div>
                    <div class="card-body">
                        <?php echo form_open_multipart('user/tambahbaru'); ?>
                        <?php echo $this->session->flashdata('message'); ?>
                        <div class="form-group">
                            <label for="exampleInputName1">Username</label>
                            <input type="text" class="form-control" name="username" value="<?= set_value('username'); ?>" autocomplete="off">
                            <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Password</label>
                            <input type="password" class="form-control" name="password" autocomplete="off">
                            <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Password Confirmation</label>
                            <input type="password" class="form-control" name="password2" autocomplete="off">
                            <?= form_error('password2', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Role</label><br>
                            <select class="js-sup" name="role">
                                <option></option>
                                <option value='1'>Super Admin</option>
                                <option value='2'>User Scan</option>
                                <option value='3'>Data Check</option>
                                <option value='4'>Admin Invoice</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>