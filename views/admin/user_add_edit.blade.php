@extends('layouts.admin')

@section('title', "Admin")


@section('content')
    <input type="checkbox" id="sidebar-toogle">
    @include('admin.components.sidebar', ['active' => 'Users'])
    <div class="main-content">
        @include('admin.components.header_bar', ['icon'=>'fa-user', 'title'=>'User', 'adicionalobj'=>false])
        <main>
            <div class="container">
                <a href="{{route('admin_users')}}" class="btn btn-primary">Voltar</a>
                @if ($isEdit == false)
                    <form method="POST" class="mt-4" action="{{route('admin_users_create')}}">
                        @foreach($app->getFlashes('error') as $error)
                            <div class="alert alert-danger">
                                {{$error}}
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nome">
                        </div>
                        <div class="form-group">
                            <label for="username">User:</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="User">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Salvar"/>
                    </form>
                @else
                    <form method="POST" class="mt-4" action="{{route('admin_users_update', ["id"=>$user->getId()])}}">
                        @foreach($app->getFlashes('error') as $error)
                            <div class="alert alert-danger">
                                {{$error}}
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$user->getNome()}}" placeholder="Nome">
                        </div>
                        <div class="form-group">
                            <label for="username">User:</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{$user->getUsername()}}" placeholder="User">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{$user->getEmail()}}" placeholder="E-mail">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Salvar"/>
                    </form>
                @endif
            </div>
        </main>
    </div>
@endsection