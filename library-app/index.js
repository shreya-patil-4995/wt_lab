const express = require("express");
const mongoose = require("mongoose");
const app = express();

app.use(express.json());
app.use(express.static(__dirname));

// CONNECT DATABASE
mongoose.connect("mongodb://127.0.0.1:27017/library");

// SCHEMA
const bookSchema = new mongoose.Schema({
    book_id: Number,
    title: String,
    author: String,
    year: Number
});

const Book = mongoose.model("Book", bookSchema);

// ADD BOOK
app.post("/books", async(req, res) => {
    const book = new Book(req.body);
    await book.save();
    res.json(book);
});

// GET ALL BOOKS
app.get("/books", async(req, res) => {
    const books = await Book.find();
    res.json(books);
});

// SERVER
app.listen(3000, () => {
    console.log("Server running on port 3000");
});