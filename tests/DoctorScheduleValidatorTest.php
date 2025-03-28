<?php
require_once __DIR__ . '/../DoctorScheduleValidator.php';

class DoctorScheduleValidatorTest extends PHPUnit\Framework\TestCase {
    private $validator;

    protected function setUp(): void {
        $this->validator = new DoctorScheduleValidator();
    }

    // 周一测试用例
    public function testMondaySchedule() {
        // 聂斌 - 全天
        $result = $this->validator->validate('聂斌', '2024-03-18 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('聂斌', '2024-03-18 14:00:00');
        $this->assertTrue($result['valid']);

        // 刘昭 - 全天
        $result = $this->validator->validate('刘昭', '2024-03-18 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('刘昭', '2024-03-18 14:00:00');
        $this->assertTrue($result['valid']);
    }

    // 周二测试用例
    public function testTuesdaySchedule() {
        // 聂斌 - 全天
        $result = $this->validator->validate('聂斌', '2024-03-19 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('聂斌', '2024-03-19 14:00:00');
        $this->assertTrue($result['valid']);

        // 刘昭 - 全天
        $result = $this->validator->validate('刘昭', '2024-03-19 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('刘昭', '2024-03-19 14:00:00');
        $this->assertTrue($result['valid']);

        // 王昌兴 - 仅上午
        $result = $this->validator->validate('王昌兴', '2024-03-19 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('王昌兴', '2024-03-19 14:00:00');
        $this->assertFalse($result['valid']);
    }

    // 周三测试用例
    public function testWednesdaySchedule() {
        // 聂斌和刘昭 - 全天
        $result = $this->validator->validate('聂斌', '2024-03-20 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('刘昭', '2024-03-20 14:00:00');
        $this->assertTrue($result['valid']);
    }

    // 周四测试用例
    public function testThursdaySchedule() {
        // 聂斌和刘昭 - 全天
        $result = $this->validator->validate('聂斌', '2024-03-21 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('刘昭', '2024-03-21 14:00:00');
        $this->assertTrue($result['valid']);
    }

    // 周五测试用例
    public function testFridaySchedule() {
        // 聂斌和刘昭 - 全天
        $result = $this->validator->validate('聂斌', '2024-03-22 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('刘昭', '2024-03-22 14:00:00');
        $this->assertTrue($result['valid']);
    }

    // 周六测试用例
    public function testSaturdaySchedule() {
        // 汤志刚 - 仅上午
        $result = $this->validator->validate('汤志刚', '2024-03-23 09:00:00');
        $this->assertTrue($result['valid']);
        
        $result = $this->validator->validate('汤志刚', '2024-03-23 14:00:00');
        $this->assertFalse($result['valid']);

        // 王昌兴 - 仅下午
        $result = $this->validator->validate('王昌兴', '2024-03-23 09:00:00');
        $this->assertFalse($result['valid']);
        
        $result = $this->validator->validate('王昌兴', '2024-03-23 14:00:00');
        $this->assertTrue($result['valid']);
    }

    // 周日测试用例
    public function testSundaySchedule() {
        // 姜滔 - 仅下午
        $result = $this->validator->validate('姜滔', '2024-03-24 09:00:00');
        $this->assertFalse($result['valid']);
        
        $result = $this->validator->validate('姜滔', '2024-03-24 14:00:00');
        $this->assertTrue($result['valid']);

        // 其他医生都不应该可以预约
        $result = $this->validator->validate('聂斌', '2024-03-24 09:00:00');
        $this->assertFalse($result['valid']);
        
        $result = $this->validator->validate('刘昭', '2024-03-24 14:00:00');
        $this->assertFalse($result['valid']);
    }

    // 边界时间测试
    public function testTimeEdgeCases() {
        // 上午边界测试 (11:59)
        $result = $this->validator->validate('聂斌', '2024-03-18 11:59:00');
        $this->assertTrue($result['valid']);

        // 下午边界测试 (12:00)
        $result = $this->validator->validate('聂斌', '2024-03-18 12:00:00');
        $this->assertTrue($result['valid']);
    }
}