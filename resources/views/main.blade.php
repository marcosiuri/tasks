<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="{{ url('css/main.css') }}" rel="stylesheet">

    <title>Task Now</title>
</head>
<body>

    <header>
        <nav>
            <h1>Bem-vindo à Task Now</h1>
            @if(auth()->check())
             <div>
                <label for="dropdown" id="dropdownLabel">Escolha uma opção:</label>
                <select id="dropdown" name="dropdown" onchange="navigateToSection()" aria-labelledby="dropdownLabel">
                    <option value="#incluir"><a href="{{ route('add.task') }}">Incluir na Lista</a></option>
                    <option value="#ver">Ver Lista de Tarefa</option>
                </select>
             </div>

                <div>
                    <button style="background-color: rgb(0, 187, 255);color:white; border: none;text-decoration: none;"><a href="{{ route('perfil') }}">Perfil</a></button>
                    <button style="background-color: rgb(0, 187, 255);color:white; border: none;text-decoration: none;"><a href="{{ route('logout') }}">Sair</a></button>
                </div>
            @else  
                
                <div>
                <button style="background-color: rgb(0, 187, 255);color:white; border: none;text-decoration: none;"><a href="{{ route('login') }}">Entrar</a></button>
                <button style="background-color: rgb(0, 187, 255);color:white; border: none;text-decoration: none;"><a href="{{ route('cadastro') }}">Cadastrar</a></button>
                </div>
            @endif
        </nav>
    </header>


    <div class="tt">
    <p>Bem-vindo ao Task Now!

        Explorar novas fronteiras, desafiar a rotina diária e tornar a gestão de tarefas mais eficiente é o que nos inspira. No Task Now, oferecemos uma plataforma dedicada a simplificar sua vida, proporcionando uma experiência única na organização e acompanhamento das suas tarefas diárias.
        
        Nossa missão é transformar a maneira como você gerencia suas responsabilidades, proporcionando uma jornada simples e intuitiva. Seja você um profissional ocupado, um estudante dedicado ou alguém em busca de otimizar seu tempo, o Task Now é o seu companheiro ideal.
        
        Recursos inovadores, design intuitivo e uma abordagem centrada no usuário fazem do Task Now uma ferramenta indispensável para quem busca eficiência e produtividade. Desde a inclusão de novas tarefas até a visualização clara do seu progresso, estamos aqui para simplificar o seu dia a dia.
        
        Junte-se a nós nesta jornada em direção a uma vida mais organizada, produtiva e recompensadora. Descubra como o Task Now pode fazer a diferença na forma como você encara suas tarefas diárias. É hora de conquistar o seu tempo e tornar cada dia mais produtivo!
        
        Seja bem-vindo ao Task Now - O Seu Parceiro na Jornada da Produtividade!</p>
    </div>


    
    <main>
        @if(auth()->check())
            <section id="incluir">
                <form class="formulario" enctype="multipart/form-data" method="POST" action="{{ route('add.task') }}">
                    <h2 class="incuir">Incluir na lista</h2>
                    @csrf
                    <div class="inputBox">
                        <label class="tituloinput">Título</label>
                        <input type="text" name="title" id="title" placeholder="Insira o título da tarefa">
                        <label class="tituloinput">Descrição</label>
                        <input type="text" name="description" id="description" placeholder="Insira a descrição">
                        <button class="btncss1" id="btn_cadastro" type="submit">Cadastrar</button>
                    </div>
                </form>                
            </section>

            <section id="ver">
                <h2>Sua Lista de Tarefa</h2>
                <table class="table table-striped table-dark" style="width:70%;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Título</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Status</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(auth()->user()->tasks as $task)
                        <tr>
                            <th scope="row">{{ $task->id }}</th>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>
                                <div class="input-group">
                                    <select id="dropdown_status_{{ $task->id }}" class="custom-select" onchange="updateSelectedOption({{ $task->id }})">
                                        <option value="Não Iniciado" {{ $task->status == 'Não Iniciado' ? 'selected' : '' }}>Não Iniciado</option>
                                        <option value="Em Andamento" {{ $task->status == 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                                        <option value="Concluído" {{ $task->status == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                                    </select>
                                    
                                    <div class="input-group-append">
                                        <button class="btn btn-info" onclick="saveStatus({{ $task->id }})">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </td>
                            
                            
                            <td>
                                <form method="post" action="{{ route('delete.task', $task->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="border: none;background-color: #001f3f;">Excluir</button>
                                </form>
                            </td>      
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif

    </main>

    <footer>
        <p>Rodapé da Página</p>
    </footer>


    <script>
        function updateSelectedOption(taskId) {
            var dropdownElement = document.getElementById('dropdown_status_' + taskId);
            selectedOption = dropdownElement.value;
    
            localStorage.setItem('selectedOption_' + taskId, selectedOption);
        }
    
        function loadSelectedOption(taskId) {
            var storedOption = localStorage.getItem('selectedOption_' + taskId);
            if (storedOption) {
                var dropdownElement = document.getElementById('dropdown_status_' + taskId);
                dropdownElement.value = storedOption;
                selectedOption = storedOption;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            @foreach($tasks as $task)
                loadSelectedOption({{ $task->id }});
            @endforeach
        });
    </script>
    
    
    
    
    
    
    

    <script>
        function navigateToSection() {
            var selectedOption = document.getElementById("dropdown").value;
            document.querySelector(selectedOption).scrollIntoView({
                behavior: 'smooth'
            });
        }

        function toggleStatus(taskId) {
            var statusElement = document.getElementById('status_' + taskId);
            var currentStatus = statusElement.innerHTML.trim();
            var newStatus = (currentStatus === 'Sim') ? 'Não' : 'Sim';
            statusElement.innerHTML = newStatus;

            $.ajax({
                type: 'POST',
                url: '/update-status/' + taskId,
                data: { status: newStatus },
                success: function(response) {
                    console.log('Status atualizado com sucesso!');
                },
                error: function(error) {
                    console.error('Erro ao atualizar o status.');
                }
            });
        }
    </script>

</body>
</html>
