<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>Data Paket</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between row">
                        <div class="col-12 col-md-8">
                            <h3>Paket</h3>
                        </div>

                        <?php if ($this->session->userdata('role') == 1) :  ?>
                            <div class="col-12 col-md-4">

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <select class="form-control" id="filter-kasir-status">
                                            <option value=''>Pilih Status</option>
                                            <option value='Publish'>Publish</option>
                                            <option value='Draft'>Draft</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <select class="form-control" id="filter-kasir-stock">
                                            <option value=''>Pilih Stock</option>
                                            <option value='IN STOCK'>IN STOCK</option>
                                            <option value='OUT OF STOCK'>OUT OF STOCK</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php


                        $url = '?start=' . $this->input->get('start');
                        $url .= '&end=' . $this->input->get('end');

                        ?>

                        <?php if ($this->session->userdata('role') != '1') : ?>
                            <div class="row mb-3 border-bottom pb-3">
                                <div class="col-12 col-md-6">
                                    <?php echo form_open_multipart('', ['method' => 'GET']); ?>
                                    <?php echo $this->session->flashdata('message'); ?>

                                    <div class="form-row">
                                        <div class="form-group col-12 col-md-5">

                                            <label for="exampleInputName1">Start Date</label><br>
                                            <input class="form-control" type="date" name="start" value="<?php echo $this->input->get('start') ?>">
                                        </div>
                                        <div class="form-group col-12 col-md-5">
                                            <label for="exampleInputName1">End Date</label><br>
                                            <input class="form-control" type="date" name="end" value="<?php echo $this->input->get('end') ?>">
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="exampleInputName1">&nbsp;</label><br>
                                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                        </div>
                                    </div>

                                    </form>

                                </div>
                            </div>
                        <?php endif; ?>

                        <?php echo $this->session->flashdata('message'); ?>
                        <table id="simpletable-kasir" class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <?php if ($_SESSION['role'] == 1) : ?>
                                        <th>Username</th>
                                    <?php endif; ?>
                                    <th>Gambar</th>
                                    <th>Tanggal</th>
                                    <th>Invoice</th>
                                    <th>No Invoice</th>
                                    <?php if ($this->session->userdata('role') == 1) : ?>
                                        <th>Keterangan</th>
                                        <th>Publish</th>
                                        <th>Stock</th>
                                    <?php endif; ?>
                                    <th width="18%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data as $row) {
                                    if ($_SESSION['role'] == 1) { ?>
                                        <tr id="delete<?= $row->id; ?>">
                                            <td><?= $no++; ?></td>
                                            <?php if ($_SESSION['role'] == 1) : ?>
                                                <td><?= $row->username ?></td>
                                            <?php endif; ?>
                                            <td>
                                                <?php if ($row->gambar) : ?>
                                                    <img src="<?= base_url('uploads/' . $row->gambar) ?>" class="img-fluid" style="max-width:200px">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $date = date_create($row->tanggal);
                                                echo date_format($date, "H:i:s d-M-Y");
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($row->invoice) : ?>
                                                    <a href="<?= base_url('uploads/kasir/' . $row->invoice) ?>" class="single-image">

                                                        <?php $pathInfo = pathinfo(base_url('uploads/kasir/' . $row->invoice), PATHINFO_EXTENSION); ?>

                                                        <?php if ($pathInfo == 'pdf') : ?>
                                                            <a href="<?php echo base_url('uploads/kasir/' . $row->invoice); ?>" target="_blank"><?php echo $row->invoice; ?></a>
                                                        <?php else : ?>

                                                            <img src="<?= base_url('uploads/kasir/' . $row->invoice) ?>" class="img-fluid lazy" style="max-width:100px">

                                                        <?php endif; ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>

                                            <td><a href="javascript:void(0)" id="btnListHistoryPaket" data-toggle="modal" data-target="#modalTimeline" data-no_invoice="<?= $row->no_invoice; ?>"><?= $row->no_invoice; ?></a></td>

                                            <td><?php echo $row->keterangan ?></td>
                                            <?php if ($this->session->userdata('role') == 1) : ?>
                                                <td><?php echo $row->is_publish ?></td>
                                                <td><?php echo $row->stock ?></td>
                                            <?php endif; ?>


                                            <td>
                                                <div class="table-actions text-center">
                                                    <a class="btn btn-icon btn-primary single-image" href="<?= base_url('uploads/' . $row->gambar) ?>"><i class="ik ik-eye"></i></a>
                                                    <a onclick="deletepaket('hapus',<?php echo $row->id ?>)" href="#" class="btn btn-icon btn-danger"><i class="ik ik-trash-2"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } else { ?>

                                        <tr id="delete<?= $row->id; ?>">
                                            <td><?= $no++; ?></td>
                                            <?php if ($_SESSION['role'] == 1) { ?>
                                                <td><?= $row->username ?></td>
                                            <?php } ?>
                                            <td>

                                                <?php if ($row->gambar) : ?>
                                                    <a href="<?= base_url('uploads/' . $row->gambar) ?>" class="single-image">

                                                        <img src="<?= base_url('uploads/' . $row->gambar) ?>" class="img-fluid" style="max-width:200px">

                                                    </a>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <?php
                                                $date = date_create($row->tanggal);
                                                echo date_format($date, "H:i:s d-M-Y");
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($row->invoice) : ?>
                                                    <a href="<?= base_url('uploads/kasir/' . $row->invoice) ?>" class="single-image">

                                                        <?php $pathInfo = pathinfo(base_url('uploads/kasir/' . $row->invoice), PATHINFO_EXTENSION); ?>

                                                        <?php if ($pathInfo == 'pdf') : ?>
                                                            <a href="<?php echo base_url('uploads/kasir/' . $row->invoice); ?>" target="_blank"><?php echo $row->invoice; ?></a>
                                                        <?php else : ?>

                                                            <img src="<?= base_url('uploads/kasir/' . $row->invoice) ?>" class="img-fluid lazy" style="max-width:100px">

                                                        <?php endif; ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>

                                            <td><?php echo $row->no_invoice; ?></td>

                                            <td>
                                                <div class="table-actions text-center">
                                                    <!-- <a class="btn btn-icon btn-primary single-image text-white" href="<?= base_url('uploads/' . $row->gambar) ?>"><i class="ik ik-eye"></i></a> -->
                                                    <a class="btn btn-icon btn-warning text-white" href="<?= base_url('paket/edit/' . $row->id . $url) ?>">
                                                        <span class="ik ik-edit-2"></span>
                                                    </a>
                                                    <!--<a onclick="deletepaket('hapus',<?php echo $row->id ?>)" href="#" class="btn btn-icon btn-danger"><i class="ik ik-trash-2"></i></a>-->
                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
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

<!-- Modal -->
<div class="modal fade" id="modalTimeline" tabindex="-1" role="dialog" aria-labelledby="modalTimelineLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTimelineLabel">History Paket : <strong id="no_invoice"></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <th>No</th>
                                <th>User</th>
                                <th>Keterangan</th>
                                <th>Tgl Input</th>
                            </thead>
                            <tbody class="listHistoriTimeline"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>