<?php

class ExamDao {

    private $conn;

    /**
     * constructor of dao class
     */
    public function __construct(){
        try {
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = ""; // default for XAMPP
            $dbname = "final2025"; // adjust to your schema name
            $port = 3306;

            // Create new connection
            $this->conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Get all customers
    public function get_customers(){
        $stmt = $this->conn->prepare("SELECT id, first_name, last_name, birth_date FROM customers");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all meals for a specific customer
    public function get_customer_meals($customer_id) {
        $stmt = $this->conn->prepare(
            "SELECT foods.name AS food_name, foods.brand AS food_brand, meals.created_at AS meal_date
             FROM meals
             JOIN foods ON meals.food_id = foods.id
             WHERE meals.customer_id = :customer_id"
        );
        $stmt->execute(['customer_id' => $customer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a customer to the database
    public function add_customer($data){
        $stmt = $this->conn->prepare(
            "INSERT INTO customers (first_name, last_name, birth_date) VALUES (:first_name, :last_name, :birth_date)"
        );
        $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birth_date' => $data['birth_date']
        ]);
        // Return the newly added customer
        $id = $this->conn->lastInsertId();
        $stmt = $this->conn->prepare("SELECT id, first_name, last_name, birth_date FROM customers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get foods report (paginated)
    public function get_foods_report($offset = 0, $limit = 10){
        $stmt = $this->conn->prepare(
            "SELECT 
                foods.id,
                foods.name,
                foods.brand,
                foods.image,
                foods.energy,
                foods.protein,
                foods.fat,
                foods.fiber,
                foods.carbs
            FROM foods
            LIMIT :offset, :limit"
        );
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total count of foods (for pagination)
    public function get_foods_count() {
        $stmt = $this->conn->query("SELECT COUNT(*) as cnt FROM foods");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['cnt'] : 0;
    }
}
?>
