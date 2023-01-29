<?php if(!$this->input->get('start') || !$this->input->get('end')) : ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-flex justify-content-between">
                            <h5>Filter Data Paket</h5>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>Filter Data paket</h3></div>
                    <div class="card-body">
                        <?php echo form_open_multipart('', [ 'method' => 'GET' ]);?>
                            <?php echo $this->session->flashdata('message');?>
                            <div class="form-group">
                                <label for="exampleInputName1">Start Date</label><br>
                                <input class="form-control" type="date" name="start">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">End Date</label><br>
                                <input class="form-control" type="date" name="end">
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

<?php else : ?>

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
                            
                            <div class="card-header d-flex justify-content-between">
                                <h3>Paket</h3>
                             
                                <div>
                                    <div class="form-group">
                                        <select class="form-control" id="filter-status">
                                            <option value=''>Pilih</option>
                                            <option value='Publish'>Publish</option>
                                            <option value='Draft'>Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php echo $this->session->flashdata('message');?>  
                                <form>

                                    

                                </form>
                                <table id="simpletable" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th width="3%">No</th>
                                            <th>Username</th>
                                            <th>Gambar</th>
                                            <th>Invoice</th>
                                            <th>Tanggal</th>
                                            <th>No Invoice</th>
                                            <th>Keterangan</th>
                                            <th>Publish</th>
                                            <th width="18%">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data as $row) : ?>
                                        <tr id="delete<?=$row->id;?>">
                                            <td><?=$no++;?></td>
                                            <td><?=$row->username?></td>
                                            <td>
                                                <a 
                                                    href="<?=base_url('uploads/'.$row->gambar)?>"
                                                    class="single-image">
                                                    <img 
                                                        src="<?=base_url('uploads/'.$row->gambar)?>" 
                                                        class="img-fluid lazy" style="max-width:100px">
                                                </a>
                                            </td>
                                            <td>
                                                <?php if( $row->invoice ) : ?>
                                                <a 
                                                    href="<?=base_url('uploads/kasir/'.$row->invoice)?>"
                                                    class="single-image">
                                                    <?php $pathInfo = pathinfo(base_url('uploads/kasir/'.$row->invoice), PATHINFO_EXTENSION); ?>
                                                            
                                                    <?php if($pathInfo == 'pdf')  : ?>
                                                        <a href="<?php echo base_url('uploads/kasir/'.$row->invoice); ?>" target="_blank"><?php echo $row->invoice; ?></a>
                                                    <?php else: ?>
                                                        
                                                    <img 
                                                        src="<?=base_url('uploads/kasir/'.$row->invoice)?>" 
                                                        class="img-fluid lazy" style="max-width:100px">
                                                        
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
                                            <td><?php echo $row->is_publish ?></td>
                                            <td>
                                                <div class="table-actions text-center">
                                                    <?php if($row->is_publish == 'Publish') : ?>
                                                        <a href="javascript:void(0)" class="btn btn-icon btn-success text-white" title="Data sudah lengkap"><i class="fas fa-check"></i></a>
                                                    <?php endif; ?>

                                                    <?php if($row->is_publish == 'Draft' || $row->is_publish == '') : ?>
                                                        <a href="javascript:void(0)" class="btn btn-icon btn-warning text-white" title="Data belum lengkap"><i class="fas fa-times"></i></a>
                                                    <?php endif; ?>


                                                    <a onclick="deletepaket('hapus',<?php echo $row->id ?>)" href="#" class="btn btn-icon btn-danger text-white"><i class="fas fa-trash"></i></a>
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

<?php endif; ?>

