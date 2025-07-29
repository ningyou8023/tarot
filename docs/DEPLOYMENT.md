# 部署指南

本文档提供了神秘塔罗占卜系统的详细部署说明。

## 📋 部署前准备

### 系统要求

- **操作系统**: Linux (推荐 Ubuntu 20.04+), Windows Server, macOS
- **Web服务器**: Apache 2.4+ 或 Nginx 1.16+
- **PHP**: 7.2 或更高版本
- **数据库**: MySQL 5.7+ 或 MariaDB 10.3+
- **内存**: 最少 512MB RAM (推荐 1GB+)
- **存储**: 最少 500MB 可用空间

### PHP扩展要求

确保以下PHP扩展已安装：

```bash
# 必需扩展
php-mysqli
php-pdo
php-pdo-mysql
php-json
php-session
php-mbstring

# 推荐扩展
php-curl
php-gd
php-zip
php-xml
```

## 🚀 部署方式

### 方式一：传统部署

#### 1. 下载项目

```bash
# 使用Git克隆
git clone https://github.com/ningyou8023/tarot.git
cd tarot-divination

# 或下载ZIP包并解压
wget https://github.com/ningyou8023/tarot/archive/main.zip
unzip main.zip
cd tarot-divination-main
```

#### 2. 配置Web服务器

**Apache配置示例：**

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/html/tarot-divination
    
    <Directory /var/www/html/tarot-divination>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/tarot_error.log
    CustomLog ${APACHE_LOG_DIR}/tarot_access.log combined
</VirtualHost>
```

**Nginx配置示例：**

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/html/tarot-divination;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

#### 3. 配置数据库

```bash
# 登录MySQL
mysql -u root -p

# 创建数据库
CREATE DATABASE tarot_divination CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 创建用户（可选）
CREATE USER 'tarot_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON tarot_divination.* TO 'tarot_user'@'localhost';
FLUSH PRIVILEGES;

# 导入数据库结构
mysql -u root -p tarot_divination < database/tarot_divination.sql
```

#### 4. 配置应用

```bash
# 复制配置文件
cp config/database.example.php config/database.php

# 编辑数据库配置
nano config/database.php
```

修改数据库配置：

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'tarot_divination');
define('DB_USER', 'tarot_user');
define('DB_PASS', 'strong_password');
```

#### 5. 设置文件权限

```bash
# 设置所有者
chown -R www-data:www-data /var/www/html/tarot-divination

# 设置目录权限
find /var/www/html/tarot-divination -type d -exec chmod 755 {} \;

# 设置文件权限
find /var/www/html/tarot-divination -type f -exec chmod 644 {} \;

# 如果有上传目录，设置写权限
chmod 777 uploads/ # 如果存在
```

### 方式二：Docker部署 (推荐)

#### 1. 安装Docker

```bash
# Ubuntu/Debian
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# 安装Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

#### 2. 部署应用

```bash
# 克隆项目
git clone https://github.com/ningyou8023/tarot.git
cd tarot-divination

# 启动服务
docker-compose up -d

# 查看状态
docker-compose ps
```

#### 3. 访问应用

- **网站**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **数据库**: localhost:3306

### 方式三：云平台部署

#### Heroku部署

1. 创建Heroku应用
2. 添加ClearDB MySQL插件
3. 配置环境变量
4. 推送代码

#### AWS部署

1. 创建EC2实例
2. 配置RDS数据库
3. 设置负载均衡器
4. 配置CloudFront CDN

## 🔧 生产环境优化

### 性能优化

```bash
# 启用PHP OPcache
echo "opcache.enable=1" >> /etc/php/7.4/apache2/php.ini
echo "opcache.memory_consumption=128" >> /etc/php/7.4/apache2/php.ini

# 配置MySQL优化
echo "innodb_buffer_pool_size=256M" >> /etc/mysql/mysql.conf.d/mysqld.cnf
echo "query_cache_size=64M" >> /etc/mysql/mysql.conf.d/mysqld.cnf
```

### 安全配置

```bash
# 隐藏PHP版本
echo "expose_php=Off" >> /etc/php/7.4/apache2/php.ini

# 禁用危险函数
echo "disable_functions=exec,passthru,shell_exec,system" >> /etc/php/7.4/apache2/php.ini

# 设置会话安全
echo "session.cookie_httponly=1" >> /etc/php/7.4/apache2/php.ini
echo "session.cookie_secure=1" >> /etc/php/7.4/apache2/php.ini
```

### SSL证书配置

```bash
# 使用Let's Encrypt
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d your-domain.com
```

## 📊 监控和维护

### 日志配置

```bash
# Apache日志
tail -f /var/log/apache2/tarot_error.log

# PHP错误日志
tail -f /var/log/php_errors.log

# MySQL慢查询日志
tail -f /var/log/mysql/mysql-slow.log
```

### 备份策略

```bash
# 数据库备份脚本
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u root -p tarot_divination > backup_$DATE.sql
gzip backup_$DATE.sql

# 文件备份
tar -czf files_backup_$DATE.tar.gz /var/www/html/tarot-divination
```

### 更新流程

```bash
# 1. 备份当前版本
cp -r /var/www/html/tarot-divination /var/www/html/tarot-divination.backup

# 2. 下载新版本
git pull origin main

# 3. 更新数据库（如果需要）
mysql -u root -p tarot_divination < database/updates/update_v1.2.sql

# 4. 清理缓存
rm -rf cache/*

# 5. 重启服务
systemctl restart apache2
```

## 🚨 故障排除

### 常见问题

**1. 数据库连接失败**
```bash
# 检查MySQL服务状态
systemctl status mysql

# 检查数据库配置
cat config/database.php

# 测试连接
mysql -u tarot_user -p -h localhost tarot_divination
```

**2. 权限问题**
```bash
# 重新设置权限
chown -R www-data:www-data /var/www/html/tarot-divination
chmod -R 755 /var/www/html/tarot-divination
```

**3. PHP错误**
```bash
# 检查PHP错误日志
tail -f /var/log/php_errors.log

# 检查Apache错误日志
tail -f /var/log/apache2/error.log
```

### 性能问题诊断

```bash
# 检查系统资源
htop
df -h
free -m

# 检查MySQL性能
mysql -u root -p -e "SHOW PROCESSLIST;"
mysql -u root -p -e "SHOW STATUS LIKE 'Slow_queries';"

# 检查Apache状态
apache2ctl status
```

## 📞 技术支持

如果在部署过程中遇到问题，可以通过以下方式获取帮助：

- **GitHub Issues**: [提交问题](https://github.com/ningyou8023/tarot/issues)
- **项目文档**: 查看 [README.md](../README.md) 和 [CONTRIBUTING.md](../CONTRIBUTING.md)
- **交流群**: QQ群 593347084

---

*最后更新：2024年1月*