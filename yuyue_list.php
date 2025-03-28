<?php
// 设置页面编码
header('Content-Type: text/html; charset=utf-8');

// 数据库连接配置
$db_host = '106.75.239.51';
$db_user = 'root';
$db_pass = '3cswWcr2Sj2Y';
$db_name = 'gfast_v32';

// 连接数据库
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8mb4");
} catch(PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

// 获取搜索参数并过滤
$search = [];
// 移除 message 字段，不再搜索留言内容
$search_fields = ['doctor_name', 'patient_name', 'phone', 'appointment_time', 'gender'];
foreach ($search_fields as $field) {
    if (isset($_GET[$field]) && $_GET[$field] !== '') {
        // 使用 htmlspecialchars 防止 XSS 攻击
        $search[$field] = htmlspecialchars(trim($_GET[$field]), ENT_QUOTES, 'UTF-8');
    }
}

// 构建查询条件
$where = [];
$params = [];
foreach ($search as $field => $value) {
    // 使用参数绑定防止 SQL 注入
    if ($field === 'appointment_time') {
        // 修改为按日期搜索，不包含时间
        $where[] = "DATE($field) = :$field";
        $params[":$field"] = $value; // 精确匹配日期
    } else {
        $where[] = "$field LIKE :$field";
        $params[":$field"] = "%$value%"; // 模糊匹配
    }
}

// 构建 SQL 语句
$sql = "SELECT * FROM zmy_yu_yue";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id DESC"; // 默认按ID降序排列

// 分页参数
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 10; // 每页显示10条
$offset = ($page - 1) * $limit;

// 添加分页限制
$sql .= " LIMIT :offset, :limit";
$params[':offset'] = $offset;
$params[':limit'] = $limit;

// 获取总记录数
$count_sql = "SELECT COUNT(*) FROM zmy_yu_yue";
if (!empty($where)) {
    $count_sql .= " WHERE " . implode(" AND ", $where);
}
$stmt = $conn->prepare($count_sql);
foreach ($search as $field => $value) {
    if ($field === 'appointment_time') {
        $stmt->bindValue(":$field", $value, PDO::PARAM_STR);
    } else {
        $stmt->bindValue(":$field", "%$value%", PDO::PARAM_STR);
    }
}
$stmt->execute();
$total = $stmt->fetchColumn();
$total_pages = ceil($total / $limit);

// 执行查询
$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    if ($key === ':offset' || $key === ':limit') {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }
}
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>预约列表查询</title>
    <link href="http://unpkg.com/layui@2.7.6/dist/css/layui.css" rel="stylesheet">
    <script src="http://unpkg.com/layui@2.7.6/dist/layui.js"></script>
    <style>
        .search-form {
            padding: 20px;
            background-color: #f2f2f2;
            margin-bottom: 20px;
        }
        .layui-form-item {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="layui-container">
        <h1 class="layui-header" style="padding: 20px 0;">预约列表查询</h1>
        
        <!-- 搜索表单 -->
        <div class="search-form">
            <form class="layui-form" method="get" action="">
                <div class="layui-row">
                    <div class="layui-col-md4">
                        <div class="layui-form-item">
                            <label class="layui-form-label">专家姓名</label>
                            <div class="layui-input-block">
                                <input type="text" name="doctor_name" placeholder="请输入专家姓名" autocomplete="off" class="layui-input" value="<?= isset($search['doctor_name']) ? $search['doctor_name'] : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md4">
                        <div class="layui-form-item">
                            <label class="layui-form-label">患者姓名</label>
                            <div class="layui-input-block">
                                <input type="text" name="patient_name" placeholder="请输入患者姓名" autocomplete="off" class="layui-input" value="<?= isset($search['patient_name']) ? $search['patient_name'] : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md4">
                        <div class="layui-form-item">
                            <label class="layui-form-label">联系电话</label>
                            <div class="layui-input-block">
                                <input type="text" name="phone" placeholder="请输入联系电话" autocomplete="off" class="layui-input" value="<?= isset($search['phone']) ? $search['phone'] : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-row">
                    <div class="layui-col-md4">
                        <div class="layui-form-item">
                            <label class="layui-form-label">预约日期</label>
                            <div class="layui-input-block">
                                <input type="text" name="appointment_time" id="appointment_time" placeholder="请选择预约日期" autocomplete="off" class="layui-input" value="<?= isset($search['appointment_time']) ? $search['appointment_time'] : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md4">
                        <div class="layui-form-item">
                            <label class="layui-form-label">性别</label>
                            <div class="layui-input-block">
                                <select name="gender" lay-filter="gender">
                                    <option value="">全部</option>
                                    <option value="男" <?= isset($search['gender']) && $search['gender'] === '男' ? 'selected' : '' ?>>男</option>
                                    <option value="女" <?= isset($search['gender']) && $search['gender'] === '女' ? 'selected' : '' ?>>女</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- 移除留言内容搜索 -->
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit>搜索</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- 数据表格 -->
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>专家姓名</th>
                    <th>患者姓名</th>
                    <th>联系电话</th>
                    <th>预约时间</th>
                    <th>性别</th>
                    <th>提交时间</th>
                    <th>留言内容</th>

                </tr>
            </thead>
            <tbody>
                <?php if (empty($results)): ?>
                <tr>
                    <td colspan="8" style="text-align: center;">暂无数据</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                        <td><?= htmlspecialchars($row['patient_name']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                        <td><?= htmlspecialchars($row['gender']) ?></td>
                        <td><?= isset($row['create_time']) ? htmlspecialchars($row['create_time']) : (isset($row['created_at']) ? htmlspecialchars($row['created_at']) : '') ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- 分页 -->
        <div id="pagination" class="layui-box layui-laypage layui-laypage-default"></div>
    </div>
    
    <script>
    layui.use(['laypage', 'form', 'laydate'], function(){
        var laypage = layui.laypage;
        var form = layui.form;
        var laydate = layui.laydate;
        
        // 初始化日期选择器，改为仅日期
        laydate.render({
            elem: '#appointment_time',
            type: 'date'  // 修改为仅日期选择
        });
        
        // 渲染分页
        laypage.render({
            elem: 'pagination',
            count: <?= $total ?>,
            limit: <?= $limit ?>,
            curr: <?= $page ?>,
            layout: ['count', 'prev', 'page', 'next', 'limit', 'skip'],
            jump: function(obj, first){
                if(!first){
                    // 构建URL参数
                    var params = new URLSearchParams(window.location.search);
                    params.set('page', obj.curr);
                    params.set('limit', obj.limit);
                    window.location.href = '?' + params.toString();
                }
            }
        });
        
        // 表单重置按钮
        form.on('submit(reset)', function(data){
            window.location.href = window.location.pathname;
            return false;
        });
    });
    </script>
</body>
</html>