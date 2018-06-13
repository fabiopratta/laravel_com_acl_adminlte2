@extends('adminlte::master')


@section('body')
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <!--<img alt="image" class="img-circle" src="URLPHOTO" width="80px" /> -->
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</strong>
                             </span> <span class="text-muted text-xs block"><b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <!-- <li><a href="profile.html">Profile</a></li>
                                 <li><a href="contacts.html">Contacts</a></li>
                                 <li><a href="mailbox.html">Mailbox</a></li> -->
                                <li class="divider"></li>
                                <li>
                                @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                    <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                        <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                    </a>
                                @else
                                    <a href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    >
                                        <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                    </a>
                                    <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                        @if(config('adminlte.logout_method'))
                                            {{ method_field(config('adminlte.logout_method')) }}
                                        @endif
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            SGE
                        </div>

                        @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <!-- nav bar right removed -->
                </nav>
            </div>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @if(config('adminlte.layout') == 'top-nav')
                    <div class="container">
                    @endif

                    <!-- Content Header (Page header) -->
                        <section class="content-header">
                            @yield('content_header')
                        </section>

                        <!-- Main content -->
                        <section class="content">

                            @yield('content')

                        </section>
                        <!-- /.content -->
                        @if(config('adminlte.layout') == 'top-nav')
                    </div>
                    <!-- /.container -->
                @endif
            </div>
            <!-- /.content-wrapper -->

            <div class="footer">
                <div class="pull-right">
                    <a href="mailto:fabiobrotas@hotmail.com">Powered by Fabio Pratta</a>
                </div>
                <div>
                    <strong>Copyright</strong> SAGP &copy; 2018-<?=date("Y");?>
                </div>
            </div>
        </div>
    </div>
@stop
