package com.example.ProdInventory.repository;

import com.example.ProdInventory.model.Product;
import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.stereotype.Repository;

// Task 3: MongoRepository interface for Product document
@Repository
public interface ProductRepository extends MongoRepository<Product, String> {
    // MongoRepository provides built-in CRUD methods:
    // save(), findById(), findAll(), deleteById(), existsById()
}
