  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="<?php echo base_url(); ?>/public/assets/admin/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"><?php echo get_general_settings()->application_name ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="<?php echo base_url(); ?>/public/assets/admin/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">Alexander Pierce</a>
              </div>
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
                      <a href="<?php echo admin_url() ?>" class="nav-link <?php is_admin_nav_active(['admin', '']); ?>">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p><?php echo trans('dashboard') ?> </p>
                      </a>
                  </li>

                  <li class="nav-header"><?php echo trans('users') ?> Management</li>

                  <li class="nav-item <?php is_admin_nav_active(['users', 'edit-user', 'add-user', 'administrators'], 'menu-open'); ?>">
                      <a href="#" class="nav-link <?php is_admin_nav_active(['users', 'edit-user', 'administrators'], 'active'); ?>">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              <?php echo trans("users"); ?>
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>

                      <ul class="nav nav-treeview">

                          <li class="nav-item">
                              <a href="<?php echo admin_url() ?>add-user" class="nav-link <?php is_admin_nav_active(['add-user']); ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p><?php echo trans("add_user"); ?></p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="<?php echo admin_url() ?>administrators" class="nav-link <?php is_admin_nav_active(['administrators']); ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p><?php echo trans("administrators"); ?></p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="<?php echo admin_url() ?>users" class="nav-link <?php is_admin_nav_active(['users', 'edit-user']); ?>">
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