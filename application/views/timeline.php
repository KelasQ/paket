<div class="main-content">
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
                        <a href="<?= base_url('timeline/add'); ?>" class="btn btn-primary text-white">
                            Tambah Data Timeline
                        </a>
                        <!-- <button class="btn btn-primary btnAddTimeLine" data-toggle="modal" data-target="#modalTimeLine">
                            Tambah Data Timeline
                        </button> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover dataTable" style="width: ;">
                                    <thead>
                                        <th>No</th>
                                        <th>User Input</th>
                                        <th>No Invoice</th>
                                        <th>Keterangan</th>
                                        <th>Tgl Input</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($dataTimeline as $row) : ?>
                                            <tr>
                                                <td><?= $no++; ?>.</td>
                                                <td><?= $row['username']; ?></td>
                                                <td><?= $row['no_invoice']; ?></td>
                                                <td><?= $row['keterangan']; ?></td>
                                                <td><?= $row['tgl_input']; ?></td>
                                                <td>
                                                    <div class="table-actions text-center">
                                                        <a class="btn btn-icon btn-warning text-white" href="<?= base_url('timeline/edit/' . $row['id_timeline']); ?>"><i class="ik ik-edit-2"></i></a>
                                                        <a href="<?= base_url('timeline/hapus/' . $row['id_timeline']); ?>" onclick="return confirm('Yakin Ingin Dihapus ?')" class="btn btn-icon btn-danger text-white"><i class="ik ik-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Timeline -->
<!-- <div class="modal fade" id="modalTimeLine" tabindex="-1" role="dialog" aria-labelledby="modalTimeLineLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTimeLineLabel"></h4>
            </div>
            <div class="modal-body">
                <?= form_open('timeline/insert'); ?>
                <input type="hidden" name="id_timeline" id="id_timeline">
                <input type="hidden" name="id_user" id="id_timeline" value="<?= $this->session->userdata('id'); ?>">
                <input type="hidden" name="tgl_input" id="tgl_input" value="<?= date('Y-m-d H:i:s'); ?>">
                <div class="form-group">
                    <label for="no_invoice">Nomor Invoice</label>
                    <select name="no_invoice" id="no_invoice" class="form-control invoice_list" required>

                    </select>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" cols="30" rows="3" placeholder="Keterangan" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="" class="btn btn-primary"></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div> -->