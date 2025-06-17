        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    <li>
                        <a href="{{ url('Home') }}">
                            <i class="fa fa-home"></i> <span>Inicio</span>
                        </a>
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
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->
