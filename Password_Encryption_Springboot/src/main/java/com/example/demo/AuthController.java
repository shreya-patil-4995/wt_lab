package com.example.demo;

import org.springframework.web.bind.annotation.*;

@RestController
public class AuthController {

    private UserService userService = new UserService();

    @GetMapping("/register")
    public String register(@RequestParam String username, @RequestParam String password) {
        return userService.register(username, password);
    }

    @GetMapping("/login")
    public String login(@RequestParam String username, @RequestParam String password) {
        return userService.login(username, password);
    }
}