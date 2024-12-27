<?php
class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;

    public function __construct($host, $user, $pass, $dbname) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;

        // Membuat koneksi
        $this->conn = new mysqli($host, $user, $pass, $dbname);

        // Mengecek koneksi
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    // Metode untuk menjalankan query
    public function query($sql) {
        return $this->conn->query($sql);
    }

    // Metode untuk menutup koneksi
    public function close() {
        $this->conn->close();
    }
}
?>
