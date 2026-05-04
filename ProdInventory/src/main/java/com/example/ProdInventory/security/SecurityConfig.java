package com.example.ProdInventory.security;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.web.SecurityFilterChain;

// Task 4 & 5: Spring Security - Basic Authentication
@Configuration
@EnableWebSecurity
public class SecurityConfig {

    @Bean
    public SecurityFilterChain securityFilterChain(HttpSecurity http) throws Exception {
        http
            .csrf(csrf -> csrf.disable())  // Disable CSRF for Postman testing
            .authorizeHttpRequests(auth -> auth
                .anyRequest().authenticated()  // All endpoints require authentication
            )
            .httpBasic(httpBasic -> {});  // Enable HTTP Basic Authentication

        return http.build();
    }
}
