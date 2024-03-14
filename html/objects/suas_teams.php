<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/objects/ground_teams.php");
    class SUASTeam {
        public int $id;
        public string $mission;
        public int $sortie;
        public string $name;
        public int $gt_id;
        public GroundTeam $gt;
        public string $mp;
        public string $status;
        public string $location;
        public int $checkin;

        public function __construct(int $id){
            $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
            $stmt = $conn->prepare("SELECT * FROM `deployed_suas` WHERE `id`=?");
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
            $this->gt_id = $row["ground_id"];
            $this->gt = new GroundTeam($row["ground_id"]);
            $this->mp = $row["mp"];
            $this->status = $row["status"];
            $this->location = $row["location"];
            $this->checkin = $row["checkin"];
        }

        public function jsonify(){
            $self = array();
            $self["id"] = $this->id;
            $self["mission"] = $this->mission;
            $self["sortie"] = $this->sortie;
            $self["name"] = $this->name;
            $self["gt_id"] = $this->gt_id;
            $self["gt"] = $this->gt->mission." / ".$this->gt->sortie;
            $self["mp"] = $this->mp;
            $self["status"] = $this->status;
            $self["location"] = $this->location;
            $self["checkin"] = $this->checkin;
            return json_encode($self);
        }
    }

    function get_suas_late(){
        $setting = "suas_late";
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare("SELECT * FROM `settings` WHERE `setting`=?");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row["value"];
    }

    function get_suas_warning(){
        $setting = "suas_warning";
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare("SELECT * FROM `settings` WHERE `setting`=?");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        return $row["value"];
    }
?>
