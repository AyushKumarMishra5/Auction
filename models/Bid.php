<?php
class Bid {
    private $conn;
    private $table_name = "bids";

    public $id;
    public $item_id;
    public $bidder_id;
    public $amount;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    item_id = :item_id,
                    bidder_id = :bidder_id,
                    amount = :amount";

        $stmt = $this->conn->prepare($query);

        $this->item_id = htmlspecialchars(strip_tags($this->item_id));
        $this->bidder_id = htmlspecialchars(strip_tags($this->bidder_id));
        $this->amount = htmlspecialchars(strip_tags($this->amount));

        $stmt->bindParam(":item_id", $this->item_id);
        $stmt->bindParam(":bidder_id", $this->bidder_id);
        $stmt->bindParam(":amount", $this->amount);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readByItem() {
        $query = "SELECT b.*, u.name as bidder_name
                FROM " . $this->table_name . " b
                LEFT JOIN users u ON b.bidder_id = u.id
                WHERE b.item_id = ?
                ORDER BY b.amount DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->item_id);
        $stmt->execute();

        return $stmt;
    }
}
?> 