<?php
// 获取网站设置
require_once 'classes/WebsiteSettings.php';
$settings = new WebsiteSettings();
$allSettings = $settings->getAllSettingsGrouped();

// 服务说明
$serviceDesc = $allSettings['service']['service_desc'] ?? '我们提供专业的塔罗牌占卜服务，获得基础解读后可联系专业占卜师获得更深入指导';
$contactWechat = $allSettings['contact']['wechat'] ?? 'tarot_master';
$contactQQ = $allSettings['contact']['qq'] ?? '123456789';
$serviceHours = $allSettings['contact']['service_hours'] ?? '9:00-22:00';
$consultationPrice = $allSettings['service']['consultation_price'] ?? '99';
$consultationDuration = $allSettings['service']['consultation_duration'] ?? '30';

// 包含头部
include 'includes/header.php';
?>

    <main>
        <!-- 首页区域 -->
        <section id="home" class="hero">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo htmlspecialchars($siteTitle); ?></h1>
                <p class="hero-subtitle"><?php echo htmlspecialchars($siteSubtitle); ?></p>
                <div class="floating-cards">
                    <div class="card">🌙</div>
                    <div class="card">⭐</div>
                    <div class="card">🔮</div>
                </div>
                <div class="cta-buttons">
                    <a href="#divination" class="cta-button">快速占卜</a>
                    <a href="spreads.php" class="cta-button cta-secondary">选择牌阵</a>
                    <a href="draw_cards.php" class="cta-button">互动抽牌</a>
                </div>
            </div>
        </section>

        <!-- 占卜区域 -->
        <section id="divination" class="divination-section">
            <div class="container">
                <h2>🔮 塔罗占卜</h2>
                <p class="section-subtitle">选择您的占卜方式，让塔罗为您指引方向</p>
                
                <div class="divination-form">
                    <form id="divination-form">
                        <div class="form-group">
                            <label for="user_name">姓名 *</label>
                            <input type="text" id="user_name" name="user_name"  placeholder="请输入您的姓名" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="user_qq">QQ号 *</label>
                            <input type="text" id="user_qq" name="user_qq" placeholder="请输入您的QQ号" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="user_wechat">微信号</label>
                            <input type="text" id="user_wechat" name="user_wechat" placeholder="请输入您的微信号">
                        </div>
                        
                        <div class="form-group">
                            <label for="spread_type">占卜方式 *</label>
                            <select id="spread_type" name="spread_type" required>
                            <option value="">请选择占卜方式</option>
                            <option value="single">单牌占卜 - 简单问题指引</option>
                            <option value="three">三牌占卜 - 过去现在未来</option>
                            <option value="love">爱情占卜 - 感情问题专用</option>
                            <option value="career">事业占卜 - 职场发展指导</option>
                            <option value="celtic_cross">凯尔特十字 - 全面深度分析</option>
                            <option value="relationship">关系占卜 - 人际关系解读</option>
                            <option value="decision">决策占卜 - 选择困难指导</option>
                            <option value="year_forecast">年运占卜 - 全年运势预测</option>
                            <option value="chakra">脉轮占卜 - 能量平衡检测</option>
                            <option value="moon_cycle">月相占卜 - 月亮能量指引</option>
                            <option value="element">四元素占卜 - 平衡状态分析</option>
                            <option value="spiritual">灵性占卜 - 心灵成长指导</option>
                        </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="question">您的问题 *</label>
                            <textarea id="question" name="question" rows="4" placeholder="请详细描述您想要咨询的问题..." required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">开始占卜</button>
                    </form>
                </div>

                <!-- 占卜结果显示区域 -->
                <div id="divination-result" class="result-section" style="display: none;">
                    <h3>🔮 您的塔罗占卜结果</h3>
                    
                    <div id="cards-display" class="cards-container">
                        <!-- 动态生成卡牌显示 -->
                    </div>
                    
                    <div id="interpretation" class="interpretation-container">
                        <!-- 动态生成解读内容 -->
                    </div>
                    

                </div>
            </div>
        </section>

        <!-- 关于塔罗区域 -->
        <section id="about" class="about-section">
            <div class="container">
                <h2>🌟 关于塔罗</h2>
                <div class="about-content">
                    <div class="about-text">
                        <h3>塔罗牌的神秘力量</h3>
                        <p>塔罗牌是一种古老的占卜工具，起源于15世纪的欧洲。它由78张牌组成，分为大阿卡纳（22张）和小阿卡纳（56张）。每张牌都蕴含着深刻的象征意义和智慧。</p>
                        
                        <h3>🎯 我们的服务</h3>
                        <div class="services-container">
                            <div class="service-card-wrapper">
                                <div class="service-card-modern">
                                    <div class="service-icon">🔮</div>
                                    <h4>塔罗占卜服务</h4>
                                    <div class="service-features">
                                        <div class="feature-item">
                                            <span class="feature-icon">✨</span>
                                            <span>专业塔罗牌占卜</span>
                                        </div>
                                        <div class="feature-item">
                                            <span class="feature-icon">📝</span>
                                            <span>详细牌面解读</span>
                                        </div>
                                        <div class="feature-item">
                                            <span class="feature-icon">🔮</span>
                                            <span>人生指引方向</span>
                                        </div>
                                        <div class="feature-item">
                                            <span class="feature-icon">💡</span>
                                            <span>实用建议提示</span>
                                        </div>
                                        <div class="feature-item">
                                            <span class="feature-icon">👨‍🏫</span>
                                            <span>专业占卜师咨询</span>
                                        </div>
                                    </div>
                                    <p class="service-description-text"><?php echo htmlspecialchars($serviceDesc); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <h3>📋 占卜流程说明</h3>
                        <div class="process-steps">
                            <div class="step">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h4>🔮 在线占卜</h4>
                                    <p>填写基本信息，选择占卜方式，立即获得专业的塔罗占卜解读。每张牌都会显示详细含义和指引建议。</p>
                                </div>
                            </div>
                            <div class="step">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h4>🔮 联系专业占卜师</h4>
                                    <p>如需更深入的个人指导，可联系我们的专业占卜师团队，获得一对一的深度咨询服务。</p>
                                </div>
                            </div>
                        </div>
                        
                        <h3>💫 为什么选择我们</h3>
                        <ul class="features-list">
                            <li>💎 <strong>专业团队</strong> - 经验丰富的占卜师团队</li>
                            <li>🔮 <strong>多种占卜</strong> - 单牌、三牌、爱情、事业专项</li>
                            <li>🌟 <strong>即时服务</strong> - 在线占卜，即时获得结果</li>
                            <li>👨‍🏫 <strong>深度咨询</strong> - 专业占卜师一对一指导</li>
                            <li>🛡️ <strong>隐私保护</strong> - 严格保护用户隐私信息</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 联系我们区域 -->
        <section id="contact" class="contact-section">
            <div class="container">
                <h2>🌙 联系我们</h2>
                <p class="section-subtitle">需要更深入的指导？我们的专业占卜师团队为您服务</p>
                
                <div class="contact-content">
                    <div class="contact-info">
                        <h3>🔮 专业占卜师服务</h3>
                        <ul>
                            <li>📱 微信咨询：<?php echo htmlspecialchars($contactWechat); ?></li>
                            <li>💬 QQ咨询：<?php echo htmlspecialchars($contactQQ); ?></li>
                            <li>⏰ 服务时间：<?php echo htmlspecialchars($serviceHours); ?></li>
                            <li>💰 咨询价格：<?php echo htmlspecialchars($consultationPrice); ?>元/<?php echo htmlspecialchars($consultationDuration); ?>分钟</li>
                        </ul>
                        
                        <h3>🌟 深度咨询包含</h3>
                        <ul>
                            <li>✨ 个人命盘分析</li>
                            <li>🎯 具体问题深度解答</li>
                            <li>💡 人生规划建议</li>
                            <li>🔮 后续指导跟进</li>
                        </ul>
                        
                        <h3>📞 联系方式</h3>
                        <div class="contact-methods">
                            <div class="contact-method">
                                <span class="method-icon">💬</span>
                                <div class="method-info">
                                    <h4>在线咨询</h4>
                                    <p>通过下方表单留言，我们会在24小时内回复</p>
                                </div>
                            </div>
                            <div class="contact-method">
                                <span class="method-icon">📱</span>
                                <div class="method-info">
                                    <h4>微信咨询</h4>
                                    <p>添加微信号：<?php echo htmlspecialchars($contactWechat); ?>，获得即时回复</p>
                                </div>
                            </div>
                            <div class="contact-method">
                                <span class="method-icon">💬</span>
                                <div class="method-info">
                                    <h4>QQ咨询</h4>
                                    <p>添加QQ号：<?php echo htmlspecialchars($contactQQ); ?>，获得专业指导</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-form">
                        <h3>💌 留言咨询</h3>
                        <form id="contact-form">
                            <div class="form-group">
                                <label for="contact_name">姓名 *</label>
                                <input type="text" id="contact_name" name="name" placeholder="请输入您的姓名" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_qq">QQ号 *</label>
                                <input type="text" id="contact_qq" name="qq" placeholder="请输入您的QQ号" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_wechat">微信号</label>
                                <input type="text" id="contact_wechat" name="wechat" placeholder="请输入您的微信号">
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_message">咨询内容 *</label>
                                <textarea id="contact_message" name="message" rows="5" placeholder="请描述您希望咨询的问题，我们会尽快回复您..." required></textarea>
                            </div>
                            
                            <button type="submit">发送咨询</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
// 包含底部
include 'includes/footer.php';
?>