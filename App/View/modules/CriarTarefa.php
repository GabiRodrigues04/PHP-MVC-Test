<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/css/createTaskStyle.css">
    <title>Criar Tarefa</title>
</head>
<body>
    
    <main class="main"> 

        <div class="title">
            <h1>Adicione uma tarefa</h1>
        </div>

        <div class="formContainer">

             <form class="taskForm" method="post" action="/listadetarefas/App/create/save">
                <label for ="taskName"> Tarefa </label>
                    <input type ="text" id="taskName" name="taskName" placeholder="Nome da Tarefa" required>
                <label for ="taskPrice"> Preço </label>
                    <input type ="number" id="taskPrice" name="taskPrice" placeholder="Preço da Tarefa">
                <label for ="taskDate"> Data limite </label>
                    <input type ="date" id="taskDate" name="taskDate">
                        
                <div class=buttons>
                    <button type="submit"> Incluir tarefa </button>
                    <a href="/listadetarefas/App">Voltar</a>
                 </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class ="alertError">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

            </form>
        </div>

    </main>
</body>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('taskDate').value = today; 
});

</script>
            
</html>