<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Módulos del Sistema HUV
            <small>Todos los módulos disponibles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('ci/home') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Módulos</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-th-large"></i> Módulos Disponibles del Sistema HUV
                        </h3>
                    </div>
                    <div class="box-body">
                        <p>El sistema HUV cuenta con <strong>40+ módulos</strong> para la gestión integral del Hospital Universitario del Valle.</p>
                        
                        <div class="row">
                            <!-- Módulos Principales -->
                            <div class="col-md-4">
                                <h4><i class="fa fa-star text-yellow"></i> Módulos Principales</h4>
                                <div class="list-group">
                                    <a href="{{ url('ci/equipos') }}" class="list-group-item">
                                        <i class="fa fa-cogs"></i> Equipos Biomédicos
                                    </a>
                                    <a href="{{ url('ci/ordenes') }}" class="list-group-item">
                                        <i class="fa fa-ticket"></i> Órdenes de Trabajo
                                    </a>
                                    <a href="{{ url('ci/preventivos') }}" class="list-group-item">
                                        <i class="fa fa-calendar"></i> Mantenimientos Preventivos
                                    </a>
                                    <a href="{{ url('ci/calibraciones') }}" class="list-group-item">
                                        <i class="fa fa-balance-scale"></i> Calibraciones
                                    </a>
                                    <a href="{{ url('ci/repuestos') }}" class="list-group-item">
                                        <i class="fa fa-puzzle-piece"></i> Repuestos
                                    </a>
                                    <a href="{{ url('ci/usuarios') }}" class="list-group-item">
                                        <i class="fa fa-users"></i> Usuarios del Sistema
                                    </a>
                                </div>
                            </div>

                            <!-- Módulos de Gestión -->
                            <div class="col-md-4">
                                <h4><i class="fa fa-briefcase text-blue"></i> Gestión y Administración</h4>
                                <div class="list-group">
                                    <a href="{{ url('ci/tecnicos') }}" class="list-group-item">
                                        <i class="fa fa-user-md"></i> Técnicos
                                    </a>
                                    <a href="{{ url('ci/servicios') }}" class="list-group-item">
                                        <i class="fa fa-hospital-o"></i> Servicios
                                    </a>
                                    <a href="{{ url('ci/areas') }}" class="list-group-item">
                                        <i class="fa fa-building"></i> Áreas
                                    </a>
                                    <a href="{{ url('ci/categorias') }}" class="list-group-item">
                                        <i class="fa fa-tags"></i> Categorías
                                    </a>
                                    <a href="{{ url('ci/contactos') }}" class="list-group-item">
                                        <i class="fa fa-phone"></i> Contactos
                                    </a>
                                    <a href="{{ url('ci/propietarios') }}" class="list-group-item">
                                        <i class="fa fa-user"></i> Propietarios
                                    </a>
                                    <a href="{{ url('ci/mantenimientos') }}" class="list-group-item">
                                        <i class="fa fa-wrench"></i> Mantenimientos
                                    </a>
                                </div>
                            </div>

                            <!-- Módulos Especializados -->
                            <div class="col-md-4">
                                <h4><i class="fa fa-cog text-green"></i> Módulos Especializados</h4>
                                <div class="list-group">
                                    <a href="{{ url('ci/invimas') }}" class="list-group-item">
                                        <i class="fa fa-certificate"></i> INVIMA
                                    </a>
                                    <a href="{{ url('ci/ordenes_compra') }}" class="list-group-item">
                                        <i class="fa fa-shopping-cart"></i> Órdenes de Compra
                                    </a>
                                    <a href="{{ url('ci/manuales') }}" class="list-group-item">
                                        <i class="fa fa-book"></i> Manuales
                                    </a>
                                    <a href="{{ url('ci/guias') }}" class="list-group-item">
                                        <i class="fa fa-file-text"></i> Guías Rápidas
                                    </a>
                                    <a href="{{ url('ci/bajas') }}" class="list-group-item">
                                        <i class="fa fa-trash"></i> Bajas de Equipos
                                    </a>
                                    <a href="{{ url('ci/archivos') }}" class="list-group-item">
                                        <i class="fa fa-folder"></i> Archivos
                                    </a>
                                    <a href="{{ url('ci/reportes') }}" class="list-group-item">
                                        <i class="fa fa-bar-chart"></i> Reportes
                                    </a>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Módulos Adicionales -->
                        <div class="row">
                            <div class="col-md-12">
                                <h4><i class="fa fa-plus-circle text-purple"></i> Módulos Adicionales</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/equipos_industriales') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-industry"></i> Equipos Industriales
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/correctivos_generales') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-tools"></i> Correctivos Generales
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/contingencias') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-exclamation-triangle"></i> Contingencias
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/capacitaciones') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-graduation-cap"></i> Capacitaciones
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/cambios_ubicaciones') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-exchange"></i> Cambios Ubicaciones
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/avances_correctivos') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-progress"></i> Avances Correctivos
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/estadoequipos') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-info-circle"></i> Estado Equipos
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('ci/repuestos_pendientes') }}" class="btn btn-default btn-block">
                                            <i class="fa fa-clock-o"></i> Repuestos Pendientes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Información del Sistema -->
                        <div class="alert alert-info">
                            <h4><i class="fa fa-info-circle"></i> Información del Sistema</h4>
                            <p><strong>Total de módulos:</strong> 40+ módulos especializados</p>
                            <p><strong>Vistas originales:</strong> Todas las vistas mantienen su estructura original de CodeIgniter</p>
                            <p><strong>Base de datos:</strong> MySQL (veihuv)</p>
                            <p><strong>Usuario actual:</strong> {{ session('nombre') }} ({{ session('email') }})</p>
                        </div>

                        <!-- Enlaces de navegación -->
                        <div class="text-center">
                            <a href="{{ url('ci/home') }}" class="btn btn-primary">
                                <i class="fa fa-home"></i> Volver al Inicio
                            </a>
                            <a href="{{ url('/') }}" class="btn btn-info">
                                <i class="fa fa-laravel"></i> Laravel App
                            </a>
                            <a href="{{ url('test-db') }}" class="btn btn-warning">
                                <i class="fa fa-database"></i> Test Base de Datos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->