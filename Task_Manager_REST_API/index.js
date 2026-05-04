const express = require("express");
const app = express();

app.use(express.json());
app.use(express.static(__dirname));

let tasks = [];
let id = 1;

// ADD TASK
app.post("/tasks", (req, res) => {
    const title = req.body.title;

    if (!title) {
        return res.json({ message: "Title is required" });
    }

    const task = {
        id: id,
        title: title,
        status: "pending"
    };

    id = id + 1;
    tasks.push(task);

    res.json(task);
});

// GET TASKS
app.get("/tasks", (req, res) => {
    res.json(tasks);
});

// UPDATE TASK
app.put("/tasks/:id", (req, res) => {
    const taskId = parseInt(req.params.id);

    if (!req.body.status) {
        return res.json({ message: "Status is required" });
    }

    for (let i = 0; i < tasks.length; i++) {
        if (tasks[i].id === taskId) {
            tasks[i].status = req.body.status;
            return res.json(tasks[i]);
        }
    }

    res.json({ message: "Task not found" });
});

// DELETE TASK
app.delete("/tasks/:id", (req, res) => {
    const taskId = parseInt(req.params.id);

    tasks = tasks.filter(task => task.id !== taskId);

    res.json({ message: "Task deleted" });
});

// SERVER
app.listen(3000, () => {
    console.log("Server running on port 3000");
});