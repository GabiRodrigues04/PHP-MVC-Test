<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
session_start();

include 'Controller/TarefaController.php';

$route = str_replace('listadetarefas/App/', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

switch($route)
{
    case '/':
        TarefaController::index();
        break;

    case '/create':
        TarefaController::tasks();
        break;
    
    case '/create/save':
        TarefaController::save();
        break;

    case '/delete':
        TarefaController::delete();
        break;

    case '/update':
        TarefaController::update();
        break;

    case '/moveup':
        TarefaController::moveUp();
        break;
        
    case '/movedown':
        TarefaController::moveDown();
        break;

    case '/updateOrder':
        TarefaController::updateOrder();
        break;
        
    default:
        echo "Error 404";
        break; 
}
?>

<script src="Assets/js/script.js"></script>