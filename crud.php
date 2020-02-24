<?php

    require_once 'config.php';
    require_once 'tools.php';

    class Crud {
        
        use Product;
        use Payment;
        use DataBase;

        function __construct() {
            try {
                $this->conn = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass);
            } catch (Exception $e) {
                general_error();
            }
        }

        public function is_admin($email, $password) : bool
        {

            $sql = "SELECT * FROM `admin` WHERE email = ? LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $email);

            if ($stmt->execute())
            {
                if ($user = $stmt->fetch(PDO::FETCH_OBJ)) 
                {
                    return password_verify($password , $user->password);
                } 

                return false;
            }

            return false;
        }

        public function get_admin() : object
        {
            return $this->conn->query("SELECT * FROM `admin` LIMIT 1")->fetch(PDO::FETCH_OBJ);
        }

        public function has_user($email) : bool 
        {
            $stmt = $this->conn->prepare("SELECT * FROM `clients` WHERE email=? LIMIT 1");
            $stmt->bindParam(1, $email);

            $stmt->execute();
            return ($stmt->fetch()) ? true: false ;
        }

        public function register($name, $password, $email, $phone, $address, $token) : bool
        {
            $stmt = $this->conn->prepare("INSERT INTO `clients` VALUES (null, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $address);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, password_hash($password, PASSWORD_DEFAULT));
            $stmt->bindParam(5, $phone);
            $stmt->bindParam(6, $token);

            return $stmt->execute();
        }

        public function is_user($email, $password)
        {
            $sql = "SELECT * FROM `clients` WHERE email = ? LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $email);

            if ($stmt->execute())
            {
                if ($user = $stmt->fetch(PDO::FETCH_OBJ)) 
                {
                    return password_verify($password , $user->password) ? $user->token : false;
                } 
            }

            return false;
        }

        public function get_client_by_token(string $token)
        {

            $sql = "SELECT * FROM `clients` WHERE token=? LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $token);

            if ($stmt->execute())
            {
                if ($user = $stmt->fetch(PDO::FETCH_OBJ)) 
                {
                    return $user;
                } 

                return false;
            }

            return false;
        }

        public function update_client_by_token(string $token, array $columns)
        {
            foreach($columns as $column => $value)
            {
                $sql = "UPDATE clients SET $column='{$value}' WHERE token='{$token}'";

                $lastResult = $this->conn->query($sql);
            }

            return $lastResult;
        }

        public function all_users()
        {
            return $this->conn->query("SELECT * FROM `clients`")->fetchAll(PDO::FETCH_OBJ);
        }

    }

    trait Product {
        public function add_product($name, $price, $price_owner, $description)
        {
            $sql = "INSERT INTO `products` VALUES (null, ?,?,?,?)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(1,$name);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $price_owner);
            $stmt->bindParam(4, $description);

            return $stmt->execute();
        }

        public function delete_product_by_id($id)
        {
            return $this->conn->query("DELETE FROM `products` WHERE id='$id'");
        }

        public function all_product()
        {
            return $this->conn->query("SELECT * FROM `products`")->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_product_by_id($id)
        {
            return $this->conn->query("SELECT * FROM `products` WHERE id='$id'")->fetch(PDO::FETCH_OBJ);
        }

    } 

    trait Payment {
        public function pay($cliente_token, $product_id)
        {

            $product = $this->get_product_by_id($product_id);
            $user = $this->get_client_by_token($cliente_token);

            $base = $product->price - $product->price_owner;

            $stmt = $this->conn->prepare('INSERT INTO `payment` VALUES (null, ?,?,?,?)');

            $stmt->bindParam(1, $user->id);
            $stmt->bindParam(2, $product->price);
            $stmt->bindParam(3, $product->price_owner);
            $stmt->bindParam(4, $base);

            return $stmt->execute();
        }

        public function sum_payment()
        {
        
            return $this->conn->query("SELECT sum(`price`) as p, sum(`base`) as b FROM `payment`")->fetch(PDO::FETCH_OBJ);

        }
    }