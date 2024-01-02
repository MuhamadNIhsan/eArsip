  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
	<ul class="navbar-nav ml-auto">
		<li id="clock"></li>
	</ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="https://www.ptjas.co.id/wp-content/uploads/2021/07/logo-JAS-noCASdes_Artboard-2-197x54-1.png" alt="AdminLTE Logo" class="brand-image img-rounded elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">eArsip <i class="fa fa-folder-open-o"></i></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="<?=site_url('users/profile')?>" class="d-block">
		  Welcome, <?= strtoupper($this->session->userdata('name'))?>
		  <?php if($heading == 'Profile'):?>
		  <span class="badge badge-success right"><i class="fa fa-check-circle"></i></span>
		  <?php endif;?>
		  </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?=site_url('dashboard')?>" class="nav-link">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Dashboard
                <i class="right fa fa-angle"></i>
              </p>
			  <?php if($heading == 'Dashboard'):?>
			  <span class="badge badge-success right"><i class="fa fa-check-circle"></i></span>
			  <?php endif;?>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=site_url('docs')?>" class="nav-link">
              <i class="nav-icon fa fa-copy"></i>
              <p>
                Docs
              </p>
			  <?php if($heading == 'Docs'):?>
			  <span class="badge badge-success right"><i class="fa fa-check-circle"></i></span>
			  <?php endif;?>
		    </a>
          </li>
		  <?php if($this->session->userdata('level')=='0'): ?>
          <li class="nav-item <?=($heading == 'Users' | $heading == 'Docs Category' | $heading == 'Box')?'menu-open':''?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-gear"></i>
              <p>
                Settings
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=site_url('users')?>" class="nav-link">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Users Auth</p>
				  <?php if($heading == 'Users'):?>
				  <span class="badge badge-success right"><i class="fa fa-check-circle"></i></span>
				  <?php endif;?>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=site_url('group')?>" class="nav-link">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Group Auth</p>
				  <?php if($heading == 'Group Data'):?>
				  <span class="badge badge-success right"><i class="fa fa-check-circle"></i></span>
				  <?php endif;?>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=site_url('category')?>" class="nav-link">
                  <i class="fa fa-archive nav-icon"></i>
                  <p>Docs Category</p>
				  <?php if($heading == 'Docs Category'):?>
				  <span class="badge badge-success right"><i class="fa fa-check-circle"></i></span>
				  <?php endif;?>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=site_url('boxes')?>" class="nav-link">
                  <i class="fa fa-cube nav-icon"></i>
                  <p>Box</p>
				  <?php if($heading == 'Box'):?>
				  <span class="badge badge-success right"><i class="fa fa-check-circle"></i></span>
				  <?php endif;?>
                </a>
              </li>
            </ul>
          </li>
		  <?php endif;?>
		  <li class="nav-item">
            <a href="<?=site_url('/login/logout')?>" class="nav-link">
              <i class="nav-icon fa fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
		  </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
