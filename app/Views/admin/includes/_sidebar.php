  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo admin_url(); ?>" class="brand-link">
          <img src="<?php echo base_url(); ?>/public/assets/admin/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"><?php echo get_general_settings()->application_name ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">

          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                  <li class="nav-item">
                      <a href="<?php echo admin_url() ?>dashboard" class="nav-link <?php is_admin_nav_active(['dashboard'], 2); ?>">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p><?php echo trans('dashboard') ?> </p>
                      </a>
                  </li>

                  <li class="nav-header"><?php echo trans('users') ?> Management</li>

                  <li class="nav-item <?php is_admin_nav_active(['users', 'administrators'], 2, 'menu-open'); ?>">
                      <a href="#" class="nav-link <?php is_admin_nav_active(['users', 'administrators'], 2, 'active'); ?>">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              <?php echo trans("users"); ?>
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>

                      <ul class="nav nav-treeview">

                          <li class="nav-item">
                              <a href="<?php echo admin_url() ?>users/add-user" class="nav-link ">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p><?php echo trans("add_user"); ?></p>

                              </a>
                          </li>

                          <li class="nav-item">

                              <a href="<?php echo admin_url() ?>administrators" class="nav-link ">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p><?php echo trans("administrators"); ?></p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="<?php echo admin_url() ?>users/list-users" class="nav-link ">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p><?php echo trans("users"); ?></p>
                              </a>
                          </li>
                      </ul>
                  </li>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>