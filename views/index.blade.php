@extends('layouts.app')

@section('title', 'Concorra a Brindes - Evento')

@section('content')
    @php 
        $time = time();
    @endphp
    <div class="container">
        <!-- Página Inicial -->
        <div class="home-page" id="homePage">
            <h1>Participe e Concorra a Brindes Exclusivos!</h1>
            @if($image == null)
                <img src="/img/no_photo.png?v={{$time}}" alt="Kit de Brindes" class="gift-image">
            @else 
                <img src="/img/{{$image}}?v={{$time}}" alt="Kit de Brindes" class="gift-image">
            @endif
            <button class="btn" id="participateBtn">Pressione e concorra</button>
        </div>

        <!-- Página de Formulário -->
        <div class="form-page" id="formPage">
            <h1>Preencha seus dados</h1>
            <form id="leadForm" method="post" action="{{route('app_send')}}">
                <div class="form-group">
                    <label for="name">Nome*</label>
                    <input type="text" id="name" name="name" required>
                    <div class="error" id="nameError">Por favor, informe seu nome.</div>
                </div>

                <div class="form-group">
                    <label for="city">Cidade*</label>
                    <input type="text" id="city" name="city" required>
                    <div class="error" id="cityError">Por favor, informe sua cidade.</div>
                </div>

                <div class="form-group">
                    <label for="state">Estado*</label>
                    <select id="state" name="state" required>
                        <option value="">Selecione seu estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                    <div class="error" id="stateError">Por favor, selecione seu estado.</div>
                </div>

                <div class="form-group">
                    <label for="email">E-mail*</label>
                    <input type="email" id="email" name="email" required>
                    <div class="error" id="emailError">Por favor, informe um e-mail válido.</div>
                </div>

                <div class="form-group">
                    <label for="phone">Telefone*</label>
                    <input type="tel" id="phone" name="phone" required>
                    <div class="error" id="phoneError">Por favor, informe um telefone válido.</div>
                </div>

                <div class="form-group">
                    <label for="category">Categoria*</label>
                    <select id="category" name="category" required>
                        <option value="">Selecione uma categoria</option>
                        <option value="veterinario">Veterinário</option>
                        <option value="pecuarista">Pecuarista</option>
                        <option value="estudante">Estudante</option>
                        <option value="outros">Outros</option>
                    </select>
                    <div class="error" id="categoryError">Por favor, selecione uma categoria.</div>
                </div>

                <button type="submit" class="btn">Concluir</button>
            </form>

            <div class="success-message" id="successMessage">
                <h2>Obrigado pela sua participação!</h2>
                <p>Você já está concorrendo aos brindes exclusivos.</p>
            </div>
        </div>
    </div>
@endsection