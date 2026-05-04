package com.example.demo;

import org.springframework.security.crypto.password.PasswordEncoder;
import java.util.HashMap;
import java.util.Map;

public class UserService {

    private Map<String, User> users = new HashMap<>();
    private PasswordEncoder encoder = new SecurityConfig().passwordEncoder();

    public String register(String username, String password) {

        User user = new User();
        user.setUsername(username);

        String encrypted = encoder.encode(password);
        user.setPassword(encrypted);

        users.put(username, user);

        return "User registered";
    }

    public String login(String username, String password) {

        User user = users.get(username);

        if (user == null) {
            return "User not found";
        }

        if (encoder.matches(password, user.getPassword())) {
            return "Login successful";
        } else {
            return "Invalid password";
        }
    }
}