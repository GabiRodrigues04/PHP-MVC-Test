document.addEventListener("DOMContentLoaded", () => {
    const buttonsOpenModal = document.querySelectorAll(".btnEdit");
    const modal = document.querySelector("#modalDialog");
    const closeModal = document.querySelector(".closeModal");
    const editForm = document.querySelector("#editForm");
    const taskList = document.querySelector(".taskList");
    
    buttonsOpenModal.forEach(button => {
        button.addEventListener("click", () => openModal(button));
    });

    closeModal.addEventListener("click", closeModalAndReload);

    taskList.addEventListener("dragstart", handleDragStart);
    taskList.addEventListener("dragover", handleDragOver);
    taskList.addEventListener("drop", handleDrop);

    function openModal(button) {
        const taskId = button.getAttribute("data-id");
        const taskName = button.getAttribute("data-task-name");
        const taskPrice = button.getAttribute("data-task-price");
        const taskDate = button.getAttribute("data-task-date");

        editForm.action = `/listadetarefas/App/update?id=${taskId}`;
        document.getElementById('taskId').value = taskId;
        document.getElementById('taskName').value = taskName;
        document.getElementById('taskPrice').value = taskPrice;
        document.getElementById('taskDate').value = taskDate;

        modal.showModal();
    }

    function closeModalAndReload() {
        window.location.reload();
    }

    let draggedItem = null;

    function handleDragStart(e) {
        if (e.target.tagName === "LI") {
            draggedItem = e.target;
            e.dataTransfer.effectAllowed = "move";
        }
    }

    function handleDragOver(e) {
        e.preventDefault();
        const target = e.target.closest("li");
        if (target && target !== draggedItem) {
            const bounding = target.getBoundingClientRect();
            const offset = e.clientY - bounding.top;
            if (offset > bounding.height / 2) {
                target.after(draggedItem);
            } else {
                target.before(draggedItem);
            }
        }
    }

    function handleDrop() {
        const items = [...taskList.querySelectorAll("li")];
        const newOrder = items.map((item, index) => ({
            id: item.getAttribute("data-id"),
            order: index + 1,
        }));

        fetch("/listadetarefas/App/updateOrder", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(newOrder),
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                console.log("Ordem das tarefas atualizada com sucesso.");
                window.location.reload();
            } else {
                console.error("Erro ao atualizar a ordem das tarefas.");
            }
        });
    }
});
