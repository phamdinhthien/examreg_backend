<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/SubjectClasses_Students.php';

$database = new Database();
$db = $database->getConnection();
$subjectClasses_students = new SubjectClasses_Students($db);
$subjectClasses_students->subjectclass_id = $_GET['subjectclass_id']; // ID lớp môn học phần
$subjectClasses_students->importDataFromExcel();
