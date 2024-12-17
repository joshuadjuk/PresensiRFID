<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $_SESSION['usr_img']; ?>" class="img-circle" alt="User Image" style="width: 40px; height: 40px; object-fit: cover;">
        </div>
        <div class="info">
          <a href="./index.php?page=user_edit&username=<?php echo $_SESSION['username'];?>" class="d-block"><?php echo $_SESSION['nama']."<br><span style='color: red;'>As: ".$_SESSION['level']."</span>"; ?></a>
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
      <?php
      if($_SESSION['level'] == 'admin'){
        include('menu/admin.php'); 
      }else{
        include('menu/admin.php'); 
      }
      ?>
      <!-- /.sidebar-menu -->
    </div>