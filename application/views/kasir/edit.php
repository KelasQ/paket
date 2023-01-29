<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Data Paket</h5>
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
                        
                        <?php echo $this->session->flashdata('message');?>  

                        <?php echo form_open_multipart('kasir/update/' . $data->id);?>
                            
                            <input type="hidden" name="id" id="i-id" value="<?php echo $data->id; ?>">
                            <input type="hidden" name="old_invoice" value="<?php echo $data->invoice; ?>">
                            <input type="hidden" name="start" value="<?php echo $this->input->get('start'); ?>">
                            <input type="hidden" name="end" value="<?php echo $this->input->get('end'); ?>">
                            <!--<div class="form-group">-->
                            <!--    <label for="i-no_invoice">No Invoice</label>-->
                            <!--    <input name="no_invoice" type="text" class="form-control" id="i-no_invoice" value="<?php echo $data->no_invoice; ?>">-->
                            <!--</div>-->

                            
                            <div class="form-group">
                                <label for="i-keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="i-keterangan" rows="3"><?php echo $data->keterangan; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="i-invoice">Invoice</label>
                                <!-- <input name="invoice" type="file" class="form-control" id="i-invoice"> -->
                                <div id="imagePreviewContainer" class="mt-2">
                                    <img id="imagePreview" class="img-fluid" src="<?php if($data->invoice) echo base_url('/uploads/kasir/' . $data->invoice) ?>">
                                </div>
                            </div>

    
                            <button type="submit" class="btn btn-success mr-2" id="saveKasir">Submit</button>
                            <?php 
                            
                            $url = 'start=' . $this->input->get('start'); 
                            $url .= '&end=' . $this->input->get('end');
                            ?>
                            <button type="button" onclick="location.href='<?=base_url('/kasir/lists/?' . $url );?>'" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>