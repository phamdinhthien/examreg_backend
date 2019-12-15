<?php
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     include '../../config/configDB.php';
     include '../../model/Students.php';

     $database = new Database();
     $db = $database->getConnection();
     $students = new Students($db);
     $students->class_id = $_GET['id']; // ID lớp học
     $students->importDataFromExcel();
