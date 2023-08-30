<?php
class UserManagement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addUser($username, $email, $role) {
        $username = $this->db->escapeString($username);
        $email = $this->db->escapeString($email);
        $role = $this->db->escapeString($role);

        $sql = "INSERT INTO users (username, email, role) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $role);
            $result = $stmt->execute();

            if ($result) {
                $stmt->close();
                return true; 
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $this->db->error;
        }

        return false; // Error occurred
    }

    public function getUserById($id) {
        $id = $this->db->escapeString($id);

        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            echo "Error: " . $this->db->error;
            return null;
        }
    }

    public function updateUser($id, $username, $email, $role) {
        $id = $this->db->escapeString($id);
        $username = $this->db->escapeString($username);
        $email = $this->db->escapeString($email);
        $role = $this->db->escapeString($role);

        $sql = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssi", $username, $email, $role, $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->db->error;
            return false;
        }
    }

    public function deleteUser($id) {
        $id = $this->db->escapeString($id);

        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            echo "Error: " . $this->db->error;
            return false;
        }
    }
}
?>