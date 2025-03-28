<?php
header('Content-Type: application/json; charset=utf-8');

// 数据库连接配置
$db_host = '106.75.239.51';
$db_user = 'root';
$db_pass = '3cswWcr2Sj2Y';
$db_name = 'gfast_v32';

// 处理预约提交
require_once __DIR__ . '/DoctorScheduleValidator.php';

function handleAppointment() {
    global $db_host, $db_user, $db_pass, $db_name;
    
    // 获取 JSON 数据
    $json = file_get_contents('php://input');
    $postData = json_decode($json, true) ?? [];
    
    // 获取并过滤表单数据
    $doctor_name = htmlspecialchars($postData['sage'] ?? '', ENT_QUOTES, 'UTF-8');
    $patient_name = htmlspecialchars($postData['sname'] ?? '', ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($postData['stel'] ?? '', ENT_QUOTES, 'UTF-8');
    $appointment_time = htmlspecialchars($postData['stime'] ?? '', ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars($postData['ssex'] ?? '男', ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($postData['sb'] ?? '', ENT_QUOTES, 'UTF-8');
    
    // 进一步清理数据
    $doctor_name = trim($doctor_name);
    $patient_name = trim($patient_name);
    $phone = trim($phone);
    $appointment_time = trim($appointment_time);
    $gender = trim($gender);
    $message = trim($message);
    

    // sage: 杨国庆
    // sname: 张光强
    // stel: 13588888888
    // stime: 2025-03-15 17:24:22
    // ssex: 男
    // sb: 123123


    // 验证必填字段
    if (empty($patient_name) || empty($phone)) {
        return ['code' => 1, 'msg' => '请填写联系人和联系电话'];
    }
    
    // 验证手机号格式
    if (!preg_match("/^1[3-9]\d{9}$/", $phone)) {
        return ['code' => 1, 'msg' => '请输入正确的手机号码'];
    }
    
    // 验证性别
    if (!in_array($gender, ['男', '女'])) {
        return ['code' => 1, 'msg' => '性别参数错误'];
    }
    
    // 验证预约时间格式
    if (!empty($appointment_time) && !strtotime($appointment_time)) {
        return ['code' => 1, 'msg' => '预约时间格式错误'];
    }

    // 验证预约时间不能小于当前时间
    if (!empty($appointment_time)) {
        $appointment_timestamp = strtotime($appointment_time);
        $current_timestamp = time();
        if ($appointment_timestamp <= $current_timestamp) {
            return ['code' => 1, 'msg' => '预约时间不能小于当前时间'];
        }
    }
    // var_dump( $appointment_timestamp,$current_timestamp);die();
    // 验证医生预约时间
    $validator = new DoctorScheduleValidator();
   
    $validation_result = $validator->validate($doctor_name, $appointment_time);
    if (!$validation_result['valid']) {
        return ['code' => 1, 'msg' => $validation_result['message']];
    }

    // 周一：聂斌 刘昭
    // 周二：聂斌 刘昭 王昌兴（上午）
    // 周三：聂斌 刘昭
    // 周四：聂斌 刘昭
    // 周五：聂斌 刘昭
    // 周六：汤志刚（上午）王昌兴 （下午）
    // 周日：姜滔（下午）

    // var_dump($doctor_name, $appointment_time);die();

    try {
        // 连接数据库
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("SET NAMES utf8mb4");
        
        // 准备SQL语句
        $sql = "INSERT INTO zmy_yu_yue (doctor_name, patient_name, phone, appointment_time, gender, message) 
                VALUES (:doctor_name, :patient_name, :phone, :appointment_time, :gender, :message)";
        
        // 预处理并执行
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':doctor_name' => $doctor_name,
            ':patient_name' => $patient_name,
            ':phone' => $phone,
            ':appointment_time' => $appointment_time,
            ':gender' => $gender,
            ':message' => $message
        ]);
        
        return ['code' => 0, 'msg' => '预约提交成功'];
        
    } catch(PDOException $e) {
        return ['code' => 1, 'msg' => '系统错误，请稍后重试'];
    }
}

// 处理请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = handleAppointment();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}