# 神秘塔罗 - 在线占卜系统

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-7.2%2B-blue.svg)
![MySQL Version](https://img.shields.io/badge/MySQL-5.7%2B-blue.svg)

一个功能完整的塔罗牌在线占卜系统，采用现代化的Web技术栈构建，提供美观的用户界面和强大的后台管理功能。

## 🌟 项目特色

- **🔮 专业占卜体验** - 多种牌阵选择，智能解读系统
- **🎨 精美界面设计** - 神秘主题风格，动态星空背景
- **📱 响应式布局** - 完美适配桌面端和移动端
- **🛡️ 安全可靠** - 完善的数据验证和安全防护
- **⚡ 高性能** - 优化的数据库查询和前端加载

## 📋 功能特点

### 🎯 前端功能
- **多种占卜方式**
  - 🃏 单张牌占卜 - 快速洞察当下
  - 🔮 三张牌占卜 - 过去现在未来
  - 💕 爱情占卜 - 感情运势分析
  - 💼 事业占卜 - 职场发展指导
  - ⭐ 五张牌占卜 - 全面人生解读
  - 🌟 凯尔特十字 - 深度综合分析

- **智能解读系统**
  - 📖 卡牌基本含义展示
  - 🧠 AI综合解读分析
  - 💡 个性化建议指导
  - 🎯 针对性行动方案

- **用户体验**
  - 🌌 沉浸式星空背景
  - ✨ 流畅的动画效果
  - 🎵 舒缓的背景音乐
  - 📱 移动端优化体验

### 🔧 后台管理
- **📊 数据管理**
  - 占卜记录查看与管理
  - 用户咨询消息处理
  - 系统设置配置
  - 数据统计分析

- **🛠️ 系统功能**
  - 管理员账户管理
  - 网站信息设置
  - 联系方式配置
  - 缓存清理工具

## 🛠️ 技术栈

- **后端框架**: PHP 7.2+ (面向对象设计)
- **数据库**: MySQL 5.7+ (优化查询性能)
- **前端技术**: HTML5, CSS3, JavaScript ES6+
- **UI设计**: 自定义CSS + Google Fonts
- **架构模式**: MVC分层架构
- **安全特性**: SQL注入防护, XSS防护, CSRF保护

## 📦 安装部署

### 🔧 环境要求

- **PHP**: 7.2 或更高版本
- **MySQL**: 5.7 或更高版本  
- **Web服务器**: Apache 2.4+ / Nginx 1.16+
- **PHP扩展**: mysqli, json, session

### 🚀 快速安装

1. **下载项目**
   ```

2. **配置数据库**
   ```bash
   # 创建数据库
   mysql -u root -p
   CREATE DATABASE tarot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   
   # 导入数据库结构
   mysql -u root -p tarot < database/tarot_divination.sql
   ```

3. **配置数据库连接**
   ```php
   # 编辑 config/database.php
   <?php
   return [
       'host' => 'localhost',
       'username' => 'tarot',
       'password' => '123456',
       'database' => 'tarot'
   ];
   ```

4. **设置文件权限**
   ```bash
   # Linux/Mac 系统
   chmod 755 -R ./
   chmod 777 -R ./uploads/ # 如果有上传目录
   
   # Windows 系统确保 IIS_IUSRS 有读写权限
   ```

5. **访问安装页面**
   ```
   http://主域名/install.php
   ```

### 🐳 Docker 部署 (推荐)

```bash
# 使用 Docker Compose 一键部署
docker-compose up -d

# 访问应用
http://localhost:8080
```

## 📖 使用指南

### 🎯 前端使用

1. **访问首页** - 浏览器打开网站首页
2. **选择占卜方式** - 根据需求选择不同的牌阵
3. **输入问题** - 在心中默念或输入你的问题
4. **开始占卜** - 点击开始按钮进行抽牌
5. **查看结果** - 获得详细的卡牌解读和建议

### 🔧 后台管理

1. **登录后台**
   ```
   访问: http://主域名/admin/
   默认账号: admin
   默认密码: admin123
   ```

2. **功能模块**
   - **占卜记录** - 查看所有用户的占卜历史
   - **客服消息** - 处理用户咨询和反馈
   - **系统设置** - 配置网站基本信息
   - **账户管理** - 修改管理员密码

## 🗂️ 项目结构

```
tarot-divination/
├── 📁 admin/              # 后台管理模块
│   ├── includes/          # 后台公共文件
│   ├── *.php             # 后台页面文件
├── 📁 api/               # API接口目录
│   ├── divination.php    # 占卜核心API
│   ├── contact.php       # 联系表单API
│   └── *.php            # 其他API文件
├── 📁 assets/            # 静态资源
│   ├── css/             # 样式文件
│   ├── js/              # JavaScript文件
├── 📁 classes/           # PHP类文件
│   ├── TarotCard.php    # 塔罗牌类
│   ├── DivinationRecord.php # 占卜记录类
│   └── *.php            # 其他类文件
├── 📁 config/            # 配置文件
├── 📁 database/          # 数据库文件
├── 📁 images/            # 卡牌图片资源
├── 📁 includes/          # 公共包含文件
├── index.php            # 网站首页
├── draw_cards.php       # 抽牌页面
└── README.md           # 项目说明
```

## 🎨 界面预览

### 首页展示
- 神秘的星空背景动画
- 优雅的卡牌选择界面
- 流畅的用户交互体验

### 占卜结果
- 精美的卡牌展示效果
- 详细的解读内容
- 个性化的建议指导

### 后台管理
- 简洁的管理界面
- 完整的数据统计
- 便捷的操作功能

## 🔒 安全特性

- **SQL注入防护** - 使用预处理语句
- **XSS攻击防护** - 输出内容转义
- **CSRF保护** - 表单令牌验证
- **会话安全** - 安全的会话管理
- **输入验证** - 严格的数据验证

## 🚀 性能优化

- **数据库优化** - 索引优化和查询缓存
- **前端优化** - 资源压缩和懒加载
- **缓存机制** - 智能缓存策略
- **CDN支持** - 静态资源加速

## 🤝 贡献指南

我们欢迎所有形式的贡献！

### 🐛 报告问题
- 使用 [GitHub Issues](https://github.com/ningyou8023/tarot/issues) 报告bug
- 提供详细的问题描述和复现步骤

### 💡 功能建议
- 在 Issues 中提出新功能建议
- 详细描述功能需求和使用场景

### 🔧 代码贡献
1. Fork 本项目
2. 创建功能分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 创建 Pull Request

### 📝 代码规范
- 遵循 PSR-4 自动加载规范
- 使用有意义的变量和函数命名
- 添加必要的注释和文档
- 保持代码整洁和可读性

## 📄 开源协议

本项目采用 [MIT License](LICENSE) 开源协议。

## 🙏 致谢

- 感谢所有贡献者的支持
- 特别感谢开源社区的帮助
- 塔罗牌图片资源来源于开源项目

## 📞 联系我们

- **项目主页**: [GitHub Repository](https://github.com/ningyou8023/tarot)
- **问题反馈**: [GitHub Issues](https://github.com/ningyou8023/tarot/issues)
- **交流群**: QQ群 593347084

## 🔮 未来规划

- [ ] 移动端APP开发
- [ ] 更多牌阵类型支持
- [ ] AI智能解读升级
- [ ] 多语言国际化
- [ ] 用户系统完善
- [ ] 社交分享功能

---

⭐ 如果这个项目对你有帮助，请给我们一个星标！

🔮 **愿塔罗的智慧指引你的人生之路** 🔮bash
   git clone https://github.com/ningyou8023/tarot.git
   cd tarot-divination