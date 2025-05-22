@extends('layouts.admin')

@section('title', "Admin")


@section('content')
    <input type="checkbox" id="sidebar-toogle">
    @include('admin.components.sidebar', ['active' => 'Home'])
    <div class="main-content">
        @include('admin.components.header_bar', ['icon'=>'fa-list', 'title'=>'Leads', 'adicionalobj'=>false])
        <main>
            <div class="container">
                @php
                    $time = time();
                @endphp
                <form method="POST" action="{{route('upload_banner')}}" enctype="multipart/form-data">
                    <div class="form-group">
                        @if ($image == null)
                            <img src="/img/no_photo.png?v={{$time}}" id="image-view" class="img-fluid d-block" alt="banner" />
                        @else
                            <img src="/img/{{$image}}?v={{$time}}" id="image-view" class="img-fluid d-block" alt="banner" />
                            <a href="{{route('banner_delete')}}" class="btn btn-danger mt-4">Deletar</a>
                        @endif
                        <input type="file" id="input-file" class="form-control-file mt-4" name="banner"/>
                        <input type="submit" class="btn btn-primary mt-4" value="Upload" />
                    </div>
                </form>
                <div class="mt-4">
                    <table class="table table-dark mt-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Estado</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Categoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                <th scope="row">{{$lead->getId()}}</th>
                                <td>{{$lead->getNome()}}</td>
                                <td>{{$lead->getCidade()}}</td>
                                <td>{{$lead->getEstado()}}</td>
                                <td>{{$lead->getEmail()}}</td>
                                <td>{{$lead->getTelefone()}}</td>
                                <td>{{$lead->getCategoria()}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </main>
    </div>
@endsection

@section("javascripts")
    @encore_entry_script_tags('upload_banner')
@endsection