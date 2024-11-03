<?php

class TarefaController {

    public static function index() {

        include 'Model/TarefaModel.php';

        $model = new TarefaModel();
        $model->getRows();

        include 'View/modules/ListarTarefa.php';
    }

    public static function tasks() {

        include 'Model/TarefaModel.php';
      
        include 'View/modules/CriarTarefa.php';
    }
    
    public static function save() {

        include 'Model/TarefaModel.php';
        
        $model = new TarefaModel();

        $model-> taskName = $_POST['taskName'];
        $model-> taskPrice = $_POST['taskPrice'];
        $model-> taskDate = $_POST['taskDate'];
        $model-> taskOrder = 12;

        if ($model->save()) {
            header("Location: /listadetarefas/App/");
        } else {
            $_SESSION['error'] = "Já existe uma tarefa com este nome.";
            header("Location: /listadetarefas/App/create");
        }
    }

    public static function delete() {

        include 'Model/TarefaModel.php';

        $model = new TarefaModel();
        $model->delete((int) $_GET['id']);

        header("Location: /listadetarefas/App/");
    }

    public static function update() {

        include 'Model/TarefaModel.php';
        
        $model = new TarefaModel();
        $model->taskId = (int) $_GET['id'];
        $model->taskName = $_POST['taskName'];
        $model->taskPrice = $_POST['taskPrice'];
        $model->taskDate = $_POST['taskDate'];
    
        if ($model->update()) {
            header("Location: /listadetarefas/App/");
            exit;
        } else {
            $_SESSION['error'] = "Já existe uma tarefa com este nome.";
            $_SESSION['modalOpen'] = true;
            header("Location: /listadetarefas/App/");
            exit;
        }
    }
    
    public static function moveUp() {
       
        include 'Model/TarefaModel.php';
        
        $model = new TarefaModel();
        $model->taskId = (int) $_GET['id'];
        $model->taskOrder = (int) $_GET['order'];

        $model->moveUp();
        header("Location: /listadetarefas/App/");
    }

    public static function moveDown() {

        include 'Model/TarefaModel.php';
        
        $model = new TarefaModel();
        $model->taskId = (int) $_GET['id'];
        $model->taskOrder = (int) $_GET['order'];

        $model->moveDown();
        header("Location: /listadetarefas/App/");
    }
    
    public static function updateOrder() {
        
        include 'Model/TarefaModel.php';
        $model = new TarefaModel();
    
        $newOrder = json_decode(file_get_contents("php://input"), true);
        $model->updateOrder($newOrder);
    
        header("Location: /listadetarefas/App/");
        exit;
    }
    
}