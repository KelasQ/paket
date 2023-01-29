D<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h5><?= $title; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="<?= base_url('timeline'); ?>" class="btn btn-info text-white">
                            Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- <?php if ($this->session->flashdata('message')) : ?>
                            <?= $this->session->flashdata('message'); ?>
                        <?php endif; ?> -->
                        <?= form_open('timeline/insert'); ?>
                        <input type="hidden" name="id_timeline" id="id_timeline">
                        <input type="hidden" name="id_user" id="id_timeline" value="<?= $this->session->userdata('id'); ?>">
                        <input type="hidden" name="tgl_input" id="tgl_input" value="<?= date('Y-m-d H:i:s'); ?>">
                        <div class="form-group">
                            <label for="no_invoice">Nomor Invoice</label>
                            <select name="no_invoice" id="no_invoice" class="form-control invoices" required>
                                <?php foreach ($invoices as $invoice) : ?>
                                    <option value="<?= $invoice['no_invoice']; ?>"><?= $invoice['no_invoice']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="3" placeholder="Keterangan" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">
                            Simpan Data Timeline
                        </button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>