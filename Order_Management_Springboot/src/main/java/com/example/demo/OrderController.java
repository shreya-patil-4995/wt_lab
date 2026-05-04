package com.example.demo;

import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@CrossOrigin
public class OrderController {

    private final OrderRepository repo;

    public OrderController(OrderRepository repo) {
        this.repo = repo;
    }

    @PostMapping("/orders")
    public Order create(@RequestBody Order order) {
        return repo.save(order);
    }

    @GetMapping("/orders")
    public List<Order> getAll() {
        return repo.findAll();
    }

    @PutMapping("/orders/{id}")
    public Order update(@PathVariable Long id, @RequestBody Order newOrder) {
        Order o = repo.findById(id).orElseThrow();
        o.setProduct(newOrder.getProduct());
        o.setQuantity(newOrder.getQuantity());
        o.setPrice(newOrder.getPrice());
        return repo.save(o);
    }

    @DeleteMapping("/orders/{id}")
    public String delete(@PathVariable Long id) {
        repo.deleteById(id);
        return "Deleted";
    }
}