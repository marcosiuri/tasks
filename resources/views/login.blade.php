<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ url('css/login.css') }}" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="loginBox">
        <h3>Login</h3>
        <form method="post" action="{{ route('loginpost') }}">
            @csrf
            <div class="inputBox">
                <input id="username" type="text" name="username" placeholder="Usuário"> 
                <input id="pass" type="password" name="password" placeholder="Senha"> 
                
                @if(!$errors->isEmpty())
                    <h4>Credenciais inválidas</h4>
                @endif
            </div>
            <input type="submit" value="Acessar">
            <button type="button" class="btnBack" onclick="window.history.back()">Voltar</button>
        </form>
    </div>
</body>
</html>
