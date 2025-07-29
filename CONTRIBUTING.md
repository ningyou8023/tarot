# 贡献指南

感谢您对神秘塔罗占卜系统的关注！我们欢迎所有形式的贡献，包括但不限于代码、文档、设计、测试和反馈。

## 🤝 如何贡献

### 🐛 报告问题

如果您发现了bug或有改进建议，请：

1. 在提交问题前，先搜索现有的 [Issues](https://github.com/ningyou8023/tarot/issues) 确保问题未被报告
2. 使用清晰、描述性的标题
3. 提供详细的问题描述，包括：
   - 问题的具体表现
   - 重现步骤
   - 预期行为
   - 实际行为
   - 环境信息（操作系统、浏览器版本、PHP版本等）
   - 相关的错误日志或截图

### 💡 功能建议

我们欢迎新功能建议！请：

1. 在 Issues 中创建功能请求
2. 详细描述功能的用途和价值
3. 提供使用场景和示例
4. 考虑功能的实现复杂度和维护成本

### 🔧 代码贡献

#### 开发环境设置

1. **Fork 项目**
   ```bash
   # 在 GitHub 上 Fork 项目到您的账户
   ```

2. **克隆到本地**
   ```bash
   git clone https://github.com/ningyou8023/tarot.git
   cd tarot-divination
   ```

3. **设置开发环境**
   ```bash
   # 确保您有 PHP 7.2+ 和 MySQL 5.7+
   # 配置数据库连接
   cp config/database.example.php config/database.php
   # 编辑数据库配置
   ```

4. **创建功能分支**
   ```bash
   git checkout -b feature/your-feature-name
   # 或者修复bug
   git checkout -b fix/your-bug-fix
   ```

#### 代码规范

请遵循以下代码规范：

**PHP 代码规范：**
- 遵循 PSR-4 自动加载规范
- 使用 PSR-12 编码风格
- 类名使用 PascalCase
- 方法名和变量名使用 camelCase
- 常量使用 UPPER_CASE
- 添加适当的注释和文档

**JavaScript 代码规范：**
- 使用 ES6+ 语法
- 使用 camelCase 命名
- 添加适当的注释
- 保持代码简洁和可读

**CSS 代码规范：**
- 使用有意义的类名
- 遵循 BEM 命名规范
- 保持样式的模块化

#### 提交规范

使用清晰的提交信息：

```bash
# 功能添加
git commit -m "feat: 添加新的牌阵类型支持"

# Bug修复
git commit -m "fix: 修复占卜结果显示问题"

# 文档更新
git commit -m "docs: 更新安装说明"

# 样式调整
git commit -m "style: 优化移动端界面布局"

# 重构代码
git commit -m "refactor: 重构占卜API结构"

# 性能优化
git commit -m "perf: 优化数据库查询性能"

# 测试相关
git commit -m "test: 添加占卜功能单元测试"
```

#### Pull Request 流程

1. **确保代码质量**
   - 代码通过所有测试
   - 遵循项目的代码规范
   - 添加必要的注释和文档

2. **创建 Pull Request**
   - 使用清晰的标题描述更改
   - 在描述中详细说明：
     - 更改的内容和原因
     - 相关的 Issue 编号
     - 测试情况
     - 截图（如果涉及UI更改）

3. **代码审查**
   - 响应审查者的反馈
   - 根据建议进行必要的修改
   - 保持讨论的专业和建设性

## 📝 开发指南

### 项目架构

```
tarot-divination/
├── admin/              # 后台管理模块
├── api/               # API接口
├── assets/            # 前端资源
├── classes/           # PHP类文件
├── config/            # 配置文件
├── database/          # 数据库相关
├── images/            # 图片资源
└── includes/          # 公共文件
```

### 数据库设计

主要数据表：
- `divination_records` - 占卜记录
- `customer_messages` - 客户消息
- `website_settings` - 网站设置
- `admin_users` - 管理员用户

### API设计

所有API遵循RESTful设计原则：
- 使用适当的HTTP方法
- 返回标准的JSON格式
- 包含适当的状态码
- 提供错误处理

### 安全考虑

- 所有用户输入必须验证和过滤
- 使用预处理语句防止SQL注入
- 实现CSRF保护
- 对敏感数据进行加密

## 🧪 测试

### 运行测试

```bash
# 运行PHP单元测试
phpunit tests/

# 运行前端测试
npm test
```

### 测试覆盖率

我们努力保持高测试覆盖率：
- 核心功能必须有单元测试
- API接口必须有集成测试
- 关键用户流程必须有端到端测试

## 📚 文档

### 文档类型

- **用户文档** - README.md
- **API文档** - api/README.md
- **开发文档** - docs/development.md
- **部署文档** - docs/deployment.md

### 文档更新

当您的更改影响到用户使用或开发流程时，请同时更新相关文档。

## 🎯 优先级

当前开发优先级：

1. **高优先级**
   - 安全漏洞修复
   - 核心功能bug修复
   - 性能优化

2. **中优先级**
   - 新功能开发
   - 用户体验改进
   - 代码重构

3. **低优先级**
   - 文档完善
   - 代码注释
   - 非关键功能

## 🏆 贡献者认可

我们重视每一位贡献者的努力：

- 所有贡献者将在 README.md 中被提及
- 重要贡献者将获得项目维护者权限
- 优秀贡献将在项目主页展示

## 📞 联系我们

如果你有任何疑问或需要帮助，可以通过以下方式联系我们：

- 创建 [GitHub Issue](https://github.com/ningyou8023/tarot/issues)
- 参与讨论：[GitHub Discussions](https://github.com/ningyou8023/tarot/discussions)
- 加入我们的讨论群：QQ群 593347084

## 🙏 感谢

感谢您考虑为神秘塔罗占卜系统做出贡献！您的参与让这个项目变得更好。

---

**记住：每一个伟大的项目都始于一个小小的贡献！** 🌟