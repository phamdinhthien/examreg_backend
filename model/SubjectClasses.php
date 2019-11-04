<?php
    class Courses{
        private $table = 'subjects';
        public $id;
        public $code;
        public $name;
        public $course_id;

        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }
        
        public function getSubjectsBySubjectId()
        {
            $query = "select * from $this->table where course_id=:course_id";
            $stm = $this->conn->prepare($query);
            $stm->bindParam('course_id', $this->course_id);
            $stm->execute();
            return $stm;
        }
    }
