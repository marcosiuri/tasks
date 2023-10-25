<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ url('css/perfil.css') }}" rel="stylesheet">
    <title>Perfil do Usuário</title>
    
</head>
<body>
    <header>
        <nav>
            <h1>Bem-vindo, {{ Auth::user()->name }}!</h1>
            <div class="btn">
                <button style="background-color: rgb(0, 187, 255);color:white; border: none;text-decoration: none;"><a href="{{ route('main') }}">Tarefas</a></button>
                <button style="background-color: rgb(0, 187, 255);color:white; border: none;text-decoration: none;"><a href="{{ route('logout') }}">Sair</a></button>
            </div>
        </nav>
    </header>

    <div class="loginBox">
        <h1 style="color:black;">Perfil do Usuário</h1>

            @if(session('error'))
            <div style="color: red;">{{ session('error') }}</div>
            @endif
            @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
            @endif

            <form action="{{ route('users.update', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="content-container">
                <div id="imagem-preview-container" onclick="selecionarImagem()">
                    @if($user->imagem_perfil)
                        <img src="{{ asset('imagens_perfil/' . $user->imagem_perfil) }}"  id="imagem-preview">
                    @else
                    @endif
                </div>
            
                <div class="informacoes">
                    <label for="nome">Nome:</label>
                    <label for="nome">{{ Auth::user()->name }}</label>
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" value="{{ $user->data_nascimento }}" required>
                </div>
            </div>

            <input type="file" name="imagem_perfil" id="imagem_perfil" accept="image/*" style="display: none;">
            <br>
            <input type="submit" value="Atualizar Perfil">
            </form>

    </div>

    <div class="loginBox">
        <h3>Atualizar Senha</h3>
        @isset($user)
            <form id="password-update-form" method="post" action="{{ route('users.update', ['id' => $user->id]) }}">
                @csrf
                <div class="inputBox">
                    <label for="password">Nova Senha:</label>
                    <input type="password" name="password" class="form-control" placeholder="Escreva uma nova senha">

                    <label for="password_confirmation">Confirme a Senha:</label>
                    <input type="password" name="password_confirmation" placeholder="Confirma Senha">

                    @if(!$errors->isEmpty())
                        <h4>Credenciais inválidas</h4>
                    @endif
                </div>
                <input type="submit" value="Atualizar">
            </form>
        @else
            <p>Usuário não autenticado.</p>
        @endisset
    </div>

    <footer>
        <p>Rodapé da Página</p>
    </footer>

    <script>
        function selecionarImagem() {
            document.getElementById('imagem_perfil').click();
        }

        document.getElementById('imagem_perfil').addEventListener('change', function(event) {
            var previewContainer = document.getElementById('imagem-preview-container');
            var fileInput = event.target;

            previewContainer.innerHTML = '';

            if (fileInput.files.length > 0) {
                var img = document.createElement('img');
                img.src = URL.createObjectURL(fileInput.files[0]);
                img.alt = 'Imagem de Perfil';
                img.id = 'imagem-preview';
                previewContainer.appendChild(img);
            }
        });
    </script>
</body>
</html>
