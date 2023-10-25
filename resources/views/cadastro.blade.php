<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ url('css/cadastro.css') }}" rel="stylesheet">
    <title>Cadastro</title>
</head>
<body>
    <div class="cadastroBox">
        <h3>Cadastro</h3>
        <form method="post" action="{{ route('cadastro') }}">
            @csrf
            <div class="inputBox">
                <input type="text" name="name" placeholder="Seu Nome"> 
                <input type="text" name="username" placeholder="Usuário"> 
                <input type="password" name="password" placeholder="Senha"> 
                <input type="password" name="password_confirmation" placeholder="Confirma Senha"> 
                
                @if(!$errors->isEmpty())
                    <h4>{{ $errors->first() }}</h4>
                @endif
            </div>
            <input type="submit" value="Cadastrar">
            <button type="button" class="btnBack" onclick="window.history.back()">Voltar</button>
        </form>
    </div>
</body>
</html>
