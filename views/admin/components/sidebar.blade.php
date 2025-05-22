<div class="sidebar">
    <div class="sidebar-header">
        <h3 class="brand">
            <span class="ti-unlink"></span> 
            <span>Dashboard</span>
        </h3> 
        <label id="toogle-click" class="fas fa-bars"></label>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{route('admin_home')}}" @if($active == "Home") class="ativo" @endif>
                    <span class="fas fa-home"></span>
                    <span>Início</span>
                </a>
            </li>
            @if(in_array('ROLE_ROOT', $app->getUser()->getRoles()))
                <li>
                    <a href="{{route('admin_users')}}" @if($active == "Users") class="ativo" @endif>
                        <span class="fas fa-user"></span>
                        <span>Users</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{route('app_logout')}}">
                    <span class="fas fa-sign-out-alt"></span>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </div>
</div>