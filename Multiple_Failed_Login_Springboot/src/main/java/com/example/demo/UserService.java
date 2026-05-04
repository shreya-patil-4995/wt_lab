package com.example.demo;

import java.util.HashMap;
import java.util.Map;

public class UserService {

    private Map<String, User> users = new HashMap<>();

    public UserService() {
        User user = new User();
        user.setUsername("admin");
        user.setPassword("123");
        user.setFailedAttempts(0);
        user.setLocked(false);

        users.put("admin", user);
    }

    public String login(String username, String password) {

        User user = users.get(username);

        if (user == null) {
            return "User not found";
        }

        // check if locked
        if (user.isLocked()) {
            long unlockTime = user.getLockTime() + (1 * 60 * 1000); // 1 min

            if (System.currentTimeMillis() > unlockTime) {
                user.setLocked(false);
                user.setFailedAttempts(0);
            } else {
                return "Account locked. Try after some time.";
            }
        }

        // check password
        if (user.getPassword().equals(password)) {
            user.setFailedAttempts(0);
            return "Login successful";
        } else {
            user.setFailedAttempts(user.getFailedAttempts() + 1);

            if (user.getFailedAttempts() >= 3) {
                user.setLocked(true);
                user.setLockTime(System.currentTimeMillis());
                return "Account locked due to 3 failed attempts";
            }

            return "Invalid credentials";
        }
    }
}