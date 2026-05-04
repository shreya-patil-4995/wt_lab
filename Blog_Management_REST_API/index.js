const express = require("express");
const app = express();

app.use(express.json());
app.use(express.static(__dirname));
let blogs = [];
let id = 1;

// CREATE BLOG
app.post("/blogs", (req, res) => {
    const { title, content } = req.body;

    if (!title || !content) {
        return res.json({ message: "Title and content required" });
    }

    const blog = {
        id: id,
        title: title,
        content: content
    };

    id++;
    blogs.push(blog);

    res.json(blog);
});

// GET ALL BLOGS
app.get("/blogs", (req, res) => {
    res.json(blogs);
});

// GET SINGLE BLOG
app.get("/blogs/:id", (req, res) => {
    const blogId = parseInt(req.params.id);

    const blog = blogs.find(b => b.id === blogId);

    if (!blog) {
        return res.json({ message: "Blog not found" });
    }

    res.json(blog);
});

// UPDATE BLOG
app.put("/blogs/:id", (req, res) => {
    const blogId = parseInt(req.params.id);
    const { title, content } = req.body;

    for (let i = 0; i < blogs.length; i++) {
        if (blogs[i].id === blogId) {
            blogs[i].title = title || blogs[i].title;
            blogs[i].content = content || blogs[i].content;
            return res.json(blogs[i]);
        }
    }

    res.json({ message: "Blog not found" });
});

// DELETE BLOG
app.delete("/blogs/:id", (req, res) => {
    const blogId = parseInt(req.params.id);

    blogs = blogs.filter(b => b.id !== blogId);

    res.json({ message: "Blog deleted" });
});

// SERVER
app.listen(3000, () => {
    console.log("Server running on port 3000");
});