<?php
    class AirTeam {
        public int $id;
        public string $mission;
        public int $sortie;
        public string $name;
        public string $callsign;
        public string $mp;
        public string $mo;
        public string $ms_ap;
        public string $status;
        public string $location;
        public int $checkin;

        public function __construct(int $id){
            $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
            $stmt = $conn->prepare("SELECT * FROM `deployed_air` WHERE `id`=?");
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
            $this->callsign = $row["callsign"];
            $this->mp = $row["mp"];
            $this->mo = $row["mo"];
            $this->ms_ap = $row["ms_ap"];
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
            $self["callsign"] = $this->callsign;
            $self["mp"] = $this->mp;
            $self["mo"] = $this->mo;
            $self["ms_ap"] = $this->ms_ap;
            $self["status"] = $this->status;
            $self["location"] = $this->location;
            $self["checkin"] = $this->checkin;
            return json_encode($self);
        }
    }

    function get_air_late(){
        $setting = "air_late";
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare("SELECT * FROM `settings` WHERE `setting`=?");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row["value"];
    }

    function get_air_warning(){
        $setting = "air_warning";
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare("SELECT * FROM `settings` WHERE `setting`=?");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row["value"];
    }
?>
