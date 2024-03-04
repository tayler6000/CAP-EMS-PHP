<?php
    class GroundTeam {
        public int $id;
        public string $mission;
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
            $stmt = $conn->prepare("SELECT * FROM `deployed_ground` WHERE `id`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result === False){
                print($conn->error);
            }
            $row = mysqli_fetch_assoc($result);
            $this->id = $row["id"];
            $this->mission = $row["mission"];
            $this->sortie = $row["sortie"];
            $this->name = $row["name"];
            $this->cov = $row["cov"];
            $this->driver = $row["driver"];
            $this->leader = $row["leader"];
            $this->passengers = $row["passengers"];
            $this->status = $row["status"];
            $this->location = $row["location"];
            $this->checkin = $row["checkin"];
        }
    }
?>
