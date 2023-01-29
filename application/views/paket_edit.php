<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Data Supplier</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Form Edit</h3>
                    </div>
                    <div class="card-body">
                        <?php echo form_open_multipart('supplier/simpan'); ?>
                        <?php echo $this->session->flashdata('message'); ?>
                        <div class="form-group">
                            <label for="exampleInputName1">Nama Supplier</label>
                            <input type="text" class="form-control" name="nama_supplier" value="<?= $data['nama_supplier']; ?>" autocomplete="off">
                            <?= form_error('nama_supplier', '<small class="text-danger">', '</small>'); ?>
                            <input type="text" name="id" value="<?= $data['id_supplier'] ?>" hidden>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?= $data['alamat']; ?>" autocomplete="off">
                            <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
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