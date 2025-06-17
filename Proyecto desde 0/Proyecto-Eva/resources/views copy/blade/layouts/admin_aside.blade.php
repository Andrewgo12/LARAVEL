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
                            <li><a href="{{ url('equipo/Cbajas') }}"><i class="fa fa-circle-o"></i> Bajas de equipos biomédicos</a></li>
                            <li><a href="{{ url('equipo/Cinvimas') }}"><i class="fa fa-circle-o"></i> Registros sanitarios</a></li>
                            <li><a href="{{ url('ordenes_compra/Cordenes_compra') }}"><i class="fa fa-circle-o"></i> Soportes de compra</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-calendar"></i> <span>Planes de mantenimiento</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('mantenimiento/Cplanes') }}"><i class="fa fa-circle-o"></i> Planes de mantenimiento</a></li>
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
                            <i class="glyphicon glyphicon-wrench"></i> <span>Repuestos</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('repuesto/Crepuestos') }}"><i class="fa fa-circle-o"></i> Repuestos</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-list-alt"></i> <span>Capacitaciones</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('capacitacion/Ccapacitaciones') }}"><i class="fa fa-circle-o"></i> Capacitaciones</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('reporte/Creportes') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cogs"></i> <span>Configuración</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('ubicacion/Cservicios') }}"><i class="fa fa-circle-o"></i> Servicios</a></li>
                            <li><a href="{{ url('ubicacion/Cestadoequipos') }}"><i class="fa fa-circle-o"></i> Estados</a></li>
                            <li><a href="{{ url('contacto/Ccontactos') }}"><i class="fa fa-circle-o"></i> Contactos</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

