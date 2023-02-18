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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Paket</h3>
                        <div>
                            <div class="form-group">
                                <select class="form-control" id="filter-stock">
                                    <option value=''>Pilih</option>
                                    <option value='IN STOCK'>IN STOCK</option>
                                    <option value='OUT OF STOCK'>OUT OF STOCK</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $url = '?start=' . $this->input->get('start');
                        $url .= '&end=' . $this->input->get('end');
                        ?>
                        <a href="<?php echo base_url('invoice/tambah' . $url) ?>" class="btn btn-primary mb-3">Tambah Data</a>
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalUploadInvoice">
                            Invoices Upload
                        </button>
                        <div class="border-bottom mb-3"></div>
                        <div class="row mb-3 border-bottom pb-3">
                            <div class="col-12 col-md-6">
                                <?php echo form_open_multipart('invoice', ['method' => 'GET']); ?>
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
                        <?php echo $this->session->flashdata('message'); ?>
                        <table id="simpletable-invoice" class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>Username</th>
                                    <th>Gambar</th>
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>No Invoice</th>
                                    <th>Keterangan</th>
                                    <th>Stock</th>
                                    <th width="18%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data as $row) : ?>
                                    <tr id="delete<?= $row->id; ?>">
                                        <td><?= $no++; ?></td>
                                        <td><?= $row->username ?></td>
                                        <td>
                                            <?php if ($row->gambar) : ?>
                                                <a href="<?= base_url('uploads/' . $row->gambar) ?>" id="single_image">
                                                    <img src="<?= base_url('uploads/' . $row->gambar) ?>" class="img-fluid lazy" style="max-width:100px">
                                                </a>
                                            <?php endif; ?>
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
                                        <td>
                                            <?php
                                            $date = date_create($row->tanggal);
                                            echo date_format($date, "H:i:s d-M-Y");
                                            ?>
                                        </td>
                                        <td><?php echo $row->no_invoice ?></td>
                                        <td><?php echo $row->keterangan ?></td>
                                        <td><?php echo $row->stock ?></td>
                                        <td>
                                            <div class="table-actions text-center">
                                                <a href="<?php echo base_url('/invoice/edit/' . $row->id . '?start=' . $this->input->get('start') . '&end=' . $this->input->get('end')); ?>" class="btn">Edit</a>
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

<!-- Modal Upload Invoice -->
<div class="modal fade" id="modalUploadInvoice" tabindex="-1" role="dialog" aria-labelledby="modalUploadInvoiceLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalUploadInvoiceLabel">Upload Files Invoice</h4>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#tokopedia">Tokopedia</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#shopee">Shopee</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#lazada">Lazada</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#cs_order">CS Order</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#tiktok">Tiktok</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent" style="margin-top: 15px;">
                    <div class="tab-pane fade show active" id="tokopedia" role="tabpanel">
                        <form action="<?= base_url('invoice/uploads'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_store" value="tokopedia">
                            <input type="file" name="invoice_file[]" id="input-invoice-tokopedia" accept="pdf" multiple>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="shopee" role="tabpanel">
                        <form action="<?= base_url('invoice/uploads'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_store" value="shopee">
                            <input type="file" name="invoice_file[]" id="input-invoice-shopee" accept="pdf" multiple>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="lazada" role="tabpanel">
                        <form action="<?= base_url('invoice/uploads'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_store" value="lazada">
                            <input type="file" name="invoice_file[]" id="input-invoice-lazada" accept="pdf" multiple>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="cs_order" role="tabpanel">
                        <form action="<?= base_url('invoice/uploads'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_store" value="cs_order">
                            <input type="file" name="invoice_file[]" id="input-invoice-cs_order" accept="pdf" multiple>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tiktok" role="tabpanel">
                        <form action="<?= base_url('invoice/uploads'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_store" value="tiktok">
                            <input type="file" name="invoice_file[]" id="input-invoice-tiktok" accept="pdf" multiple>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>