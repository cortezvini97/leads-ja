@extends('layouts.admin')

@section('title', "Admin")


@section('content')
    <input type="checkbox" id="sidebar-toogle">
    @include('admin.components.sidebar', ['active' => 'Users'])
    <div class="main-content">
        @include('admin.components.header_bar', ['icon'=>'fa-user', 'title'=>'User', 'adicionalobj'=>false])
        <main>
            <div class="container">
                <a href="{{route('admin_users_add')}}" class="btn btn-primary">Cria Novo Usuário</a>
                <table class="table table-dark mt-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Username</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @if($user->getId() != $app->getUser()->getId())
                                <tr>
                                    <th scope="row">{{$user->getId()}}</th>
                                    <td>{{$user->getNome()}}</td>
                                    <td>{{$user->getUserName()}}</td>
                                    <td>{{$user->getEmail()}}</td>
                                    <td><a href="{{route('admin_users_edit', ['id'=>$user->getId()])}}" class="btn btn-primary">Editar</a> | <a onclick="return confirm('Tem certeza que deseja deletar este usuário ?')" href="{{route('admin_users_delete', ["id"=>$user->getId()])}}" class="btn btn-danger">Deletar</a></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection