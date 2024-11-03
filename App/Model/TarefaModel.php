<?php

class TarefaModel {

    public $taskId, $taskName, $taskPrice, $taskDate, $taskOrder;

    public $rows;

    public function save() {

        include_once 'DAO/TarefaDao.php';

        $dao = new TarefaDao($this);

        if ($dao->nameExists($this->taskName)) {
            return false;
        }

        $this->taskOrder = $dao->maxOrder() + 1;
        $dao->insert($this);
        return true; 
    }

    public function getRows() {

        include_once 'DAO/TarefaDao.php';

        $dao = new TarefaDao($this);
        $this->rows = $dao->select();
    }
    
    public function update() {

        include_once 'DAO/TarefaDao.php';
        $dao = new TarefaDao($this);

        if ($dao->nameExists($this->taskName, $this->taskId)) {
            return false;
        }

        $dao->update($this);
        return true;
    }

    public function delete(int $id) {

        include_once 'DAO/TarefaDao.php';
        
        $dao = new TarefaDao($this);
        $dao->delete($id);

        $dao->reorderTasks();
    }

    public function moveUp() {

        include_once 'DAO/TarefaDao.php';
    
        $dao = new TarefaDao();
        $dao->moveUp($this->taskId, $this->taskOrder);
    }
    
    public function moveDown() {

        include_once 'DAO/TarefaDao.php';
    
        $dao = new TarefaDao();
        $dao->moveDown($this->taskId, $this->taskOrder);
    }

    public function updateOrder($newOrder) {
        include_once 'DAO/TarefaDao.php';
        $dao = new TarefaDao();
        $dao->updateOrder($newOrder);
    }
    
}