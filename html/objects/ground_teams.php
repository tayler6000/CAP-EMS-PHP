<?php
    class GroundTeam {
        public int $sortie;
        public string $name;
        public string $cov;
        public string $driver;
        public string $leader;
        public int $passengers;
        public string $status;
        public string $location;
        public int $checkin;
        public function __construct(int $id){
            $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
            $stmt = $conn->prepare("SELECT * FROM `deployed_ground` WHERE `sortie`=?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $row = mysqli_fetch_assoc($result);
            $this->sortie = $row["sortie"];
            $this->name = $row["name"];
            $this->cov = $row["cov"];
            $this->driver = $row["driver"];
            $this->leader = $row["leader"];
            $this->passengers = $row["passengers"];
            $this->status = $row["status"];
            $this->location = $row["location"];
            $this->checkin = $ow["checkin"];
        }
    }
?>