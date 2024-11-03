<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    
    <div class="header">
        <div class="title">
            <h1>Lista de Tarefas</h1>
        </div>
    </div>

    <main class="main"> 
        <ul class="taskList"> 
        <?php foreach($model->rows as $task): ?>

        <?php  
            $date = DateTime::createFromFormat('Y-m-d', $task->taskDate)->format('d/m/Y'); 
        ?>

        <li class="<?= $task->taskPrice >= 1000 ? 'overBudget task' : 'task' ?>"
        draggable="true"
        data-id="<?= $task->taskId ?>"
        data-order="<?= $task->taskOrder ?>">

            <div class="taskCard">
                <div class="btnsOrder">

                    <?php if ($task->taskOrder > 1): ?>
                        <a href="/listadetarefas/App/moveup?id=<?= $task->taskId ?>&order=<?= $task->taskOrder ?>" class="btnsOrder">
                            <i class="bi bi-arrow-up"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($task->taskOrder < count($model->rows)): ?>
                        <a href="/listadetarefas/App/movedown?id=<?= $task->taskId ?>&order=<?= $task->taskOrder ?>" class="btnsOrder">
                            <i class="bi bi-arrow-down"></i>
                        </a>
                    <?php endif; ?>

                </div>  

                <div class="taskContent">
                    <div class="taskHeader">
                        <h1 class ="number">#<?= $task->taskId ?></h1>
                        <h1><?= $task->taskName ?></h1> 
                        <h1><?= $task->taskOrder ?> </h1>
                    </div>
                    <div class="taskInfo">
                        <h2 class="number">Atividade para a data <?= $date ?></h2>
                        <h3 class="number" <?= $task->taskPrice >= 1000 ? "style= color:#d13e3e" : "" ?>   >R$ <?= $task->taskPrice ?></h3>
                    </div>
                </div>
                
                <div class="btnsAction">
                    <a href="/listadetarefas/App/delete?id=<?= $task->taskId ?>" onclick="confirmarExclusao(event)" class="btnDel"><i class="bi bi-trash"></i></a>
                    <button type="button" class="btnEdit" 
                        data-id="<?= $task->taskId ?>" 
                        data-task-name="<?= htmlspecialchars($task->taskName) ?>" 
                        data-task-price="<?= $task->taskPrice ?>" 
                        data-task-date="<?= $task->taskDate ?>">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                </div>
            </div>
        </li>
        <?php endforeach ?>
        </ul>

    </main>

    <a href="/listadetarefas/App/create" class="createBtn"><i class="bi bi-plus-square-fill"></i></a>

    <dialog class="modalDialog" id="modalDialog">
        <div class="modalEdit">
        <div class="modalHeader">
            <h1>Editar Tarefa</h1>
            <button class="closeModal"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modalBody">

        <form id="editForm" method="post" action="/listadetarefas/App/update?id=">
            <input type="hidden" id="taskId" name="taskId">
            <label for="taskName">Tarefa</label>
            <input type="text" id="taskName" name="taskName" placeholder="Nome da Tarefa">
            
            <label for="taskPrice">Preço</label>
            <input type="number" id="taskPrice" name="taskPrice" placeholder="Preço da Tarefa">
            
            <label for="taskDate">Data limite</label>
            <input type="date" id="taskDate" name="taskDate">
            
            <button type="submit">Editar</button>

            <?php if (isset($_SESSION['error'])): ?>
                        <div class ="alertError">
                            <?php echo $_SESSION['error']; ?>
                        </div>
                    <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
        </form>
        </div>
        </div>
    </dialog>

</body>


<script>

    document.addEventListener("DOMContentLoaded", function() {
        <?php if (isset($_SESSION['modalOpen']) && $_SESSION['modalOpen'] === true): ?>
            document.getElementById('modalDialog').showModal();
            <?php unset($_SESSION['modalOpen']); ?>
        <?php endif; ?>
    });

</script>

</html>