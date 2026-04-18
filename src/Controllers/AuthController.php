<?php
namespace Controllers;

use Models\User;
use Repositories\UserRepository;

class AuthController {
    private $userRepo;

    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function register($data) {
        // Validate
        if (empty($data['email']) || empty($data['password']) || empty($data['name']) || empty($data['role'])) {
            return "All fields are required.";
        }

        // Check if email exists
        if ($this->userRepo->findByEmail($data['email'])) {
            return "Email already registered.";
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Create user object
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
            'role' => $data['role']
        ]);

        $userId = $this->userRepo->create($user);
        if ($userId) {
            return true;
        }
        return "Registration failed.";
    }

    public function login($email, $password) {
        $userData = $this->userRepo->findByEmail($email);
        
        if ($userData && password_verify($password, $userData->password)) {
            // Start session and store user data
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $userData->id;
            $_SESSION['user_name'] = $userData->name;
            $_SESSION['user_role'] = $userData->role;
            return true;
        }
        return "Invalid email or password.";
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: login");
        exit();
    }
}
