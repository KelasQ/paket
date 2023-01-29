<div class="main-content">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-12">
                                    <div class="page-header-title">
                                        <i class="ik ik-edit bg-blue"></i>
                                        <div class="d-inline">
                                            <h5>Edit Data User</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header"><h3>Form Edit</h3></div>
                                    <div class="card-body">
                                        <?php echo form_open_multipart('user/simpan');?>
                                            <?php echo $this->session->flashdata('message');?>      
                                            <div class="form-group">
                                                <label for="exampleInputName1">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?=$data['username']?>" autocomplete="off" readonly>
                                                <?= form_error('id_sku','<small class="text-danger">','</small>');?>
                                                <input type="text" name="id" value="<?=$data['id'];?>" hidden/>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Password</label>
                                                <input type="text" class="form-control" name="password" autocomplete="off">
                                                <?= form_error('password','<small class="text-danger">','</small>');?>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Password Confirmation</label>
                                                <input type="text" class="form-control" name="password2"  autocomplete="off">
                                                <?= form_error('password2','<small class="text-danger">','</small>');?>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Role</label><br>
                                                <select class="js-sup" name="role">
                                                    <option></option>
                                                    <?php 
                                                    

                                                    $roles = [ 
                                                        1 => 'Super Admin',
                                                        2 => 'User Scan',
                                                        3 => 'Data Check',
                                                        4 => 'Admin Invoice'
                                                    ];
                                                    
                                                    
                                                    ?>
                                                    <?php foreach( $roles as $key => $value ) : ?>
                                                        <option value="<?php echo $key ?>" <?php if($key == $data['role']) echo 'selected';  ?>><?php echo $value ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <button type="button" onclick="location.href='<?=base_url();?>user'" class="btn btn-light">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>