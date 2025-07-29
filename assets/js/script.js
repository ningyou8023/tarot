// 全局变量
let currentDivinationId = null;
let currentDivinationData = null;
let websiteSettings = {}; // 存储网站设置

// 初始化星空背景 - 优化版本
function initializeStarField() {
    const starField = document.querySelector('.star-field');
    if (!starField) return;
    
    // 使用DocumentFragment来批量添加元素，避免触发过多的DOM事件
    const fragment = document.createDocumentFragment();
    const starCount = 100; // 星星数量
    
    for (let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        
        // 随机位置
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        
        // 随机大小
        const size = Math.random() * 3 + 1;
        star.style.width = size + 'px';
        star.style.height = size + 'px';
        
        // 随机透明度
        star.style.opacity = Math.random() * 0.8 + 0.2;
        
        // 随机动画延迟
        star.style.animationDelay = Math.random() * 3 + 's';
        
        // 添加到fragment而不是直接添加到DOM
        fragment.appendChild(star);
    }
    
    // 一次性添加所有星星，减少DOM操作次数
    starField.appendChild(fragment);
}

// 页面加载完成后初始化
document.addEventListener('DOMContentLoaded', function() {
    // 使用requestAnimationFrame确保DOM完全准备好
    requestAnimationFrame(() => {
        initializeStarField();
    });
    
    // 使用PHP传递的设置数据（如果存在）
    if (typeof window.siteSettings !== 'undefined') {
        websiteSettings = window.siteSettings;
    } else {
        // 如果没有PHP数据，则通过API加载
        loadWebsiteSettings();
    }
    
    setupEventListeners();
    setupMobileMenu();
});

// 加载网站设置（备用方法，当PHP数据不可用时使用）
async function loadWebsiteSettings() {
    try {
        const response = await fetch('api/get_settings.php?type=all');
        const result = await response.json();
        
        if (result.success) {
            websiteSettings = result.data;
        }
    } catch (error) {
        console.error('加载网站设置失败:', error);
        // 使用默认设置
        websiteSettings = {
            contact: {
                wechat: 'tarot_master',
                email: 'master@tarot-divination.com',
                phone: '400-123-4567',
                service_hours: '9:00-22:00'
            }
        };
    }
}



// 设置移动端菜单
function setupMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const navLinks = document.getElementById('nav-links');
    
    if (mobileMenuBtn && navLinks) {
        // 移除可能存在的旧事件监听器
        mobileMenuBtn.replaceWith(mobileMenuBtn.cloneNode(true));
        const newMobileMenuBtn = document.getElementById('mobile-menu-btn');
        
        newMobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            navLinks.classList.toggle('active');
            newMobileMenuBtn.classList.toggle('active');
            
            // 切换汉堡菜单图标
            if (navLinks.classList.contains('active')) {
                newMobileMenuBtn.innerHTML = '✕';
            } else {
                newMobileMenuBtn.innerHTML = '☰';
            }
        });
        
        // 点击菜单项后关闭移动端菜单
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                newMobileMenuBtn.classList.remove('active');
                newMobileMenuBtn.innerHTML = '☰';
            });
        });
        
        // 点击页面其他地方关闭菜单
        document.addEventListener('click', function(e) {
            if (!newMobileMenuBtn.contains(e.target) && !navLinks.contains(e.target)) {
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    newMobileMenuBtn.classList.remove('active');
                    newMobileMenuBtn.innerHTML = '☰';
                }
            }
        });
    }
}

// 设置事件监听器
function setupEventListeners() {
    // 导航链接
    document.querySelectorAll('nav a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            scrollToSection(targetId);
        });
    });
    

    
    // 占卜表单提交
    const divinationForm = document.getElementById('divination-form');
    if (divinationForm) {
        divinationForm.addEventListener('submit', handleDivinationSubmit);
    }
    
    // 联系表单提交
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmit);
    }
    
    // 服务体系导航 - 暂时移除，功能未实现
    // setupServiceNavigation();
}

// 处理占卜表单提交
async function handleDivinationSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('.submit-btn');
    
    // 显示加载状态
    submitBtn.innerHTML = '<span class="loading"></span> 正在占卜...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('api/divination.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            currentDivinationData = result.data;
            currentDivinationId = result.data.divination_id;
            displayDivinationResult(result.data);
        } else {
            alert('占卜失败：' + result.message);
        }
    } catch (error) {
        console.error('占卜请求错误:', error);
        
        // 更详细的错误处理
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            alert('无法连接到服务器，请确保：\n1. 已启动本地服务器（如 XAMPP、WAMP 等）\n2. 服务器正在运行在正确的端口\n3. 网络连接正常');
        } else {
            alert('网络错误，请稍后重试：' + error.message);
        }
    } finally {
        submitBtn.innerHTML = '开始占卜';
        submitBtn.disabled = false;
    }
}

// 显示占卜结果
function displayDivinationResult(data) {
    // 数据验证
    if (!data || typeof data !== 'object') {
        console.error('占卜结果数据无效:', data);
        alert('占卜结果数据格式错误，请重新尝试');
        return;
    }
    
    const resultDiv = document.getElementById('divination-result');
    const cardsDisplay = document.getElementById('cards-display');
    const interpretation = document.getElementById('interpretation');
    
    // 检查必要的DOM元素
    if (!resultDiv || !cardsDisplay || !interpretation) {
        console.error('缺少必要的DOM元素');
        alert('页面元素加载错误，请刷新页面重试');
        return;
    }
    
    // 显示抽到的牌
    cardsDisplay.innerHTML = '';
    if (data.cards && Array.isArray(data.cards)) {
        data.cards.forEach((card, index) => {
            const cardDiv = document.createElement('div');
            cardDiv.className = 'card-result fade-in';
            
            // 获取卡牌图片路径
            let imagePath = '';
            if (card.image) {
                imagePath = card.image;
            } else {
                // 根据卡牌名称生成图片路径
                const cardImageMap = {
                    // 大阿卡纳
                    '愚者': 'images/major_00_fool.svg',
                    '魔术师': 'images/major_01_magician.svg',
                    '女祭司': 'images/major_02_high_priestess.svg',
                    '皇后': 'images/major_03_empress.svg',
                    '皇帝': 'images/major_04_emperor.svg',
                    '教皇': 'images/major_05_hierophant.svg',
                    '恋人': 'images/major_06_lovers.svg',
                    '战车': 'images/major_07_chariot.svg',
                    '力量': 'images/major_08_strength.svg',
                    '隐者': 'images/major_09_hermit.svg',
                    '命运之轮': 'images/major_10_wheel_of_fortune.svg',
                    '正义': 'images/major_11_justice.svg',
                    '倒吊人': 'images/major_12_hanged_man.svg',
                    '死神': 'images/major_13_death.svg',
                    '节制': 'images/major_14_temperance.svg',
                    '恶魔': 'images/major_15_devil.svg',
                    '塔': 'images/major_16_tower.svg',
                    '星星': 'images/major_17_star.svg',
                    '月亮': 'images/major_18_moon.svg',
                    '太阳': 'images/major_19_sun.svg',
                    '审判': 'images/major_20_judgement.svg',
                    '世界': 'images/major_21_world.svg',
                    // 圣杯牌组
                    '圣杯王牌': 'images/cups_01_ace.svg',
                    '圣杯二': 'images/cups_02.svg',
                    '圣杯三': 'images/cups_03.svg',
                    '圣杯四': 'images/cups_04.svg',
                    '圣杯五': 'images/cups_05.svg',
                    '圣杯六': 'images/cups_06.svg',
                    '圣杯七': 'images/cups_07.svg',
                    '圣杯八': 'images/cups_08.svg',
                    '圣杯九': 'images/cups_09.svg',
                    '圣杯十': 'images/cups_10.svg',
                    '圣杯侍从': 'images/cups_page.svg',
                    '圣杯骑士': 'images/cups_knight.svg',
                    '圣杯王后': 'images/cups_queen.svg',
                    '圣杯国王': 'images/cups_king.svg',
                    // 权杖牌组
                    '权杖王牌': 'images/wands_01_ace.svg',
                    '权杖二': 'images/wands_02.svg',
                    '权杖三': 'images/wands_03.svg',
                    '权杖四': 'images/wands_04.svg',
                    '权杖五': 'images/wands_05.svg',
                    '权杖六': 'images/wands_06.svg',
                    '权杖七': 'images/wands_07.svg',
                    '权杖八': 'images/wands_08.svg',
                    '权杖九': 'images/wands_09.svg',
                    '权杖十': 'images/wands_10.svg',
                    '权杖侍从': 'images/wands_page.svg',
                    '权杖骑士': 'images/wands_knight.svg',
                    '权杖王后': 'images/wands_queen.svg',
                    '权杖国王': 'images/wands_king.svg',
                    // 宝剑牌组
                    '宝剑王牌': 'images/swords_01_ace.svg',
                    '宝剑二': 'images/swords_02.svg',
                    '宝剑三': 'images/swords_03.svg',
                    '宝剑四': 'images/swords_04.svg',
                    '宝剑五': 'images/swords_05.svg',
                    '宝剑六': 'images/swords_06.svg',
                    '宝剑七': 'images/swords_07.svg',
                    '宝剑八': 'images/swords_08.svg',
                    '宝剑九': 'images/swords_09.svg',
                    '宝剑十': 'images/swords_10.svg',
                    '宝剑侍从': 'images/swords_page.svg',
                    '宝剑骑士': 'images/swords_knight.svg',
                    '宝剑王后': 'images/swords_queen.svg',
                    '宝剑国王': 'images/swords_king.svg',
                    // 金币牌组
                    '金币王牌': 'images/pentacles_01_ace.svg',
                    '金币二': 'images/pentacles_02.svg',
                    '金币三': 'images/pentacles_03.svg',
                    '金币四': 'images/pentacles_04.svg',
                    '金币五': 'images/pentacles_05.svg',
                    '金币六': 'images/pentacles_06.svg',
                    '金币七': 'images/pentacles_07.svg',
                    '金币八': 'images/pentacles_08.svg',
                    '金币九': 'images/pentacles_09.svg',
                    '金币十': 'images/pentacles_10.svg',
                    '金币侍从': 'images/pentacles_page.svg',
                    '金币骑士': 'images/pentacles_knight.svg',
                    '金币王后': 'images/pentacles_queen.svg',
                    '金币国王': 'images/pentacles_king.svg'
                };
                
                imagePath = cardImageMap[card.name] || 'images/card_back.svg';
            }
            
            cardDiv.innerHTML = `
                <div class="card-image-container">
                    <img src="${imagePath}" alt="${card.name}" class="tarot-card-image ${card.reversed ? 'reversed' : ''}" 
                         onerror="this.src='images/card_back.svg'; this.alt='卡牌图片加载失败';">
                    ${card.reversed ? '<div class="reversed-indicator">逆位</div>' : ''}
                </div>
                <h4>${card.name || '未知牌名'} ${card.reversed ? '(逆位)' : ''}</h4>
                ${card.name_en ? `<div class="card-english-name">${card.name_en}</div>` : ''}
                <p class="card-meaning">${card.basic_meaning || card.meaning || '暂无含义'}</p>
                ${card.keywords ? `<div class="card-keywords"><strong>关键词:</strong> ${card.keywords}</div>` : ''}
                ${card.element ? `<div class="card-element"><strong>元素:</strong> ${card.element}</div>` : ''}
                <p class="card-hint">🔮 联系占卜师获取更详细解读</p>
            `;
            cardsDisplay.appendChild(cardDiv);
        });
    } else {
        cardsDisplay.innerHTML = '<p>暂无卡牌数据</p>';
    }
    
    // 显示解读
    interpretation.innerHTML = `
        <h4>🔮 塔罗解读</h4>
        <div class="interpretation-content">
            ${(data.basic_interpretation || data.interpretation || '暂无解读内容').replace(/\n/g, '<br>')}
        </div>
        <div class="interpretation-actions">
            <button id="view-detail-btn" class="detail-btn">
                🔮 联系占卜师获取详细解读
            </button>
            <button id="contact-master-btn" class="contact-btn">
                🔮 联系占卜师获得深度指导
            </button>
        </div>
    `;
    
    // 重新绑定按钮事件
    document.getElementById('view-detail-btn').addEventListener('click', showContactDiviner);
    document.getElementById('contact-master-btn').addEventListener('click', () => scrollToSection('contact'));
    
    // 显示结果区域
    resultDiv.style.display = 'block';
    resultDiv.scrollIntoView({ behavior: 'smooth' });
}

// 显示联系占卜师提示
function showContactDiviner() {
    const resultDiv = document.getElementById('divination-result');
    
    // 添加联系占卜师提示
    const contactDiv = document.createElement('div');
    contactDiv.className = 'contact-diviner';
    contactDiv.innerHTML = `
        <h3>🔮 获取更详细解读</h3>
        <div class="contact-content">
            <p>📞 如需更深入的个人指导和详细解读，请联系我们的专业占卜师：</p>
            <div class="contact-info">
                <p>💬 微信：${websiteSettings.contact?.wechat || 'tarot_master'}</p>
                <p>💬 QQ：${websiteSettings.contact?.qq || '123456789'}</p>
                <p>⏰ 服务时间：${websiteSettings.contact?.service_hours || '9:00-22:00'}</p>
                <p>💰 咨询价格：${websiteSettings.service?.consultation_price || '99'}元/${websiteSettings.service?.consultation_duration || '30'}分钟</p>
            </div>
            <p class="contact-note">🌟 专业占卜师将为您提供一对一的深度咨询服务</p>
        </div>
    `;
    
    resultDiv.appendChild(contactDiv);
    
    // 滚动到联系信息
    contactDiv.scrollIntoView({ behavior: 'smooth' });
}

// 处理联系表单提交
async function handleContactSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // 显示加载状态
    const originalText = submitBtn.textContent;
    submitBtn.textContent = '发送中...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('api/contact.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            e.target.reset(); // 清空表单
        } else {
            alert('发送失败：' + result.message);
        }
    } catch (error) {
        console.error('联系表单错误:', error);
        
        // 更详细的错误处理
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            alert('无法连接到服务器，请确保：\n1. 已启动本地服务器（如 XAMPP、WAMP 等）\n2. 服务器正在运行在正确的端口\n3. 网络连接正常');
        } else {
            alert('网络错误，请稍后重试：' + error.message);
        }
    } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }
}

// 平滑滚动到指定区域
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}



// 添加CSS动画样式
const style = document.createElement('style');
style.textContent = `
    @keyframes twinkle {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    

    
    /* 卡牌结果样式 */
    .card-hint {
        color: #ffd700;
        font-style: italic;
        font-size: 14px;
        margin-top: 10px;
    }
    
    .card-result.detailed {
        border: 2px solid #00ff88;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
    }
    
    .card-status {
        color: #00ff88;
        font-weight: bold;
        margin-top: 10px;
        font-size: 14px;
    }
    
    /* 塔罗牌图片样式 */
    .card-image-container {
        position: relative;
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
    }
    
    .tarot-card-image {
        width: 120px;
        height: 210px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        transition: transform 0.3s ease;
        object-fit: cover;
    }
    
    .tarot-card-image:hover {
        transform: scale(1.05);
    }
    
    .tarot-card-image.reversed {
        transform: rotate(180deg);
    }
    
    .tarot-card-image.reversed:hover {
        transform: rotate(180deg) scale(1.05);
    }
    
    .reversed-indicator {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(231, 76, 60, 0.9);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
    }
    
    /* 卡牌详细信息样式 */
    .card-english-name {
        color: #daa520;
        font-style: italic;
        font-size: 12px;
        margin: 5px 0;
        text-align: center;
    }
    
    .card-keywords {
        color: #87ceeb;
        font-size: 11px;
        margin: 8px 0;
        padding: 5px;
        background: rgba(135, 206, 235, 0.1);
        border-radius: 4px;
        border-left: 3px solid #87ceeb;
    }
    
    .card-element {
        color: #ffd700;
        font-size: 11px;
        margin: 5px 0;
        text-align: center;
    }
    
    .card-meaning {
         line-height: 1.5;
         margin: 10px 0;
     }
     
     .interpretation-actions {
        margin: 20px 0;
        text-align: center;
    }
    
    .detail-btn, .contact-btn {
        padding: 12px 24px;
        margin: 10px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .detail-btn {
        background: linear-gradient(45deg, #ffd700, #ffed4e);
        color: #1a1a2e;
        font-weight: bold;
    }
    
    .contact-btn {
        background: linear-gradient(45deg, #9b59b6, #8e44ad);
        color: white;
    }
    
    .detail-btn:hover, .contact-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    
    .paid-status {
        background: linear-gradient(45deg, #00ff88, #00cc6a);
        color: #1a1a2e;
        padding: 10px 20px;
        border-radius: 20px;
        text-align: center;
        font-weight: bold;
        margin-top: 20px;
    }
    
    .basic-interpretation, .detailed-interpretation {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        margin: 15px 0;
        border-left: 4px solid #ffd700;
    }
    

`;
document.head.appendChild(style);

// 回到顶部功能
function initBackToTop() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (!backToTopBtn) return;
    
    // 监听滚动事件
    let ticking = false;
    
    function updateBackToTopVisibility() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateBackToTopVisibility);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick, { passive: true });
    
    // 点击回到顶部
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// 在DOM加载完成后初始化回到顶部功能
document.addEventListener('DOMContentLoaded', function() {
    // 延迟初始化，确保其他功能先加载
    setTimeout(initBackToTop, 100);
    // 初始化音乐控制
    setTimeout(initMusicControl, 200);
});

// 音乐控制功能
function initMusicControl() {
    const musicToggle = document.getElementById('music-toggle');
    const backgroundMusic = document.getElementById('background-music');
    
    if (!musicToggle || !backgroundMusic) return;
    
    let isPlaying = false;
    
    // 音乐文件列表（可扩展）
    const musicFiles = [
        'mp3/colourway.mp3'
        // 可以在这里添加更多音乐文件
    ];
    
    let currentMusicIndex = 0;
    
    // 设置音量
    backgroundMusic.volume = 0.3;
    
    // 随机选择音乐文件
    function getRandomMusic() {
        if (musicFiles.length > 1) {
            let newIndex;
            do {
                newIndex = Math.floor(Math.random() * musicFiles.length);
            } while (newIndex === currentMusicIndex && musicFiles.length > 1);
            currentMusicIndex = newIndex;
        }
        return musicFiles[currentMusicIndex];
    }
    
    // 加载音乐文件
    function loadMusic(src) {
        backgroundMusic.src = src;
        backgroundMusic.load();
    }
    
    // 音乐控制按钮点击事件
    musicToggle.addEventListener('click', function() {
        if (isPlaying) {
            pauseMusic();
        } else {
            playMusic();
        }
    });
    
    // 播放音乐
    function playMusic() {
        backgroundMusic.play().then(() => {
            isPlaying = true;
            musicToggle.classList.remove('paused');
            musicToggle.classList.add('playing');
            musicToggle.querySelector('.music-icon').textContent = '🎵';
        }).catch(error => {
            console.log('音乐播放失败:', error);
            // 浏览器可能阻止自动播放，这是正常的
        });
    }
    
    // 暂停音乐
    function pauseMusic() {
        backgroundMusic.pause();
        isPlaying = false;
        musicToggle.classList.remove('playing');
        musicToggle.classList.add('paused');
        musicToggle.querySelector('.music-icon').textContent = '🎶';
    }
    
    // 播放下一首（随机）
    function playNextMusic() {
        const nextMusic = getRandomMusic();
        loadMusic(nextMusic);
        if (isPlaying) {
            // 等待音乐加载完成后播放
            backgroundMusic.addEventListener('canplaythrough', function() {
                playMusic();
            }, { once: true });
        }
    }
    
    // 音乐结束时播放下一首
    backgroundMusic.addEventListener('ended', function() {
        if (musicFiles.length > 1) {
            playNextMusic();
        } else {
            // 只有一首歌时循环播放
            backgroundMusic.currentTime = 0;
            if (isPlaying) {
                playMusic();
            }
        }
    });
    
    // 音乐加载错误处理
    backgroundMusic.addEventListener('error', function(e) {
        console.log('音乐加载错误:', e);
        // 尝试播放下一首
        if (musicFiles.length > 1) {
            playNextMusic();
        } else {
            musicToggle.style.display = 'none'; // 隐藏控制按钮
        }
    });
    
    // 尝试自动播放
    function attemptAutoplay() {
        backgroundMusic.play().then(() => {
            isPlaying = true;
            musicToggle.classList.remove('paused');
            musicToggle.classList.add('playing');
            musicToggle.querySelector('.music-icon').textContent = '🎵';
            console.log('音乐自动播放成功');
        }).catch(error => {
            console.log('自动播放被阻止，用户需要手动启动:', error);
            // 设置为暂停状态，等待用户交互
            isPlaying = false;
            musicToggle.classList.add('paused');
            musicToggle.querySelector('.music-icon').textContent = '🎶';
        });
    }
    
    // 页面加载完成后尝试自动播放
    backgroundMusic.addEventListener('canplaythrough', function() {
        attemptAutoplay();
    }, { once: true });
    
    // 如果音乐已经可以播放，立即尝试自动播放
    if (backgroundMusic.readyState >= 3) {
        attemptAutoplay();
    }
    
    // 页面可见性变化时处理音乐播放
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && isPlaying) {
            backgroundMusic.pause();
        } else if (!document.hidden && isPlaying) {
            backgroundMusic.play().catch(error => {
                console.log('恢复播放失败:', error);
            });
        }
    });
    
    // 用户首次交互后启用自动播放（解决浏览器限制）
    function enableAutoplayOnInteraction() {
        if (!isPlaying) {
            attemptAutoplay();
        }
        // 移除事件监听器，只需要执行一次
        document.removeEventListener('click', enableAutoplayOnInteraction);
        document.removeEventListener('touchstart', enableAutoplayOnInteraction);
    }
    
    // 监听用户交互事件
    document.addEventListener('click', enableAutoplayOnInteraction, { once: true });
    document.addEventListener('touchstart', enableAutoplayOnInteraction, { once: true });
}