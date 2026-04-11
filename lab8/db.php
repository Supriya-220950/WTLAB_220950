<?php
// SmartCare Lab 8: MongoDB Authentication DB Logic
class MongoDBAuth {
    private $simulate = false;

    public function __construct() {
        if (!class_exists('MongoDB\Driver\Manager')) {
            $this->simulate = true; // Fallback if extension not loaded
        }
    }

    public function authenticate($email, $password) {
        if ($this->simulate) {
            if ($email === 'doctor@smartcare.com' && $password === 'password123') {
                return ['success' => true, 'user' => ['name' => 'Dr. John Doe', 'role' => 'Cardiologist']];
            }
            return ['success' => false, 'error' => 'Invalid credentials. Use doctor@smartcare.com / password123'];
        }

        try {
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query(['email' => $email, 'password' => $password]);
            $cursor = $manager->executeQuery('smartcare.users', $query);
            $user = current($cursor->toArray());

            if ($user) {
                return ['success' => true, 'user' => ['name' => $user->name, 'role' => $user->role]];
            }
            return ['success' => false, 'error' => 'Invalid credentials'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'MongoDB Error: ' . $e->getMessage()];
        }
    }
}
?>
