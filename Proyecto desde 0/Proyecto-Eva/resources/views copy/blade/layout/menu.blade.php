<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name ?? 'Usuario' }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVEGACIÓN PRINCIPAL</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="{{ url('equipos_ind/Cequipos_ind') }}"><i class="fa fa-circle-o"></i> Equipos industriales</a></li>
            <li><a href="{{ url('orden/Cordenes') }}"><i class="fa fa-circle-o"></i> Ordenes de mantenimiento</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-hdd"></i> <span>Equipos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('equipo/Cequipos') }}"><i class="fa fa-circle-o"></i> Equipos Biomédicos</a></li>
            <li><a href="{{ url('equipos_ind/Cequipos_ind') }}"><i class="fa fa-circle-o"></i> Equipos Industriales</a></li>
            <li><a href="{{ url('equipo/Cbajas') }}"><i class="fa fa-circle-o"></i> Bajas de equipos</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-ticket"></i> <span>Órdenes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('orden/Cordenes') }}"><i class="fa fa-circle-o"></i> Mis Tickets</a></li>
            <li><a href="{{ url('orden/Cordenes/list_active') }}"><i class="fa fa-circle-o"></i> Tickets activos</a></li>
            <li><a href="{{ url('orden/Cordenes/list_closed') }}"><i class="fa fa-circle-o"></i> Tickets cerrados</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('reportes/equipos') }}"><i class="fa fa-circle-o"></i> Equipos</a></li>
            <li><a href="{{ url('reportes/mantenimientos') }}"><i class="fa fa-circle-o"></i> Mantenimientos</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-cog"></i> <span>Configuración</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('usuarios') }}"><i class="fa fa-circle-o"></i> Usuarios</a></li>
            <li><a href="{{ url('roles') }}"><i class="fa fa-circle-o"></i> Roles</a></li>
            <li><a href="{{ url('permisos') }}"><i class="fa fa-circle-o"></i> Permisos</a></li>
          </ul>
        </li>

        <li><a href="{{ url('ayuda') }}"><i class="fa fa-book"></i> <span>Ayuda</span></a></li>

        <li class="header">ETIQUETAS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Importante</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Advertencia</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Información</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
