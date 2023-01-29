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
                                    </div>
                                    <div class="card-body">
                                        <?php echo $this->session->flashdata('message');?>  
                                        <table id="simpletable-kasir" class="table table-striped table-bordered table-responsive">
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
                                                    <th>Stock</th>
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
                                                    <td><?php echo $row->stock ?></td>
                                                    <td>
                                                        <div class="table-actions text-center">
                                                            <a href="<?php echo base_url('/kasir/edit/' . $row->id . '?start=' . $this->input->get('start') . '&end=' . $this->input->get('end')); ?>" class="btn btn-warning btn-icon text-white">
                                                                <span class="ik ik-edit-2"></span>
                                                            </a>
                                                            
                                                            <?php $publishData = $row->is_publish == 'Publish' ? 'Draft' : 'Publish'; ?>
                                                            <a href="javascript:void(0)" class="btn btn-success btn-icon text-white btn-paket-publish" data-id="<?php echo $row->id; ?>" data-publish="<?php echo $publishData; ?>">
                                                                <?php if($row->is_publish == 'Publish') : ?>
                                                                    <span class="ik ik-check"></span>
                                                                    <?php else: ?>
                                                                    <span class="ik ik-x"></span>
                                                                <?php endif; ?>
                                                            </a>
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