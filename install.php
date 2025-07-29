<?php
/**
 * 塔罗牌占卜系统安装脚本
 * 用于创建自定义数据库和导入数据
 */

// 检查是否已经安装
if (file_exists('config/installed.lock') && !isset($_GET['reinstall'])) {
    die('系统已经安装完成！如需重新安装，请<a href="?reinstall=1">点击这里</a>或删除 config/installed.lock 文件。');
}

$error = '';
$success = '';
$reinstall = isset($_GET['reinstall']) || isset($_POST['reinstall']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'] ?? 'localhost';
    $db_port = $_POST['db_port'] ?? '3306';
    $db_name = $_POST['db_name'] ?? '';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';
    $admin_username = $_POST['admin_username'] ?? 'admin';
    $admin_password = $_POST['admin_password'] ?? '';
    $admin_email = $_POST['admin_email'] ?? '';
    $drop_existing = isset($_POST['drop_existing']);
    $reinstall = isset($_POST['reinstall']);
    
    // 验证必填字段
    if (empty($db_name) || empty($db_user) || empty($admin_password) || empty($admin_email)) {
        $error = '请填写所有必填字段';
    } else {
        try {
            // 连接MySQL服务器（不指定数据库）
            $dsn = "mysql:host={$db_host};port={$db_port};charset=utf8mb4";
            $pdo = new PDO($dsn, $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // 创建数据库
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$db_name}`");
            
            // 如果选择删除现有表，先删除所有表
            if ($drop_existing) {
                $tables_to_drop = ['customer_messages', 'divination_records', 'tarot_cards', 'admins'];
                foreach ($tables_to_drop as $table) {
                    try {
                        $pdo->exec("DROP TABLE IF EXISTS `{$table}`");
                    } catch (PDOException $e) {
                        // 忽略删除表的错误
                    }
                }
            }
            
            // 读取SQL文件内容
            $sql_content = file_get_contents('database/tarot_divination.sql');
            
            // 改进的SQL执行逻辑
            $sql_content = preg_replace('/--.*$/m', '', $sql_content); // 移除单行注释
            $sql_content = preg_replace('/\/\*.*?\*\//s', '', $sql_content); // 移除多行注释
            
            // 如果不删除现有表，将CREATE TABLE改为CREATE TABLE IF NOT EXISTS
            if (!$drop_existing) {
                $sql_content = str_replace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $sql_content);
            }
            
            // 按分号分割SQL语句
            $statements = explode(';', $sql_content);
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                // 跳过空语句和只包含空白字符的语句
                if (!empty($statement) && strlen($statement) > 3) {
                    try {
                        $pdo->exec($statement);
                    } catch (PDOException $e) {
                        // 如果是INSERT语句出错（可能是重复数据），继续执行
                        if (strpos($statement, 'INSERT') === 0 && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                            continue;
                        }
                        // 其他错误抛出异常
                        throw new Exception("SQL执行错误: " . $e->getMessage() . "\n语句: " . substr($statement, 0, 100) . "...");
                    }
                }
            }
            
            // 验证表是否存在
            $tables = ['admins', 'tarot_cards', 'divination_records', 'customer_messages'];
            foreach ($tables as $table) {
                $result = $pdo->query("SHOW TABLES LIKE '{$table}'");
                if ($result->rowCount() == 0) {
                    throw new Exception("表 '{$table}' 创建失败");
                }
            }
            
            // 检查管理员账户是否存在
            $stmt = $pdo->query("SELECT COUNT(*) FROM admins WHERE id = 1");
            $admin_exists = $stmt->fetchColumn() > 0;
            
            $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
            
            if ($admin_exists) {
                // 更新现有管理员账户
                $stmt = $pdo->prepare("UPDATE admins SET username = ?, password = ?, email = ? WHERE id = 1");
                $result = $stmt->execute([$admin_username, $hashed_password, $admin_email]);
            } else {
                // 插入新的管理员账户
                $stmt = $pdo->prepare("INSERT INTO admins (username, password, email) VALUES (?, ?, ?)");
                $result = $stmt->execute([$admin_username, $hashed_password, $admin_email]);
            }
            
            if (!$result) {
                throw new Exception("管理员账户设置失败");
            }
            
            // 创建config目录（如果不存在）
            if (!is_dir('config')) {
                mkdir('config', 0755, true);
            }
            
            // 更新配置文件
            $config_content = "<?php
// 数据库配置
define('DB_HOST', '{$db_host}');
define('DB_PORT', '{$db_port}');
define('DB_NAME', '{$db_name}');
define('DB_USER', '{$db_user}');
define('DB_PASS', '{$db_pass}');
define('DB_CHARSET', 'utf8mb4');

class Database {
    private \$connection;
    
    public function __construct() {
        try {
            \$dsn = \"mysql:host=\" . DB_HOST . \";port=\" . DB_PORT . \";dbname=\" . DB_NAME . \";charset=\" . DB_CHARSET;
            \$this->connection = new PDO(\$dsn, DB_USER, DB_PASS);
            \$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException \$e) {
            die(\"数据库连接失败: \" . \$e->getMessage());
        }
    }
    
    public function getConnection() {
        return \$this->connection;
    }
}
?>";
            
            if (!file_put_contents('config/database.php', $config_content)) {
                throw new Exception("配置文件写入失败");
            }
            
            // 创建安装锁定文件
            if (!file_put_contents('config/installed.lock', date('Y-m-d H:i:s'))) {
                throw new Exception("安装锁定文件创建失败");
            }
            
            $success = ($reinstall ? '重新安装' : '安装') . '成功！您现在可以使用系统了。';
            
        } catch (Exception $e) {
            $error = '安装失败：' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>塔罗牌占卜系统 - 安装向导</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Microsoft YaHei', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .install-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 600px;
        }
        
        .install-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .install-header h1 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        
        .install-header p {
            color: #666;
        }
        
        .form-section {
            margin-bottom: 2rem;
        }
        
        .form-section h3 {
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #667eea;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group small {
            color: #888;
            font-size: 0.9rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-right: 0.5rem;
        }
        
        .required {
            color: #e74c3c;
        }
        
        .install-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .install-btn:hover {
            transform: translateY(-2px);
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #f5c6cb;
            white-space: pre-wrap;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
        }
        
        .success-actions {
            text-align: center;
            margin-top: 1rem;
        }
        
        .success-actions a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 0 0.5rem;
            transition: background 0.3s;
        }
        
        .success-actions a:hover {
            background: #5a67d8;
        }
        
        .warning-info {
            background: #fff3cd;
            color: #856404;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #ffeaa7;
            font-size: 0.9rem;
        }
        
        .reinstall-warning {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="install-container">
        <div class="install-header">
            <h1>🌙 塔罗牌占卜系统</h1>
            <p><?php echo $reinstall ? '重新安装向导' : '安装向导'; ?> - 配置您的数据库和管理员账户</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success">
                <?php echo htmlspecialchars($success); ?>
                <div class="success-actions">
                    <a href="/">访问网站</a>
                    <a href="admin/login.php">管理后台</a>
                </div>
            </div>
        <?php else: ?>
            <?php if ($reinstall): ?>
                <div class="reinstall-warning">
                    <strong>⚠️ 重新安装模式</strong><br>
                    您正在重新安装系统。请注意：<br>
                    • 如果选择"删除现有数据表"，所有现有数据将被永久删除<br>
                    • 如果不选择删除，系统将尝试保留现有数据并更新配置
                </div>
            <?php else: ?>
                <div class="warning-info">
                    <strong>安装提示：</strong><br>
                    • 请确保MySQL服务已启动<br>
                    • 确保数据库用户有创建数据库的权限<br>
                    • 如果遇到"表已存在"错误，请选择"删除现有数据表"选项<br>
                    • 安装过程中会自动创建所需的数据表和初始数据
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <?php if ($reinstall): ?>
                    <input type="hidden" name="reinstall" value="1">
                <?php endif; ?>
                
                <div class="form-section">
                    <h3>数据库配置</h3>
                    <div class="form-group">
                        <label for="db_host">数据库主机 <span class="required">*</span></label>
                        <input type="text" id="db_host" name="db_host" value="localhost" required>
                        <small>通常为 localhost</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="db_port">数据库端口</label>
                        <input type="number" id="db_port" name="db_port" value="3306">
                        <small>MySQL默认端口为 3306</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="db_name">数据库名称 <span class="required">*</span></label>
                        <input type="text" id="db_name" name="db_name" placeholder="例如：my_tarot_db" required>
                        <small>请输入您想要的数据库名称，系统会自动创建</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="db_user">数据库用户名 <span class="required">*</span></label>
                        <input type="text" id="db_user" name="db_user" placeholder="数据库用户名" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="db_pass">数据库密码</label>
                        <input type="password" id="db_pass" name="db_pass" placeholder="数据库密码">
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="drop_existing" name="drop_existing" <?php echo $reinstall ? 'checked' : ''; ?>>
                        <label for="drop_existing">删除现有数据表（⚠️ 将清空所有数据）</label>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>管理员账户</h3>
                    <div class="form-group">
                        <label for="admin_username">管理员用户名</label>
                        <input type="text" id="admin_username" name="admin_username" value="admin">
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_password">管理员密码 <span class="required">*</span></label>
                        <input type="password" id="admin_password" name="admin_password" placeholder="请设置安全的密码" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_email">管理员邮箱 <span class="required">*</span></label>
                        <input type="email" id="admin_email" name="admin_email" placeholder="admin@example.com" required>
                    </div>
                </div>
                
                <button type="submit" class="install-btn">
                    <?php echo $reinstall ? '重新安装' : '开始安装'; ?>
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>