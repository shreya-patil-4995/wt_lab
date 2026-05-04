package com.example.bookstore.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import com.example.bookstore.entity.User;

public interface UserRepository extends JpaRepository<User, Long> {
    User findByUsername(String username);
}