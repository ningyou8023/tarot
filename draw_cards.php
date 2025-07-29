<?php
// 包含头部
include 'includes/header.php';

// 获取牌阵参数
$spreadType = isset($_GET['spread']) ? $_GET['spread'] : '';
$cardCount = isset($_GET['cards']) ? intval($_GET['cards']) : 0;
$spreadName = isset($_GET['name']) ? urldecode($_GET['name']) : '';

// 牌阵配置
$spreadConfigs = [
    'single' => [
        'name' => '单张牌占卜',
        'description' => '抽取一张牌做判断，简单易懂，擅长是非题',
        'positions' => ['核心指引']
    ],
    'three' => [
        'name' => '三张牌占卜法',
        'description' => '通用型占卜牌阵，分析事情的过去、现在和未来',
        'positions' => ['过去/原因', '现在/状况', '未来/结果']
    ],
    'five' => [
        'name' => '五张牌占卜法',
        'description' => '深度分析，适合复杂问题的全面解读',
        'positions' => ['过去影响', '现在状况', '未来趋势', '行动建议', '最终结果']
    ],
    'timeflow' => [
        'name' => '时间流牌阵',
        'description' => '平行流向的时间解析法，从过去延伸到未来',
        'positions' => ['过去', '现在', '未来']
    ],
    'holy_triangle' => [
        'name' => '圣三角牌阵',
        'description' => '梳理问题前因后果，注重事物内在原因',
        'positions' => ['问题根源', '当前状况', '解决方向']
    ],
    'core' => [
        'name' => '直指核心牌阵',
        'description' => '直接指向问题核心，快速找到关键所在',
        'positions' => ['问题核心']
    ],
    'body_mind_spirit' => [
        'name' => '身心灵牌阵',
        'description' => '从灵性、心理、身体三方面透彻审视自我',
        'positions' => ['身体状况', '心理状态', '灵性指引']
    ],
    'four_elements' => [
        'name' => '四元素牌阵',
        'description' => '从感性、理性、物质、行动四方面透彻审视',
        'positions' => ['火元素(行动)', '水元素(情感)', '风元素(思维)', '土元素(物质)']
    ],
    'self_exploration' => [
        'name' => '自我探索牌阵',
        'description' => '深入探索内在世界，寻找人生方向和答案',
        'positions' => ['内在自我', '外在表现', '潜在能力', '成长方向', '人生使命']
    ],
    'love_pyramid' => [
        'name' => '恋人金字塔',
        'description' => '涵盖两人相恋原始要素，适合恋人情侣间的占卜',
        'positions' => ['你的感受', '对方感受', '关系基础', '发展趋势', '最终结果']
    ],
    'love_star' => [
        'name' => '爱之星牌阵',
        'description' => '深入分析爱情关系的各个方面',
        'positions' => ['关系核心', '你的内心', '对方内心', '关系障碍', '外在影响', '行动建议', '未来发展']
    ],
    'relationship_tree' => [
        'name' => '恋人之树牌阵',
        'description' => '展现关系的根基、现状和未来发展',
        'positions' => ['关系根基', '过去经历', '现在状况', '成长方向', '未来发展', '最终结果']
    ],
    'career_pyramid' => [
        'name' => '事业金字塔阵',
        'description' => '全面分析事业发展的各个层面',
        'positions' => ['当前状况', '个人能力', '外在机会', '发展方向', '成功关键']
    ],
    'wealth' => [
        'name' => '财富牌阵',
        'description' => '分析财运趋势和投资机会',
        'positions' => ['财运基础', '当前状况', '投资机会', '财富增长']
    ],
    'job_interview' => [
        'name' => '求职面试牌阵',
        'description' => '分析求职成功率和面试表现建议',
        'positions' => ['个人优势', '面试表现', '成功机率']
    ],
    'two_choice' => [
        'name' => '二选一牌阵',
        'description' => '分析两个选择的优劣，做出最佳决定',
        'positions' => ['选择A优势', '选择A劣势', '选择B优势', '选择B劣势']
    ],
    'three_choice' => [
        'name' => '三选一牌阵',
        'description' => '全面分析三个方案的特点和结果',
        'positions' => ['选择A结果', '选择A影响', '选择B结果', '选择B影响', '选择C结果', '选择C影响']
    ],
    'problem_solving' => [
        'name' => '问题解决牌阵',
        'description' => '分析问题根源并提供解决方案',
        'positions' => ['问题根源', '当前障碍', '可用资源', '行动方案', '最终结果']
    ]
];

$currentSpread = isset($spreadConfigs[$spreadType]) ? $spreadConfigs[$spreadType] : null;
?>
<body>
    <div class="draw-container">
        <!-- 进度指示器 -->
        <div class="progress-indicator">
            <div class="progress-step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">填写信息</div>
            </div>
            <?php if (!$currentSpread): ?>
            <div class="progress-line"></div>
            <div class="progress-step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">选择牌数</div>
            </div>
            <?php else: ?>
            <div class="progress-line"></div>
            <div class="progress-step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label"><?php echo $currentSpread['name']; ?></div>
            </div>
            <?php endif; ?>
            <div class="progress-line"></div>
            <div class="progress-step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">抽取卡牌</div>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step" data-step="4">
                <div class="step-number">4</div>
                <div class="step-label">查看结果</div>
            </div>
        </div>

        <div class="draw-header">
            <h1 id="pageTitle">🔮 <?php echo $currentSpread ? $currentSpread['name'] : '互动抽牌占卜'; ?></h1>
            <p id="pageSubtitle"><?php echo $currentSpread ? $currentSpread['description'] : '在神秘的塔罗牌中寻找答案，让直觉引导您选择属于您的卡牌'; ?></p>
            <?php if ($currentSpread): ?>
            <div class="spread-info">
                <span class="spread-badge">🎯 <?php echo count($currentSpread['positions']); ?>张牌占卜</span>
                <a href="spreads.php" class="change-spread-btn">更换牌阵</a>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- 步骤1: 设置表单 -->
        <div id="step1" class="step-content active">
            <div class="setup-form">
                <h3 class="step-title">📝 请填写您的基本信息</h3>
                <div class="form-group">
                    <label for="user_name">您的姓名 *</label>
                    <input type="text" id="user_name" name="user_name" placeholder="请输入您的姓名" required>
                </div>
                
                <div class="form-group">
                    <label for="user_qq">QQ号 *</label>
                    <input type="text" id="user_qq" name="user_qq" placeholder="请输入您的QQ号" required>
                </div>
                
                <div class="form-group">
                    <label for="user_wechat">微信号 *</label>
                    <input type="text" id="user_wechat" name="user_wechat" placeholder="请输入您的微信号" required>
                </div>
                
                <div class="form-group">
                    <label for="question">您的问题 *</label>
                    <textarea id="question" name="question" rows="4" placeholder="请详细描述您想要咨询的问题，越具体越能得到准确的指引..." required></textarea>
                </div>
                
                <div class="step-actions">
                    <button type="button" class="btn btn-primary" onclick="goToStep(2)">下一步</button>
                </div>
            </div>
        </div>
        
        <!-- 步骤2: 选择抽牌数量或显示牌阵信息 -->
        <div id="step2" class="step-content">
            <div class="setup-form">
                <?php if ($currentSpread): ?>
                <!-- 显示选择的牌阵信息 -->
                <h3 class="step-title">🔮 <?php echo $currentSpread['name']; ?></h3>
                <p class="step-description"><?php echo $currentSpread['description']; ?></p>
                
                <div class="spread-positions">
                    <h4 class="positions-title">牌位含义：</h4>
                    <div class="positions-grid">
                        <?php foreach ($currentSpread['positions'] as $index => $position): ?>
                        <div class="position-item">
                            <span class="position-number"><?php echo $index + 1; ?></span>
                            <span class="position-name"><?php echo $position; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="step-actions">
                    <button type="button" class="btn btn-secondary" onclick="goToStep(1)">上一步</button>
                    <button type="button" class="btn btn-primary" onclick="goToStep(3)">
                        开始抽牌 →
                    </button>
                </div>
                
                <?php else: ?>
                <!-- 原有的选择牌数界面 -->
                <h3 class="step-title">🔮 选择您的占卜方式</h3>
                <p class="step-description">不同的牌数代表不同的占卜深度，请根据您的需求选择</p>
                
                <div class="card-count-selection">
                    <div class="count-option" onclick="selectCardCount(1)">
                        <div class="count-icon">🌟</div>
                        <h4>单张牌</h4>
                        <p>简单指引</p>
                        <span class="count-desc">适合日常决策和快速指引</span>
                    </div>
                    
                    <div class="count-option" onclick="selectCardCount(3)">
                        <div class="count-icon">⏳</div>
                        <h4>三张牌</h4>
                        <p>过去·现在·未来</p>
                        <span class="count-desc">了解事情的发展脉络</span>
                    </div>
                    
                    <div class="count-option" onclick="selectCardCount(5)">
                        <div class="count-icon">💝</div>
                        <h4>五张牌</h4>
                        <p>深度分析</p>
                        <span class="count-desc">适合感情、事业等重要问题</span>
                    </div>
                    
                    <div class="count-option" onclick="selectCardCount(7)">
                        <div class="count-icon">🌈</div>
                        <h4>七张牌</h4>
                        <p>全面解读</p>
                        <span class="count-desc">最全面的人生指引</span>
                    </div>
                </div>
                
                <div class="step-actions">
                    <button type="button" class="btn btn-secondary" onclick="goToStep(1)">上一步</button>
                    <button id="step2NextBtn" class="btn btn-primary" onclick="goToStep(3)" style="display: none;">
                        开始抽牌 →
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- 步骤3: 抽牌区域 -->
        <div id="step3" class="step-content">
            <div class="drawing-area">
                <div class="status-text" id="statusText">请从下方78张塔罗牌中选择您感觉有缘的卡牌</div>
                
                <div class="card-deck" id="cardDeck">
                    <!-- 78张卡牌背面 -->
                </div>
                
                <div class="drawn-cards" id="drawnCards">
                    <!-- 已抽取的卡牌将显示在这里 -->
                </div>
                
                <div class="step-actions">
                    <button type="button" class="btn btn-secondary" onclick="goToStep(2)">上一步</button>
                    <button type="button" class="btn btn-primary" id="finishBtn" onclick="performDivination()" disabled>完成占卜</button>
                </div>
            </div>
        </div>
        
        <!-- 步骤4: 结果显示区域 -->
        <div id="step4" class="step-content">
            <div class="result-section">
                <div id="resultContent">
                    <!-- 占卜结果将显示在这里 -->
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* 进度指示器样式 */
        .progress-indicator {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin: 2rem 0;
            padding: 0 2rem;
        }
        
        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
            min-width: 80px;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 215, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: rgba(255, 215, 0, 0.6);
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }
        
        .step-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            transition: all 0.3s ease;
            width: 100%;
            line-height: 1.2;
        }
        
        .progress-step.active .step-number {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            border-color: #ffd700;
            color: #1a1a2e;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }
        
        .progress-step.active .step-label {
            color: #ffd700;
            font-weight: bold;
        }
        
        .progress-step.completed .step-number {
            background: linear-gradient(45deg, #00ff88, #00cc6a);
            border-color: #00ff88;
            color: #1a1a2e;
        }
        
        .progress-step.completed .step-label {
            color: #00ff88;
        }
        
        .progress-line {
            flex: 1;
            height: 2px;
            background: rgba(255, 215, 0, 0.2);
            margin: 0 1rem;
            position: relative;
        }
        
        .progress-line.completed {
            background: linear-gradient(90deg, #00ff88, #ffd700);
        }
        
        /* 步骤内容样式 */
        .step-content {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .step-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .step-title {
            text-align: center;
            color: #ffd700;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .step-description {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .step-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        /* 牌阵信息样式 */
        .spread-info {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .spread-badge {
            background: rgba(255, 215, 0, 0.2);
            color: #ffd700;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }
        
        .change-spread-btn {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .change-spread-btn:hover {
            color: #ffd700;
            border-color: #ffd700;
            background: rgba(255, 215, 0, 0.1);
        }
        
        .spread-positions {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .positions-title {
            color: #ffd700;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }
        
        .positions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .position-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem;
            background: rgba(255, 215, 0, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }
        
        .position-number {
            width: 30px;
            height: 30px;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #1a1a2e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .position-name {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }
        
        /* 卡牌数量选择样式 */
        .card-count-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .count-option {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 15px;
            padding: 2rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .count-option:hover {
            border-color: #ffd700;
            background: rgba(255, 215, 0, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.2);
        }
        
        .count-option.selected {
            border-color: #ffd700;
            background: rgba(255, 215, 0, 0.15);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
        }
        
        .count-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .count-option h4 {
            color: #ffd700;
            margin: 0.5rem 0;
            font-size: 1.2rem;
        }
        
        .count-option p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0.5rem 0;
            font-weight: bold;
        }
        
        .count-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        /* 按钮样式 */
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #1a1a2e;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.4);
        }
        
        .btn-primary:disabled {
            background: rgba(255, 215, 0, 0.3);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-3px);
        }
        
        /* 已选择卡牌预览 */
        .selected-cards-preview {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
            min-height: 60px;
            align-items: center;
        }
        
        .preview-card {
            width: 40px;
            height: 60px;
            background: rgba(255, 215, 0, 0.2);
            border: 2px solid #ffd700;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        
        /* 响应式设计 */
        @media (max-width: 768px) {
            .progress-indicator {
                padding: 0 1rem;
            }
            
            .step-number {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .step-label {
                font-size: 0.7rem;
            }
            
            .progress-line {
                margin: 0 0.5rem;
            }
            
            .card-count-selection {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .count-option {
                padding: 1.5rem 1rem;
            }
            
            .count-icon {
                font-size: 2rem;
            }
            
            .step-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
    

    <script>
        let requiredCards = 0;
        let drawnCards = [];
        let allCards = [];
        let currentStep = 1;
        
        // 获取牌阵参数
        const urlParams = new URLSearchParams(window.location.search);
        const spreadType = urlParams.get('spread');
        const spreadCards = urlParams.get('cards');
        const spreadName = urlParams.get('name');
        const spreadDescription = '<?php echo $currentSpread ? addslashes($currentSpread["description"]) : ""; ?>';
        
        // 如果有牌阵参数，设置相应的卡牌数量
        if (spreadCards) {
            requiredCards = parseInt(spreadCards);
        }
        
        // 页面加载时初始化
        document.addEventListener('DOMContentLoaded', function() {
            generateCardDeck();
            updatePageContent();
            
            // 如果有牌阵参数，跳过步骤2的验证
            if (spreadType && requiredCards > 0) {
                // 修改验证逻辑，允许直接从步骤2跳到步骤3
                window.hasSpreadSelected = true;
            }
        });
        
        // 步骤导航函数
        function goToStep(step, skipAutoExecution = false) {
            // 验证步骤切换
            if (!validateStepTransition(currentStep, step)) {
                return;
            }
            
            // 隐藏当前步骤
            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
            
            // 标记已完成的步骤
            if (step > currentStep) {
                document.querySelector(`[data-step="${currentStep}"]`).classList.add('completed');
                // 更新进度线
                const progressLines = document.querySelectorAll('.progress-line');
                if (progressLines[currentStep - 1]) {
                    progressLines[currentStep - 1].classList.add('completed');
                }
            }
            
            // 显示新步骤
            currentStep = step;
            document.getElementById(`step${currentStep}`).classList.add('active');
            document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
            
            // 更新页面内容
            updatePageContent();
            
            // 特殊处理（只在非跳过模式下执行）
            if (!skipAutoExecution) {
                if (step === 3) {
                    initializeDrawingStep();
                } else if (step === 4) {
                    performDivination();
                }
            }
        }
        
        // 验证步骤切换
        function validateStepTransition(from, to) {
            switch(from) {
                case 1:
                    if (to === 2) {
                        const userName = document.getElementById('user_name').value.trim();
                        const userQQ = document.getElementById('user_qq').value.trim();
                        const userWechat = document.getElementById('user_wechat').value.trim();
                        const question = document.getElementById('question').value.trim();
                        
                        if (!userName || !userQQ || !userWechat || !question) {
                            alert('请填写所有必填项目（姓名、QQ号、微信号、问题）');
                            return false;
                        }
                    }
                    break;
                case 2:
                    if (to === 3) {
                        // 如果有牌阵参数或者已选择卡牌数量，允许继续
                        if (window.hasSpreadSelected || requiredCards > 0) {
                            return true;
                        }
                        alert('请先选择抽牌数量');
                        return false;
                    }
                    break;
                case 3:
                    if (to === 4 && drawnCards.length < requiredCards) {
                        alert('请先完成抽牌');
                        return false;
                    }
                    break;
            }
            return true;
        }
        
        // 更新页面内容
        function updatePageContent() {
            const hasSpread = spreadType && spreadName;
            
            const titles = {
                1: hasSpread ? `🔮 ${spreadName}` : '🔮 互动抽牌占卜',
                2: hasSpread ? `🔮 ${spreadName}` : '🔮 选择占卜方式',
                3: '✨ 抽取您的卡牌',
                4: '🌟 占卜结果解读'
            };
            
            const subtitles = {
                1: '在神秘的塔罗牌中寻找答案，让直觉引导您选择属于您的卡牌',
                2: hasSpread ? spreadDescription : '不同的牌数代表不同的占卜深度，请根据您的需求选择',
                3: '请静心感受，选择与您有缘的卡牌',
                4: '以下是您的专属占卜解读'
            };
            
            document.getElementById('pageTitle').textContent = titles[currentStep];
            document.getElementById('pageSubtitle').textContent = subtitles[currentStep];
        }
        
        // 选择卡牌数量
        function selectCardCount(count) {
            requiredCards = count;
            drawnCards = [];
            
            // 高亮选中的选项
            document.querySelectorAll('.count-option').forEach(option => {
                option.classList.remove('selected');
            });
            event.target.closest('.count-option').classList.add('selected');
            
            // 更新预览区域
            updateCardPreview();
            
            // 显示下一步按钮
            const nextBtn = document.getElementById('step2NextBtn');
            if (nextBtn) {
                nextBtn.style.display = 'block';
            }
        }
        
        // 更新卡牌预览
        function updateCardPreview() {
            const preview = document.getElementById('selectedCardsPreview');
            if (!preview) {
                // 如果预览元素不存在，跳过更新
                return;
            }
            
            preview.innerHTML = '';
            
            for (let i = 0; i < requiredCards; i++) {
                const previewCard = document.createElement('div');
                previewCard.className = 'preview-card';
                previewCard.innerHTML = i < drawnCards.length ? '✨' : '?';
                preview.appendChild(previewCard);
            }
        }
        
        // 初始化抽牌步骤
        function initializeDrawingStep() {
            updateCardPreview();
            updateStatusText();
            resetCardDeck();
        }
        
        // 原有的函数保持不变，但需要适配新的步骤系统
        function generateCardDeck() {
            const deck = document.getElementById('cardDeck');
            
            // 如果已经有卡牌，只重置状态而不重新创建DOM
            if (deck.children.length > 0) {
                resetCardDeck();
                return;
            }
            
            // 使用DocumentFragment减少DOM操作
            const fragment = document.createDocumentFragment();
            
            // 等待DOM更新后获取实际尺寸
            requestAnimationFrame(() => {
                const deckRect = deck.getBoundingClientRect();
                
                // 根据屏幕尺寸动态调整卡牌大小和间距
                const isMobile = window.innerWidth <= 768;
                const isSmallMobile = window.innerWidth <= 480;
                
                let cardWidth, cardHeight, startX, cardSpacing;
                
                if (isSmallMobile) {
                    cardWidth = 50;
                    cardHeight = 75;
                    startX = 10;
                    cardSpacing = 3.5;
                } else if (isMobile) {
                    cardWidth = 60;
                    cardHeight = 90;
                    startX = 15;
                    cardSpacing = 4.5;
                } else {
                    cardWidth = 80;
                    cardHeight = 120;
                    startX = 30;
                    cardSpacing = 7;
                }
                
                const startY = deckRect.height / 2 - cardHeight / 2 + 20; // 向下移动20px
                
                // 生成78张卡牌的背面
                for (let i = 0; i < 78; i++) {
                    const card = document.createElement('div');
                    card.className = 'card-back';
                    card.dataset.index = i;
                    card.onclick = () => selectCard(i);
                    
                    const cardFace = document.createElement('div');
                    cardFace.className = 'card-face';
                    card.appendChild(cardFace);
                    
                    const offsetX = i * cardSpacing;
                    const x = startX + offsetX;
                    const y = startY;
                    
                    card.style.transform = `translate(${x}px, ${y}px)`;
                    card.style.position = 'absolute';
                    card.style.zIndex = i;
                    card.style.width = cardWidth + 'px';
                    card.style.height = cardHeight + 'px';
                    
                    fragment.appendChild(card);
                }
                
                deck.appendChild(fragment);
            });
        }
        
        function resetCardDeck() {
            const cards = document.querySelectorAll('.card-back');
            
            requestAnimationFrame(() => {
                cards.forEach((card, index) => {
                    card.classList.remove('selected', 'drawn', 'flipped');
                    card.style.cssText = '';
                    card.style.pointerEvents = 'auto';
                    
                    const isMobile = window.innerWidth <= 768;
                    const isSmallMobile = window.innerWidth <= 480;
                    
                    let cardWidth, cardHeight, startX, cardSpacing;
                    
                    if (isSmallMobile) {
                        cardWidth = 50;
                        cardHeight = 75;
                        startX = 10;
                        cardSpacing = 3.5;
                    } else if (isMobile) {
                        cardWidth = 60;
                        cardHeight = 90;
                        startX = 15;
                        cardSpacing = 4.5;
                    } else {
                        cardWidth = 80;
                        cardHeight = 120;
                        startX = 30;
                        cardSpacing = 7;
                    }
                    
                    const deck = document.getElementById('cardDeck');
                    const deckRect = deck.getBoundingClientRect();
                    const startY = deckRect.height / 2 - cardHeight / 2 + 20; // 向下移动20px
                    
                    const offsetX = index * cardSpacing;
                    const x = startX + offsetX;
                    const y = startY;
                    
                    card.style.position = 'absolute';
                    card.style.width = cardWidth + 'px';
                    card.style.height = cardHeight + 'px';
                    card.style.transform = `translate(${x}px, ${y}px)`;
                    card.style.zIndex = index;
                    
                    const cardFace = card.querySelector('.card-face');
                    if (cardFace) {
                        cardFace.style.backgroundImage = '';
                    }
                });
                
                document.getElementById('drawnCards').innerHTML = '';
                document.getElementById('finishBtn').disabled = true;
            });
        }
        
        async function selectCard(index) {
            if (drawnCards.length >= requiredCards) {
                return;
            }
            
            const cardElement = document.querySelector(`[data-index="${index}"]`);
            if (!cardElement || cardElement.classList.contains('drawn') || cardElement.classList.contains('selected')) {
                return;
            }
            
            // 立即标记卡牌为已选择，防止重复点击和悬停效果
            cardElement.classList.add('selected');
            cardElement.style.pointerEvents = 'none';
            cardElement.style.cursor = 'default';
            
            try {
                // 获取随机卡牌数据
                const card = await fetchRandomCard();
                if (!card) {
                    // 如果获取失败，恢复卡牌状态
                    cardElement.classList.remove('selected');
                    cardElement.style.pointerEvents = 'auto';
                    cardElement.style.cursor = 'pointer';
                    return;
                }
                
                // 随机决定是否逆位
                card.reversed = Math.random() < 0.3;
                
                // 设置卡牌正面图片
                const cardFace = cardElement.querySelector('.card-face');
                const imagePath = getCardImagePath(card.name);
                cardFace.style.backgroundImage = `url('${imagePath}')`;
                
                // 翻牌动画
                setTimeout(() => {
                    cardElement.classList.add('flipped');
                    
                    // 翻牌完成后移动到下方
                    setTimeout(() => {
                        moveCardToDrawnArea(cardElement, card);
                    }, 600);
                }, 300);
                
            } catch (error) {
                console.error('选择卡牌时出错:', error);
                // 恢复卡牌状态
                cardElement.classList.remove('selected');
                cardElement.style.pointerEvents = 'auto';
                cardElement.style.cursor = 'pointer';
            }
        }
        

        
        function moveCardToDrawnArea(cardElement, card) {
            // 添加到已抽取列表
            drawnCards.push(card);
            
            // 优化动画性能
            cardElement.style.willChange = 'transform, opacity';
            
            // 创建移动动画
            const rect = cardElement.getBoundingClientRect();
            const drawnArea = document.getElementById('drawnCards');
            const drawnRect = drawnArea.getBoundingClientRect();
            
            // 计算移动距离
            const deltaX = drawnRect.left + (drawnCards.length - 1) * 120 - rect.left;
            const deltaY = drawnRect.top - rect.top;
            
            // 应用移动动画
            requestAnimationFrame(() => {
                cardElement.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(0.8)`;
                cardElement.style.zIndex = '1000';
                cardElement.style.transition = 'transform 0.6s ease-out, opacity 0.6s ease-out';
                
                // 动画完成后处理
                setTimeout(() => {
                    cardElement.classList.add('drawn');
                    cardElement.style.display = 'none';
                    cardElement.style.willChange = 'auto'; // 清除will-change
                    
                    // 在下方区域显示卡牌
                    displayDrawnCard(card);
                    updateStatusText();
                    
                    if (drawnCards.length >= requiredCards) {
                        document.getElementById('finishBtn').disabled = false;
                        setTimeout(() => {
                            goToStep(4);
                        }, 1000);
                    }
                }, 600);
            });
        }
        
        function displayDrawnCard(cardData) {
            const drawnCardsContainer = document.getElementById('drawnCards');
            
            const drawnCard = document.createElement('div');
            drawnCard.className = 'drawn-card';
            
            // 创建卡牌图片
            const cardImage = document.createElement('img');
            cardImage.src = getCardImagePath(cardData.name);
            cardImage.alt = cardData.name;
            cardImage.style.cssText = `
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 8px;
                ${cardData.reversed ? 'transform: rotate(180deg);' : ''}
            `;
            
            // 创建卡牌信息覆盖层
            const cardInfo = document.createElement('div');
            cardInfo.style.cssText = `
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0,0,0,0.8));
                color: white;
                padding: 5px;
                font-size: 12px;
                text-align: center;
                border-radius: 0 0 8px 8px;
            `;
            cardInfo.innerHTML = `
                <div>${cardData.name}</div>
                <div style="font-size: 10px; color: ${cardData.reversed ? '#ff6b6b' : '#4ecdc4'};">
                    ${cardData.reversed ? '逆位' : '正位'}
                </div>
            `;
            
            drawnCard.appendChild(cardImage);
            drawnCard.appendChild(cardInfo);
            drawnCardsContainer.appendChild(drawnCard);
        }
        
        async function fetchRandomCard() {
            try {
                const response = await fetch('api/get_random_card.php');
                const data = await response.json();
                return data.success ? data.card : null;
            } catch (error) {
                console.error('获取卡牌失败:', error);
                return null;
            }
        }
        
        function displayDrawnCard(cardData) {
            const drawnCardsContainer = document.getElementById('drawnCards');
            
            const drawnCard = document.createElement('div');
            drawnCard.className = 'drawn-card';
            
            // 创建卡牌图片
            const cardImage = document.createElement('img');
            cardImage.src = getCardImagePath(cardData.name);
            cardImage.alt = cardData.name;
            cardImage.style.cssText = `
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 8px;
                ${cardData.reversed ? 'transform: rotate(180deg);' : ''}
            `;
            
            // 创建卡牌信息覆盖层
            const cardInfo = document.createElement('div');
            cardInfo.style.cssText = `
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0,0,0,0.8));
                color: white;
                padding: 5px;
                font-size: 12px;
                text-align: center;
                border-radius: 0 0 8px 8px;
            `;
            cardInfo.innerHTML = `
                <div>${cardData.name}</div>
                <div style="font-size: 10px; color: ${cardData.reversed ? '#ff6b6b' : '#4ecdc4'};">
                    ${cardData.reversed ? '逆位' : '正位'}
                </div>
            `;
            
            drawnCard.appendChild(cardImage);
            drawnCard.appendChild(cardInfo);
            drawnCardsContainer.appendChild(drawnCard);
        }
        
        function updateStatusText() {
            const statusText = document.getElementById('statusText');
            const remaining = requiredCards - drawnCards.length;
            
            if (remaining > 0) {
                statusText.textContent = `请继续选择 ${remaining} 张卡牌`;
            } else {
                statusText.textContent = '已完成抽牌，正在为您解读...';
            }
        }
        
        let isPerformingDivination = false; // 防止重复请求的标志
        
        async function performDivination() {
            if (drawnCards.length < requiredCards) {
                alert('请先完成抽牌');
                return;
            }
            
            // 防止重复请求
            if (isPerformingDivination) {
                return;
            }
            
            isPerformingDivination = true;
            
            // 根据牌阵参数或抽牌数量确定占卜类型
            let spreadTypeToUse = '';
            if (spreadType) {
                spreadTypeToUse = spreadType;
            } else {
                switch(requiredCards) {
                    case 1:
                        spreadTypeToUse = 'single';
                        break;
                    case 3:
                        spreadTypeToUse = 'three';
                        break;
                    case 5:
                        spreadTypeToUse = 'love';
                        break;
                    case 7:
                        spreadTypeToUse = 'chakra';
                        break;
                    default:
                        spreadTypeToUse = 'single';
                }
            }
            
            const formData = new FormData();
            formData.append('user_name', document.getElementById('user_name').value);
            formData.append('user_qq', document.getElementById('user_qq').value);
            formData.append('user_wechat', document.getElementById('user_wechat').value);
            formData.append('spread_type', spreadTypeToUse);
            formData.append('question', document.getElementById('question').value);
            formData.append('selected_cards', JSON.stringify(drawnCards));
            
            // 如果有牌阵信息，添加到请求中
            if (spreadName) {
                formData.append('spread_name', spreadName);
            }
            
            try {
                const response = await fetch('api/divination.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    displayResult(result.data);
                } else {
                    alert('占卜失败: ' + (result.message || '未知错误'));
                    isPerformingDivination = false; // 重置标志
                }
            } catch (error) {
                console.error('占卜请求失败:', error);
                alert('占卜请求失败，请稍后重试');
                isPerformingDivination = false; // 重置标志
            }
        }
        
        function displayResult(result) {
            const resultContent = document.getElementById('resultContent');
            
            // 获取用户输入的问题
            const userQuestion = document.getElementById('question').value || result.question || '您的问题';
            
            let html = `
                <div class="divination-result">
                    <div class="result-header">
                        <h3>🌟 您的塔罗占卜结果</h3>
                        <p class="question-display">解读我的问题：${userQuestion}</p>
                    </div>
                    
                    <div class="cards-display">
                        <h4>抽取的卡牌：</h4>
                        <div class="result-cards">
            `;
            
            result.cards.forEach((card, index) => {
                const reversedText = card.reversed ? ' (逆位)' : '';
                html += `
                    <div class="result-card">
                        <img src="${getCardImagePath(card.name)}" alt="${card.name}" 
                             class="card-image ${card.reversed ? 'reversed' : ''}">
                        <div class="card-info">
                            <h5>${card.name}${reversedText}</h5>
                            <p class="card-meaning">${card.meaning || '神秘的力量指引着您'}</p>
                        </div>
                    </div>
                `;
            });
            
            html += `
                        </div>
                    </div>
                    
                    <div class="interpretation-section basic-interpretation">
                        <h4>🔮 占卜解读</h4>
                        <div class="interpretation-content">
                            ${result.interpretation}
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button onclick="resetDrawing()" class="btn btn-primary">
                            🔄 重新占卜
                        </button>
                        <button onclick="window.location.href='index.php'" class="btn btn-secondary">
                            🏠 返回首页
                        </button>
                    </div>
                </div>
            `;
            
            resultContent.innerHTML = html;
            
            // 重置防重复请求标志
            isPerformingDivination = false;
            
            // 切换到结果步骤，但不再调用performDivination
            goToStep(4, true); // 添加参数表示跳过自动执行
        }
        
        function getCardImagePath(cardName) {
            // 卡牌名称到文件名的映射
            const cardMapping = {
                // 大阿卡纳
                '愚者': 'major_00_fool.svg',
                '魔术师': 'major_01_magician.svg',
                '女祭司': 'major_02_high_priestess.svg',
                '皇后': 'major_03_empress.svg',
                '皇帝': 'major_04_emperor.svg',
                '教皇': 'major_05_hierophant.svg',
                '恋人': 'major_06_lovers.svg',
                '战车': 'major_07_chariot.svg',
                '力量': 'major_08_strength.svg',
                '隐者': 'major_09_hermit.svg',
                '命运之轮': 'major_10_wheel_of_fortune.svg',
                '正义': 'major_11_justice.svg',
                '倒吊人': 'major_12_hanged_man.svg',
                '死神': 'major_13_death.svg',
                '节制': 'major_14_temperance.svg',
                '恶魔': 'major_15_devil.svg',
                '塔': 'major_16_tower.svg',
                '星星': 'major_17_star.svg',
                '月亮': 'major_18_moon.svg',
                '太阳': 'major_19_sun.svg',
                '审判': 'major_20_judgement.svg',
                '世界': 'major_21_world.svg',
                
                // 权杖牌组
                '权杖王牌': 'wands_01_ace.svg',
                '权杖二': 'wands_02.svg',
                '权杖三': 'wands_03.svg',
                '权杖四': 'wands_04.svg',
                '权杖五': 'wands_05.svg',
                '权杖六': 'wands_06.svg',
                '权杖七': 'wands_07.svg',
                '权杖八': 'wands_08.svg',
                '权杖九': 'wands_09.svg',
                '权杖十': 'wands_10.svg',
                '权杖侍从': 'wands_page.svg',
                '权杖骑士': 'wands_knight.svg',
                '权杖王后': 'wands_queen.svg',
                '权杖国王': 'wands_king.svg',
                
                // 圣杯牌组
                '圣杯王牌': 'cups_01_ace.svg',
                '圣杯二': 'cups_02.svg',
                '圣杯三': 'cups_03.svg',
                '圣杯四': 'cups_04.svg',
                '圣杯五': 'cups_05.svg',
                '圣杯六': 'cups_06.svg',
                '圣杯七': 'cups_07.svg',
                '圣杯八': 'cups_08.svg',
                '圣杯九': 'cups_09.svg',
                '圣杯十': 'cups_10.svg',
                '圣杯侍从': 'cups_page.svg',
                '圣杯骑士': 'cups_knight.svg',
                '圣杯王后': 'cups_queen.svg',
                '圣杯国王': 'cups_king.svg',
                
                // 宝剑牌组
                '宝剑王牌': 'swords_01_ace.svg',
                '宝剑二': 'swords_02.svg',
                '宝剑三': 'swords_03.svg',
                '宝剑四': 'swords_04.svg',
                '宝剑五': 'swords_05.svg',
                '宝剑六': 'swords_06.svg',
                '宝剑七': 'swords_07.svg',
                '宝剑八': 'swords_08.svg',
                '宝剑九': 'swords_09.svg',
                '宝剑十': 'swords_10.svg',
                '宝剑侍从': 'swords_page.svg',
                '宝剑骑士': 'swords_knight.svg',
                '宝剑王后': 'swords_queen.svg',
                '宝剑国王': 'swords_king.svg',
                
                // 金币牌组
                '金币王牌': 'pentacles_01_ace.svg',
                '金币二': 'pentacles_02.svg',
                '金币三': 'pentacles_03.svg',
                '金币四': 'pentacles_04.svg',
                '金币五': 'pentacles_05.svg',
                '金币六': 'pentacles_06.svg',
                '金币七': 'pentacles_07.svg',
                '金币八': 'pentacles_08.svg',
                '金币九': 'pentacles_09.svg',
                '金币十': 'pentacles_10.svg',
                '金币侍从': 'pentacles_page.svg',
                '金币骑士': 'pentacles_knight.svg',
                '金币王后': 'pentacles_queen.svg',
                '金币国王': 'pentacles_king.svg'
            };
            
            const fileName = cardMapping[cardName];
            if (!fileName) {
                console.warn(`未找到卡牌图片映射: ${cardName}`);
                return 'images/card_back.svg';
            }
            return `images/${fileName}`;
        }
        
        function resetDrawing() {
            drawnCards = [];
            requiredCards = 0;
            currentStep = 1;
            
            // 重置所有步骤状态
            document.querySelectorAll('.step-content').forEach(step => {
                step.classList.remove('active');
            });
            document.querySelectorAll('.progress-step').forEach(step => {
                step.classList.remove('active', 'completed');
            });
            document.querySelectorAll('.progress-line').forEach(line => {
                line.classList.remove('completed');
            });
            
            // 显示第一步
            document.getElementById('step1').classList.add('active');
            document.querySelector('[data-step="1"]').classList.add('active');
            
            // 清空表单
            document.getElementById('user_name').value = '';
            document.getElementById('user_qq').value = '';
            document.getElementById('user_wechat').value = '';
            document.getElementById('question').value = '';
            
            // 重置卡牌选择状态
            document.querySelectorAll('.count-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // 隐藏步骤2的下一步按钮
            const step2NextBtn = document.getElementById('step2NextBtn');
            if (step2NextBtn) {
                step2NextBtn.style.display = 'none';
            }
            
            // 重置卡牌状态
            resetCardDeck();
            
            // 更新页面内容
            updatePageContent();
        }
    </script>

<?php
// 包含底部
include 'includes/footer.php';
?>