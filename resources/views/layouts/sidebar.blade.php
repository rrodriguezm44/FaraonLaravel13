<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
     <div class="navbar-brand-box">
        <a href="{{url('index')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/rubik.png') }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/zysd.png') }}" alt="" height="40">
            </span>
        </a>

        <a href="{{url('index')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/rubik.png') }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/zys.png') }}" alt="" height="40">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>

                <li>
                    <a href="{{url('index')}}">
                        <i class="uil-home-alt"></i><span class="badge rounded-pill bg-primary float-end">01</span>
                        <span>@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <li class="menu-title">Administracion</li>
                 <li>
                    <a href="{{ route('listar_empleado') }}" class="waves-effect">
                       <i class="uil uil-user"></i>
                        <span>Empleados</span>
                    </a>
                </li>


                <li class="menu-title">Operaciones</li>
                 <li>
                    <a href="{{ route('lista_categoria') }}" class="waves-effect">
                       <i class="uil uil-cog"></i>
                        <span>Categorías</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('lista_servicios') }}" class="waves-effect">
                       <i class="uil uil-briefcase-alt"></i>
                        <span>Servicios</span>
                    </a>
                </li>

               <li class="menu-title text-danger">Configuración</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil uil-shield-check text-danger"></i>
                        <span>Seguridad</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="">
                                <i class="uil uil-users-alt me-1"></i> Roles
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('permisos.index') }}">
                                <i class="uil uil-lock-access me-1"></i> Permisos
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
