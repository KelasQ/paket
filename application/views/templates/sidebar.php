<div class="page-wrap">
    <div class="app-sidebar colored">
        <div class="sidebar-header">
            <a class="header-brand" href="index.html">
                <div class="logo-img">
                    <img src="<?= base_url(); ?>assets/src/img/brand-white.svg" class="header-brand-img" alt="lavalite">
                </div>
                <span class="text">ThemeKit</span>
            </a>
            <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
            <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
        </div>
        <div class="sidebar-content">
            <div class="nav-container">
                <nav id="main-menu-navigation" class="navigation-main">
                    <div class="nav-lavel">Dashboard</div>
                    <div class="nav-item <?php if ($parent_active == 'dashboard') echo 'active'; ?>">
                        <a href="<?= base_url(); ?>dashboard" class="menu-item"><i class="ik ik-home"></i><span>Dashboard</span></a>
                    </div>
                    <?php if ($this->session->userdata('role') == "1") : ?>
                        <div class="nav-lavel">User Management</div>
                        <div class="nav-item <?php if ($parent_active == 'user') echo 'active'; ?>">
                            <?php if ($this->session->userdata('role') == "1") : ?>
                                <a href="<?= base_url(); ?>user" class="menu-item"><i class="ik ik-user"></i><span>Data User</span></a>
                            <?php endif ?>
                        </div>

                        <div class="nav-item <?php if ($parent_active == 'timeline') echo 'active'; ?>">
                            <?php if ($this->session->userdata('role') == "1") : ?>
                                <a href="<?= base_url('timeline'); ?>" class="menu-item"><i class="ik ik-truck"></i><span>Data Timeline</span></a>
                            <?php endif ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('role') == "1" || $this->session->userdata('role') == "2" || $this->session->userdata('role') == "4") : ?>
                        <div class="nav-lavel">Data</div>
                    <?php endif; ?>
                    <div class="nav-item <?php if ($parent_active == 'invoice') echo 'active'; ?>">
                        <?php if ($this->session->userdata('role') == "4") : ?>
                            <a href="<?= base_url('invoice'); ?>" class="menu-item"><i class="ik ik-box"></i><span>Invoice</span></a>
                        <?php endif; ?>
                    </div>
                    <!-- <div class="nav-item <?php if ($parent_active == 'scan') echo 'active'; ?>">
                                    <?php if ($this->session->userdata('role') == "2") : ?>
                                    <a href="<?= base_url(); ?>paket/tambah" class="menu-item"><i class="ik ik-box"></i><span>Scan</span></a>
                                    <?php endif; ?>
                                </div> -->
                    <div class="nav-item <?php if ($parent_active == 'paket')  echo 'active'; ?>">
                        <?php if ($this->session->userdata('role') == "1") : ?>
                            <a href="<?= base_url(); ?>paket/filter" class="menu-item"><i class="ik ik-truck"></i><span>Laporan Data Scan</span></a>
                        <?php endif; ?>
                        <?php if ($this->session->userdata('role') == 2) :  ?>
                            <a href="<?= base_url(); ?>paket" class="menu-item"><i class="ik ik-truck"></i><span>Laporan</span></a>
                        <?php endif; ?>
                        <?php if ($this->session->userdata('role') == 3) : ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($this->session->userdata('role') == '3') : ?>
                        <div class="nav-item <?php if ($parent_active == 'kasir') echo 'active'; ?>">
                            <a href="<?= base_url(); ?>kasir" class="menu-item"><i class="ik ik-truck"></i><span>Laporan Pencocokan</span></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('role') == '1') : ?>
                        <div class="nav-item <?php if ($parent_active == 'check_invoice') echo 'active'; ?>">
                            <a href="<?= base_url(); ?>paket/invoice" class="menu-item"><i class="ik ik-truck"></i><span>Laporan Check Invoice</span></a>
                        </div>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>