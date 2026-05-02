<?php

 class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }
    public function register($surname , $email , $passwrd ) : bool {
        try {
            $query = "INSERT INTO " . $this->table_name . " (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $stmt = $this->conn->prepare($query);

            $hashedPassword = password_hash($passwrd, PASSWORD_BCRYPT);
            $defaultRole = 'user';
            
            $stmt->bindParam(':username', $surname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $defaultRole);

            $result = $stmt->execute();
            
            if ($result) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Registration execute failed: " . print_r($errorInfo, true));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Registration PDO error: " . $e->getMessage());
            throw $e; 
        }
    }

    public function login($email, $passwrd) : bool {
        $query = "SELECT id, username, email, dateofbirth, password, role FROM {$this->table_name} WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($passwrd, $row['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = isset($row['role']) ? $row['role'] : 'user';
                return true;
            }
        }
        return false;
    }

    public function getAllUsers(): array {
        $query = "SELECT id, username, email, dateofbirth, role FROM {$this->table_name} ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setUserRole($userId, $role): bool {
        $allowed = ['user', 'admin'];
        if (!in_array($role, $allowed)) return false;
        $query = "UPDATE {$this->table_name} SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
 }
?>