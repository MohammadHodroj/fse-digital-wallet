<?php 
require_once __DIR__ . '/../connection/database.php';

class User{
    private $db;

    public function __construct()
    {
        $this->db = (new Database()) ->getConnection();
    }

    public function create($email, $phone, $password, $role = 'user'){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (email, phone, password_hash, role)
        VALUES (:email, :phone, :password, :role)
        ");
        return $stmt->execute([
            ':email' => $email,
            ':phone' => $phone,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);
    }

    public function findByOrPhone($login){
        $stmt = $this->db->prepare("
            SELECT * FROM users
            WHERE email = :login OR phone = :login
        ");
        $stmt->execute([':login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $data){
        $stmt = $this->db->prepare("
            UPDATE users
            SET full_name = :full_name, address = :address, phone = :phone
            WHERE id = :id
        ");

        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':address' => $data['address'],
            ':phone' => $data['phone'],
            ':id' => $userId
        ]);
    }

    public function delete($userId){
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $userId]);
    }

    public function getAll(){
        $stmt = $this->db->prepare("SELECT id, email, phone, role, created_at FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>