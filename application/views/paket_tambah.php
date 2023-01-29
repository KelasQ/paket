<style>
    .my-camera-preview-container{ overflow: hidden; position: relative; }
</style>
<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>Tambah Data Paket</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>Form Input</h3></div>
                    <div class="card-body">
                        <form id="register">
                            <?php echo $this->session->flashdata('message');?>      
                            <div class="form-group">
                                <!-- <label for="exampleInputName1">Camera</label> -->
                                <input type="hidden" name="id" value="<?php echo $row->id; ?>" id="i-id">
                                <input type="hidden" name="old_gambar" value="<?php echo $row->gambar ?>" id="i-old_gambar">
                                <input type="hidden" name="start" value="<?php echo $this->input->get('start'); ?>" id="i-start">
                                <input type="hidden" name="end" value="<?php echo $this->input->get('end'); ?>" id="i-end">
                                <input type="hidden" class="form-control" name="username" id="username" value="<?=$_SESSION['username'];?>" autocomplete="off">
                                <?= form_error('username','<small class="text-danger">','</small>');?>
                            </div>
                            <div class="form-group">
                                <!-- <div id="my_camera" class="col-12" style="height: 100vh;"></div> -->
                                <div class="my-camera-preview-container mb-0">
                                    <input type="file" name="my_camera" capture="camera" id="my_camera" accept="image/*">
                                    <?php if( $row->gambar ) : ?>
                                    <div class="mt-2">
                                        <img src="<?php echo base_url( 'uploads/' . $row->gambar ); ?>" id="previewCamera" class="img-fluid mt-2">
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div id="results"></div>
                            <div class="form-row">
                                <!-- <div class="form-group col-md-10">
                                    <label for="haisl">Hasil Extract</label>
                                    <input type="text" id="hasil" class="form-control" style="margin-bottom: 0;">                                    
                                </div> -->
                                <div class="form-group col-md-2">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" class="btn btn-block btn-success m-0">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>