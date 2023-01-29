<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
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
                        <?php echo form_open_multipart('kasir/lists', [ 'method' => 'GET' ]);?>
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