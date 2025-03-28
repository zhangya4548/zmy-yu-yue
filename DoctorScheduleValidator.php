<?php
class DoctorScheduleValidator {
    private $doctor_schedule = [
        1 => ['聂斌', '刘昭'],
        2 => [
            'morning' => ['聂斌', '刘昭', '王昌兴'],
            'afternoon' => []
        ],
        3 => ['聂斌', '刘昭'],
        4 => ['聂斌', '刘昭'],
        5 => ['聂斌', '刘昭'],
        6 => [
            'morning' => ['汤志刚'],
            'afternoon' => ['王昌兴']
        ],
        7 => [
            'morning' => [],
            'afternoon' => ['姜滔']
        ]
    ];

    // 周一：聂斌 刘昭
    // 周二：聂斌 刘昭 王昌兴（上午）
    // 周三：聂斌 刘昭
    // 周四：聂斌 刘昭
    // 周五：聂斌 刘昭
    // 周六：汤志刚（上午）王昌兴 （下午）
    // 周日：姜滔（下午）

    public function validate($doctor_name, $appointment_time) {
        if (empty($appointment_time)) {
            return ['valid' => false, 'message' => '预约时间不能为空'];
        }

        $appointment_timestamp = strtotime($appointment_time);
        if ($appointment_timestamp === false) {
            return ['valid' => false, 'message' => '预约时间格式错误'];
        }

        $weekday = date('N', $appointment_timestamp);
        $hour = (int)date('G', $appointment_timestamp);
        $is_morning = $hour < 12;

        $schedule = $this->doctor_schedule[$weekday];
        
        if (is_array($schedule) && !isset($schedule['morning'])) {
            // 全天排班
            if (!in_array($doctor_name, $schedule)) {
                return ['valid' => false, 'message' => '该医生当天不在排班内'];
            }
        } else {
            // 分时段排班
            $time_slot = $is_morning ? 'morning' : 'afternoon';


           // var_dump($appointment_time,'星期几',$weekday,'是否早上',$is_morning);

            if (!in_array($doctor_name, $schedule[$time_slot])) {
                $period = $is_morning ? '上午' : '下午';
                return ['valid' => false, 'message' => "该医生当天{$period}不在排班内"];
            }
        }

        return ['valid' => true, 'message' => '验证通过'];
    }
}