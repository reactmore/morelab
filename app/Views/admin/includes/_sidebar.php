  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo admin_url(); ?>" class="brand-link">
          <img src="<?php echo base_url(); ?>/assets/admin/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"><?php echo get_general_settings()->application_name ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->


          <!-- SidebarSearch Form -->
          <div class="form-inline mt-3">
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
                  <?php foreach ($MenuCategory as $mCategory) : ?>
                      <li class="nav-header"> <?php echo $mCategory['menu_category']; ?></li>
                      <?php
                        $Menu = getMenu($mCategory['menuCategoryID'], user()->role);
                        foreach ($Menu as $menu) :
                            if ($menu['parent'] == 0) :
                        ?>
                              <li class="nav-item">
                                  <a href="<?php echo admin_url() . $menu['url'] ?>" class="nav-link <?php echo ($segment == $menu['url']) ? 'active' : ''; ?>">
                                      <i class="nav-icon <?php echo $menu['icon']; ?>"></i>
                                      <p><?php echo trans($menu['title']); ?></p>
                                  </a>
                              </li>
                          <?php
                            else :
                                $SubMenu =  getSubMenu($menu['menu_id'], user()->role);
                            ?>

                              <li class="nav-item <?php echo ($segment == $menu['url']) ? 'menu-open' : ''; ?>">
                                  <a href="#" class="nav-link <?php echo ($segment == $menu['url']) ? 'active' : ''; ?>">
                                      <i class="nav-icon <?php echo $menu['icon']; ?>"></i>
                                      <p>
                                          <?php echo trans($menu['title']); ?>
                                          <i class="right fas fa-angle-left"></i>
                                      </p>
                                  </a>

                                  <ul class="nav nav-treeview">
                                      <!-- on submenu  -->
                                      <?php foreach ($SubMenu as $subMenu) : ?>
                                          <li class="nav-item">
                                              <a href="<?php echo admin_url() . $menu['url'] . '/' . $subMenu['url']; ?>" class="nav-link ">
                                                  <i class="far fa-circle nav-icon"></i>
                                                  <p><?php echo trans($subMenu['title']); ?></p>

                                              </a>
                                          </li>

                                      <?php endforeach; ?>

                                  </ul>
                              </li>


                      <?php
                            endif;
                        endforeach;
                        ?>
                  <?php endforeach; ?>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>