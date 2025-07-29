<?php
require_once __DIR__ . '/../classes/WebsiteSettings.php';

// 获取网站设置
$settings = new WebsiteSettings();
$allSettings = $settings->getAllSettingsGrouped();

// 设置默认值
$siteTitle = $allSettings['basic']['site_title'] ?? '神秘塔罗占卜';
$siteSubtitle = $allSettings['basic']['site_subtitle'] ?? '探索命运的奥秘，聆听心灵的声音';
$siteDescription = $allSettings['basic']['site_description'] ?? '专业塔罗占卜服务，探索命运奥秘';

// 获取当前页面名称
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($siteTitle . ' - ' . $siteSubtitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($siteDescription); ?>">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔮</text></svg>">
</head>

<body>
    <div class="star-field"></div>
    <div class="moon"></div>
    
    <!-- 背景音乐 -->
    <audio id="background-music" loop preload="auto" style="display: none;">
        <source src="mp3/colourway.mp3" type="audio/mp3">
        您的浏览器不支持音频播放。
    </audio>
    
    <!-- 音乐控制按钮 -->
    <div id="music-control" class="music-control">
        <button id="music-toggle" class="music-toggle" title="点击播放/暂停背景音乐">
            <span class="music-icon">🎵</span>
        </button>
    </div>
    
    <nav>
        <div class="nav-container">
            <div class="logo">🔮 <?php echo htmlspecialchars($siteTitle); ?></div>
            <button class="mobile-menu-btn" id="mobile-menu-btn">☰</button>
            <ul class="nav-links" id="nav-links">
                <li><a href="<?php echo ($currentPage === 'index.php') ? '#home' : 'index.php#home'; ?>">首页</a></li>
                <li><a href="<?php echo ($currentPage === 'index.php') ? '#divination' : 'index.php#divination'; ?>">占卜</a></li>
                <li><a href="spreads.php">选择牌阵</a></li>
                <li><a href="draw_cards.php">互动抽牌</a></li>
                <li><a href="<?php echo ($currentPage === 'index.php') ? '#about' : 'index.php#about'; ?>">关于塔罗</a></li>
                <li><a href="<?php echo ($currentPage === 'index.php') ? '#contact' : 'index.php#contact'; ?>">联系我们</a></li>
            </ul>
        </div>
    </nav>