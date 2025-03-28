<?php
class Item {
    private $conn;
    private $table_name = "items";

    public $id;
    public $title;
    public $description;
    public $starting_price;
    public $current_price;
    public $end_time;
    public $seller_id;
    public $highest_bidder_id;
    public $status;
    public $image_url;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    title = :title,
                    description = :description,
                    starting_price = :starting_price,
                    current_price = :starting_price,
                    end_time = :end_time,
                    seller_id = :seller_id,
                    image_url = :image_url";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->starting_price = htmlspecialchars(strip_tags($this->starting_price));
        $this->end_time = htmlspecialchars(strip_tags($this->end_time));
        $this->seller_id = htmlspecialchars(strip_tags($this->seller_id));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":starting_price", $this->starting_price);
        $stmt->bindParam(":end_time", $this->end_time);
        $stmt->bindParam(":seller_id", $this->seller_id);
        $stmt->bindParam(":image_url", $this->image_url);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT i.*, u.name as seller_name, h.name as highest_bidder_name
                FROM " . $this->table_name . " i
                LEFT JOIN users u ON i.seller_id = u.id
                LEFT JOIN users h ON i.highest_bidder_id = h.id
                WHERE i.status = 'active'
                ORDER BY i.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT i.*, u.name as seller_name, h.name as highest_bidder_name
                FROM " . $this->table_name . " i
                LEFT JOIN users u ON i.seller_id = u.id
                LEFT JOIN users h ON i.highest_bidder_id = h.id
                WHERE i.id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->starting_price = $row['starting_price'];
        $this->current_price = $row['current_price'];
        $this->end_time = $row['end_time'];
        $this->seller_id = $row['seller_id'];
        $this->highest_bidder_id = $row['highest_bidder_id'];
        $this->status = $row['status'];
        $this->image_url = $row['image_url'];
        $this->seller_name = $row['seller_name'];
        $this->highest_bidder_name = $row['highest_bidder_name'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    current_price = :current_price,
                    highest_bidder_id = :highest_bidder_id
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":current_price", $this->current_price);
        $stmt->bindParam(":highest_bidder_id", $this->highest_bidder_id);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?> 