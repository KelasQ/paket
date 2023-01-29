D<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>Data User</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div>
                        <form action="<?=base_url();?>user/byrole" method="post" style="float: left;margin-top: 15px; margin-left: 15px">
                            <label>Role</label>
                            <select class="js-supplier" name="sup">
                                <option></option>
                                <option>All</option>
                                <?php foreach($role as $row){ ?>
                                    <option value="<?=$row->role?>"><?php if ($row->role == 1) : echo 'Super Admin'; elseif ($row->role == 2 ) : echo 'User'; endif?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-rounded btn-success">Go</button>
                        </form>
                        <a class="btn btn-rounded btn-primary" style="float: right; margin-top: 15px; margin-right: 15px" href="<?=base_url();?>user/tambah">Tambah User</a>
                    </div>
                    <div class="card-body">
                        <?php if(!$this->session->userdata()): ?>
                            <?= $this->session->flashdata('message');?>  
                        <?php endif; ?>
                        <table id="simpletable" class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th width="18%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($data as $row){?>
                                    <tr id="delete<?=$row->id;?>">
                                        <td><?=$no++;?></td>
                                        <td><?=$row->username;?></td>
                                        <td>
                                            
                                            <?php if ( $row->role == 1 ) : echo 'Super Admin'; elseif ($row->role == 2 ) : echo 'User Scan'; endif?> 
                                            
                                            <?php if( $row->role == 3 ) echo 'Data Check'; ?> 
                                            
                                            <?php if( $row->role == 4 ) echo 'Admin Invoice'; ?>
                                        
                                        </td>
                                        <td>
                                            <div class="table-actions text-center">
                                                <a class="btn btn-icon btn-warning text-white" href="<?=base_url();?>user/edit/<?=$row->id?>"><i class="ik ik-edit-2"></i></a> 
                                                <a onclick="deleteuser('hapus',<?php echo $row->id ?>)" href="#" class="btn btn-icon btn-danger text-white"><i class="ik ik-trash-2"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }?>
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