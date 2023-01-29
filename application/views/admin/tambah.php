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

                        <?php echo form_open_multipart( 'invoice/add/' );?>
                            
                            <input type="hidden" name="id" id="i-id" value="">
                            <input type="hidden" name="old_invoice" value="">
                            <input type="hidden" name="start" value="<?php echo $this->input->get('start'); ?>">
                            <input type="hidden" name="end" value="<?php echo $this->input->get('end'); ?>">

                            <div class="form-group">
                                <label for="i-no_invoice">No Invoice</label>
                                <input name="no_invoice" type="text" class="form-control" id="i-no_invoice" value="">
                            </div>

                            <div class="form-group">
                                <label for="i-invoice">Invoice</label>
                                <input name="invoice" type="file" class="form-control" id="i-invoice">
                                
                                <div id="preview-file"></div>
                            </div>

                            <div class="form-group">
                                <label for="i-stock">Stock</label>
                                <select name="stock" id="i-stock" class="form-control">
                                    <option value="IN STOCK">IN STOCK</option>
                                    <option value="OUT OF STOCK">OUT OF STOCK</option>
                                </select>
                            </div>

    
                            <button type="submit" class="btn btn-success mr-2" id="js-add-invoice">Submit</button>
                            <button type="button" onclick="location.href='<?=base_url('/invoice');?>'" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>