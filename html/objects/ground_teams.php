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
                throw new Exception($conn->error);
            }
            if($result->num_rows === 0){
                throw new Exception("Does not exist");
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
            $stmt->close();
            $conn->close();
        }

        public function jsonify(){
            $self = array();
            $self["id"] = $this->id;
            $self["mission"] = $this->mission;
            $self["sortie"] = $this->sortie;
            $self["name"] = $this->name;
            $self["cov"] = $this->cov;
            $self["driver"] = $this->driver;
            $self["leader"] = $this->leader;
            $self["passengers"] = $this->passengers;
            $self["status"] = $this->status;
            $self["location"] = $this->location;
            $self["checkin"] = $this->checkin;
            return json_encode($self);
        }
    }

    function get_ground_late(){
        $setting = "ground_late";
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare("SELECT * FROM `settings` WHERE `setting`=?");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row["value"];
    }

    function get_ground_warning(){
        $setting = "ground_warning";
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare("SELECT * FROM `settings` WHERE `setting`=?");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row["value"];
    }
?>
