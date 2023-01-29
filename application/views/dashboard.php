<div class="main-content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>PAKET <?php echo (int)$paket['checked'][0]->discan + (int)$paket['not_checked'][0]->discan; ?></h6>
                                <div class="mt-2">
                                    <table class="w-100">
                                        <tr>
                                            <td>Telah di cek</td>
                                            <td>:</td>
                                            <td><?php echo (int)$paket['checked'][0]->discan; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Belum di cek</td>
                                            <td>:</td>
                                            <td><?php echo (int)$paket['not_checked'][0]->discan; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Total Scan <?php echo count($paket['all']); ?></h6>
                                <div class="mt-2">
                                    <table class="w-100">
                                        <?php foreach ($paket['per_user'] as $user) :  ?>
                                            <tr>
                                                <td><?php echo $user->username ?></td>
                                                <td>:</td>
                                                <td><?php echo $user->discan; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
            <?php if ($this->session->userdata('role') == 1) : ?>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div class="state w-100">
                                    <h6>Pengaturan Batas Login</h6>
                                    <form action="" class="w-100">
                                        <?php
                                        $jam_mulai = explode(':', $jam['mulai']);
                                        $jam_selesai = explode(':', $jam['selesai']);
                                        ?>
                                        <div class="form-group">
                                            <label for="">Jam Mulai</label>
                                            <div class="form-row">
                                                <div class="col-6">
                                                    <input type="number" min="1" max="23" name="jam_mulai" class="form-control" id="i-jam_mulai" value="<?php echo (int)$jam_mulai[0] ?>">
                                                </div>
                                                <div class="col-6">
                                                    <input type="number" min="1" max="59" name="menit_mulai" class="form-control" id="i-menit_mulai" value="<?php echo (int)$jam_mulai[1] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Jam Selesai</label>
                                            <div class="form-row">
                                                <div class="col-6">
                                                    <input type="number" min="1" max="23" name="jam_selesai" class="form-control" id="i-menit_selesai" value="<?php echo (int)$jam_selesai[0] ?>">
                                                </div>
                                                <div class="col-6">
                                                    <input type="number" min="1" max="59" name="menit_selesai" class="form-control" id="i-menit_selesai" value="<?php echo (int)$jam_selesai[1] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" id="js-update-jam-kerja">Apply</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card shadow">
                    <div class="card-body">
                        <strong>User Online</strong>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Last Aktive</th>
                                </thead>
                                <tbody class="listUserOnline"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card shadow">
                    <div class="card-body">
                        <strong>User Offline</strong>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Last Aktive</th>
                                </thead>
                                <tbody class="listUserOffline"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>