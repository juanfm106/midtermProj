<?php
    class Post {
        private $conn;
        private $table = 'quotes';

        public $id;
        public $categoryId;
        public $category;
        public $quote;
        public $authorId;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function read()
        {
            $query = 'SELECT c.quotes as quote, 
            p.id,
            p.categoryId,
            p.category,
            p.quote,
            p.authorId
        FROM
            ' . $this->table . ' p
        LEFT JOIN
            categories c ON p.category_id = c.id
        ORDER BY
            p.created_at DESC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
        }

        public function read_single(
            {
                $query = 'SELECT c.quotes as quote, 
            p.id,
            p.categoryId,
            p.category,
            p.quote,
            p.authorId
        FROM
            ' . $this->table . ' p
        LEFT JOIN
            categories c ON p.category_id = c.id
        WHERE
            p.id = ?
        LIMIT 0,1';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category = $row['category'];

            }
        

        public function create()
        {
            $query = 'INSERT INTO ' . $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';
            
            $stmt = $this->conn->prepare($query);

            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            if($stmt->execute())
            {
                return true;
            }
            printf("Errot: %s.\n", $stmt->error);
            return false;
        }
        )
    }