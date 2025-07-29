<?php
// 包含头部
include 'includes/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">🔮 塔罗牌阵大全</h1>
        <p class="page-subtitle">选择适合您问题的占卜牌阵，获得更精准的指引</p>
    </div>

    <div class="spreads-grid">
        <!-- 基础牌阵 -->
        <div class="spread-category">
            <h2 class="category-title">✨ 基础牌阵</h2>
            <div class="spreads-row">
                <div class="spread-card" onclick="selectSpread('single')">
                    <div class="spread-icon">🎯</div>
                    <h3>单张牌占卜</h3>
                    <p class="spread-subtitle">适合是非判断 & 单日运程</p>
                    <p class="spread-desc">抽取一张牌做判断，简单易懂，擅长是非题。每天清晨想知道自己一天运势的时候，抽张塔罗牌是不错的选择。</p>
                    <div class="spread-tags">
                        <span class="tag">初学者适用</span>
                        <span class="tag">日常占卜</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('three')">
                    <div class="spread-icon">🔱</div>
                    <h3>三张牌占卜法</h3>
                    <p class="spread-subtitle">适合综合分析 & 单事解析</p>
                    <p class="spread-desc">通用型占卜牌阵，可以自由定义应用在很多场合，不受约束的占卜相关事物或用来分析独立事情的某个方面。</p>
                    <div class="spread-tags">
                        <span class="tag">万能型</span>
                        <span class="tag">初学者适用</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('five')">
                    <div class="spread-icon">⭐</div>
                    <h3>五张牌占卜法</h3>
                    <p class="spread-subtitle">适合综合分析 & 深度解析</p>
                    <p class="spread-desc">通用型占卜牌阵，不设定具体位置意涵，较三张牌更深入具体，适合较复杂的占卜。</p>
                    <div class="spread-tags">
                        <span class="tag">深度分析</span>
                        <span class="tag">复杂问题</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 时间型牌阵 -->
        <div class="spread-category">
            <h2 class="category-title">⏰ 时间型牌阵</h2>
            <div class="spreads-row">
                <div class="spread-card" onclick="selectSpread('timeflow')">
                    <div class="spread-icon">🌊</div>
                    <h3>时间流牌阵</h3>
                    <p class="spread-subtitle">适合预测未来 & 窥探未知</p>
                    <p class="spread-desc">平行流向的时间解析法，纯粹的时间流向应用于空间维度上的时间占卜，恍若流淌的时间从过去延伸到未来。</p>
                    <div class="spread-tags">
                        <span class="tag">预测未来</span>
                        <span class="tag">时间指向</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('holy_triangle')">
                    <div class="spread-icon">🔺</div>
                    <h3>圣三角牌阵</h3>
                    <p class="spread-subtitle">适合判断情势 & 寻找成因</p>
                    <p class="spread-desc">梳理问题前因后果，是时间流的变形，更注重事物内在原因，而非单纯时间流向。</p>
                    <div class="spread-tags">
                        <span class="tag">因果分析</span>
                        <span class="tag">情势判断</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('core')">
                    <div class="spread-icon">🎯</div>
                    <h3>直指核心牌阵</h3>
                    <p class="spread-subtitle">适合问题探索 & 切中要害</p>
                    <p class="spread-desc">直接指向问题核心，快速找到关键所在，适合需要明确答案的占卜。</p>
                    <div class="spread-tags">
                        <span class="tag">核心问题</span>
                        <span class="tag">快速解答</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 自我探索牌阵 -->
        <div class="spread-category">
            <h2 class="category-title">🧘 自我探索牌阵</h2>
            <div class="spreads-row">
                <div class="spread-card" onclick="selectSpread('body_mind_spirit')">
                    <div class="spread-icon">🕉️</div>
                    <h3>身心灵牌阵</h3>
                    <p class="spread-subtitle">适合自我探索 & 了解自己</p>
                    <p class="spread-desc">通过身心灵可以很好的了解自身状况，从灵性、心理、身体三方面透彻审视自我。</p>
                    <div class="spread-tags">
                        <span class="tag">自我认知</span>
                        <span class="tag">内在探索</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('four_elements')">
                    <div class="spread-icon">🌍</div>
                    <h3>四元素牌阵</h3>
                    <p class="spread-subtitle">适合问题探索 & 多方解析</p>
                    <p class="spread-desc">通过四元素了解问题多方面的状况，从感性、理性、物质、行动四方面透彻审视。</p>
                    <div class="spread-tags">
                        <span class="tag">多角度分析</span>
                        <span class="tag">全面了解</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('self_exploration')">
                    <div class="spread-icon">🔍</div>
                    <h3>自我探索牌阵</h3>
                    <p class="spread-subtitle">适合深度自省 & 人生指导</p>
                    <p class="spread-desc">在某些处境中认清自己，深入探索内在世界，寻找人生方向和答案。</p>
                    <div class="spread-tags">
                        <span class="tag">深度自省</span>
                        <span class="tag">人生指导</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 爱情牌阵 -->
        <div class="spread-category">
            <h2 class="category-title">💕 爱情牌阵</h2>
            <div class="spreads-row">
                <div class="spread-card" onclick="selectSpread('love_pyramid')">
                    <div class="spread-icon">💎</div>
                    <h3>恋人金字塔</h3>
                    <p class="spread-subtitle">适合占卜恋人关系 & 互动解析</p>
                    <p class="spread-desc">简洁直接，涵盖两人相恋原始要素，适合恋人情侣间的占卜，牌面一出明了易懂。</p>
                    <div class="spread-tags">
                        <span class="tag">恋爱关系</span>
                        <span class="tag">情侣占卜</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('love_star')">
                    <div class="spread-icon">⭐</div>
                    <h3>爱之星牌阵</h3>
                    <p class="spread-subtitle">适合深度情感分析</p>
                    <p class="spread-desc">深入分析爱情关系的各个方面，包括感情基础、发展趋势、障碍和建议。</p>
                    <div class="spread-tags">
                        <span class="tag">深度分析</span>
                        <span class="tag">情感指导</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('relationship_tree')">
                    <div class="spread-icon">🌳</div>
                    <h3>恋人之树牌阵</h3>
                    <p class="spread-subtitle">适合关系发展 & 未来展望</p>
                    <p class="spread-desc">像树一样展现关系的根基、现状和未来发展，适合长期关系的占卜。</p>
                    <div class="spread-tags">
                        <span class="tag">关系发展</span>
                        <span class="tag">未来展望</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 事业牌阵 -->
        <div class="spread-category">
            <h2 class="category-title">💼 事业牌阵</h2>
            <div class="spreads-row">
                <div class="spread-card" onclick="selectSpread('career_pyramid')">
                    <div class="spread-icon">🏢</div>
                    <h3>事业金字塔阵</h3>
                    <p class="spread-subtitle">适合事业发展 & 职场指导</p>
                    <p class="spread-desc">从基础到顶峰，全面分析事业发展的各个层面，提供职场发展建议。</p>
                    <div class="spread-tags">
                        <span class="tag">事业发展</span>
                        <span class="tag">职场指导</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('wealth')">
                    <div class="spread-icon">💰</div>
                    <h3>财富牌阵</h3>
                    <p class="spread-subtitle">适合财运分析 & 投资指导</p>
                    <p class="spread-desc">专门针对财富运势的占卜，分析财运趋势和投资机会。</p>
                    <div class="spread-tags">
                        <span class="tag">财运分析</span>
                        <span class="tag">投资指导</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('job_interview')">
                    <div class="spread-icon">🤝</div>
                    <h3>求职面试牌阵</h3>
                    <p class="spread-subtitle">适合求职准备 & 面试指导</p>
                    <p class="spread-desc">专门为求职者设计，分析求职成功率和面试表现建议。</p>
                    <div class="spread-tags">
                        <span class="tag">求职指导</span>
                        <span class="tag">面试准备</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 选择型牌阵 -->
        <div class="spread-category">
            <h2 class="category-title">🤔 选择型牌阵</h2>
            <div class="spreads-row">
                <div class="spread-card" onclick="selectSpread('two_choice')">
                    <div class="spread-icon">⚖️</div>
                    <h3>二选一牌阵</h3>
                    <p class="spread-subtitle">适合两难选择 & 决策帮助</p>
                    <p class="spread-desc">当面临两个选择时，帮助您分析每个选择的优劣，做出最佳决定。</p>
                    <div class="spread-tags">
                        <span class="tag">决策帮助</span>
                        <span class="tag">选择分析</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('three_choice')">
                    <div class="spread-icon">🎲</div>
                    <h3>三选一牌阵</h3>
                    <p class="spread-subtitle">适合多重选择 & 方案比较</p>
                    <p class="spread-desc">当有三个选择方案时，全面分析每个方案的特点和结果。</p>
                    <div class="spread-tags">
                        <span class="tag">多重选择</span>
                        <span class="tag">方案比较</span>
                    </div>
                </div>

                <div class="spread-card" onclick="selectSpread('problem_solving')">
                    <div class="spread-icon">🧩</div>
                    <h3>问题解决牌阵</h3>
                    <p class="spread-subtitle">适合困难突破 & 解决方案</p>
                    <p class="spread-desc">专门用于解决具体问题，分析问题根源并提供解决方案。</p>
                    <div class="spread-tags">
                        <span class="tag">问题解决</span>
                        <span class="tag">突破困难</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    text-align: center;
    margin: 4rem 0 3rem 0;
    padding-top: 2rem;
}

.page-title {
    font-size: 2.5rem;
    color: #ffd700;
    margin-bottom: 1rem;
    text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
}

.page-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0;
}

.spreads-grid {
    max-width: 1200px;
    margin: 0 auto;
}

.spread-category {
    margin-bottom: 3rem;
}

.category-title {
    font-size: 1.8rem;
    color: #ffd700;
    margin-bottom: 1.5rem;
    text-align: center;
    border-bottom: 2px solid rgba(255, 215, 0, 0.3);
    padding-bottom: 0.5rem;
}

.spreads-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.spread-card {
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 215, 0, 0.2);
    border-radius: 15px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.spread-card:hover {
    border-color: #ffd700;
    background: rgba(255, 215, 0, 0.1);
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.2);
}

.spread-icon {
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 1rem;
}

.spread-card h3 {
    color: #ffd700;
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    text-align: center;
}

.spread-subtitle {
    color: #00ff88;
    font-size: 0.9rem;
    text-align: center;
    margin-bottom: 1rem;
    font-weight: bold;
}

.spread-desc {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.spread-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
}

.tag {
    background: rgba(255, 215, 0, 0.2);
    color: #ffd700;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    border: 1px solid rgba(255, 215, 0, 0.3);
}

@media (max-width: 768px) {
    .spreads-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .spread-card {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .category-title {
        font-size: 1.5rem;
    }
}
</style>

<script>
function selectSpread(spreadType) {
    // 根据不同的牌阵类型，跳转到对应的抽牌页面
    const spreadConfig = {
        'single': { cards: 1, name: '单张牌占卜' },
        'three': { cards: 3, name: '三张牌占卜法' },
        'five': { cards: 5, name: '五张牌占卜法' },
        'timeflow': { cards: 3, name: '时间流牌阵' },
        'holy_triangle': { cards: 3, name: '圣三角牌阵' },
        'core': { cards: 1, name: '直指核心牌阵' },
        'body_mind_spirit': { cards: 3, name: '身心灵牌阵' },
        'four_elements': { cards: 4, name: '四元素牌阵' },
        'self_exploration': { cards: 5, name: '自我探索牌阵' },
        'love_pyramid': { cards: 5, name: '恋人金字塔' },
        'love_star': { cards: 7, name: '爱之星牌阵' },
        'relationship_tree': { cards: 6, name: '恋人之树牌阵' },
        'career_pyramid': { cards: 5, name: '事业金字塔阵' },
        'wealth': { cards: 4, name: '财富牌阵' },
        'job_interview': { cards: 3, name: '求职面试牌阵' },
        'two_choice': { cards: 4, name: '二选一牌阵' },
        'three_choice': { cards: 6, name: '三选一牌阵' },
        'problem_solving': { cards: 5, name: '问题解决牌阵' }
    };
    
    const config = spreadConfig[spreadType];
    if (config) {
        // 跳转到抽牌页面，并传递牌阵信息
        window.location.href = `draw_cards.php?spread=${spreadType}&cards=${config.cards}&name=${encodeURIComponent(config.name)}`;
    }
}
</script>

<?php
// 包含底部
include 'includes/footer.php';
?>