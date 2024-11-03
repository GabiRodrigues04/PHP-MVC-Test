<?php

class TarefaDao
{
    private $conn;

    public function __construct() {

        try {
            $this->conn = new PDO("mysql:host=localhost:3307;dbname=lista de tarefas", "root", "");
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    }

    public function insert(TarefaModel $model) {

        $sql = "INSERT INTO tarefas (taskName, taskPrice, taskDate, taskOrder) VALUES (?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(1, $model->taskName);
        $stmt->bindValue(2, $model->taskPrice);
        $stmt->bindValue(3, $model->taskDate);
        $stmt->bindValue(4, $model->taskOrder);
        $stmt->execute();
    }

    public function update(TarefaModel $model) {

        $sql = "UPDATE tarefas SET taskName=?, taskPrice=?, taskDate=? WHERE taskID=?";
    
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(1, $model->taskName);
        $stmt->bindValue(2, $model->taskPrice);
        $stmt->bindValue(3, $model->taskDate);
        $stmt->bindValue(4, $model->taskId);
        $stmt->execute();
    }
    
    public function delete(int $id) {

        $sql = "DELETE FROM tarefas WHERE taskId = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
    
    public function select(){

        $sql = "SELECT * FROM tarefas ORDER BY taskOrder";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function maxOrder() {

        $sql = "SELECT MAX(taskOrder) AS maxOrder FROM tarefas";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result ? $result->maxOrder : 0;
    }

    public function moveUp($taskId, $taskOrder) {

        $sql = "UPDATE tarefas SET taskOrder = taskOrder + 1 WHERE taskOrder = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $taskOrder - 1);
        $stmt->execute();
    
        $sql = "UPDATE tarefas SET taskOrder = taskOrder - 1 WHERE taskId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $taskId);
        $stmt->execute();
    }

    public function moveDown($taskId, $taskOrder) {

        $sql = "UPDATE tarefas SET taskOrder = taskOrder - 1 WHERE taskOrder = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $taskOrder + 1);
        $stmt->execute();
    
        $sql = "UPDATE tarefas SET taskOrder = taskOrder + 1 WHERE taskId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $taskId);
        $stmt->execute();
    }

    public function reorderTasks() {

        $sql = "SET @order = 0; UPDATE tarefas SET taskOrder = (@order := @order + 1) ORDER BY taskOrder";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }

    public function nameExists($taskName, $taskId = null) {
        $sql = "SELECT COUNT(*) as count FROM tarefas WHERE taskName = ?";
    
        if ($taskId !== null) {
            $sql .= " AND taskId != ?";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $taskName);
        
        if ($taskId !== null) {
            $stmt->bindValue(2, $taskId);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $result->count > 0;
    }

    public function getOrderById($taskId) {

        $sql = "SELECT taskOrder FROM tarefas WHERE taskId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $taskId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function updateOrder($newOrder) {

        $this->conn->beginTransaction();
    
        try {
            foreach ($newOrder as $task) {
                $sql = "UPDATE tarefas SET taskOrder = :order WHERE taskId = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':order', $task['order']);
                $stmt->bindParam(':id', $task['id']);
                $stmt->execute();
            }
    
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    
}