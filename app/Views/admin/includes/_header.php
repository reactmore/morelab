<!-- Navbar -->
<nav class="main-header navbar navbar-expand <?php echo check_dark_mode_enabled() ? 'navbar-dark' : 'navbar-white' ?> navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
            <span id="ct7" class="nav-link"></span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?php echo base_url(); ?>/public/assets/admin/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?php echo base_url(); ?>/public/assets/admin/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?php echo base_url(); ?>/public/assets/admin/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">

            <a data-toggle="dropdown" href="#">
                <img src="<?php echo get_user_avatar(user()->avatar); ?>" class="img-circle elevation-2 user-image mt-1" width="30px" alt="User Image">
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                <a href="<?php echo admin_url() ?>profile" class="dropdown-item">
                    <?php echo trans('settings') ?>

                    <span class="float-right text-muted text-sm"><i class="fas fa-cog"></i></span>
                </a>
                <?php echo form_open('vr-switch-mode', ['id' => 'swith_dark_mode']); ?>
                <?php if (check_dark_mode_enabled() == 1) : ?>
                    <input type="hidden" name="dark_mode" value="0" />
                    <a href="javascript: void(0);" class="dropdown-item" onclick="document.getElementById('swith_dark_mode').submit();">
                        Swith Light Mode
                        <span class="float-right text-muted text-sm"><i class="fa fa-sun"></i></span>
                    </a>
                <?php else : ?>
                    <input type="hidden" name="dark_mode" value="1" />
                    <a href="javascript: void(0);" class="dropdown-item" onclick="document.getElementById('swith_dark_mode').submit();">
                        Swith Dark Mode
                        <span class="float-right text-muted text-sm"><i class="fa fa-moon"></i></span>
                    </a>
                <?php endif; ?>
                <?php echo form_close(); ?>


                <div class="dropdown-divider"></div>

                <a href="<?php echo generate_url('logout'); ?>" class="dropdown-item">
                    <?php echo trans('logout') ?>
                    <span class="float-right text-muted text-sm"><i class="fas fa-sign-out-alt"></i></span>
                </a>


            </div>
        </li>

    </ul>
</nav>
<!-- /.navbar -->