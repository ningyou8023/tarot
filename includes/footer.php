<?php
// 获取网站设置（如果还没有加载）
if (!isset($allSettings)) {
    require_once __DIR__ . '/../classes/WebsiteSettings.php';
    $settings = new WebsiteSettings();
    $allSettings = $settings->getAllSettingsGrouped();
}

$copyrightText = $allSettings['basic']['copyright_text'] ?? '2024 神秘塔罗占卜. 探索命运，聆听心灵的声音.';
$contactWechat = $allSettings['contact']['wechat'] ?? 'tarot_master';
$contactQQ = $allSettings['contact']['qq'] ?? '123456789';
$serviceHours = $allSettings['contact']['service_hours'] ?? '9:00-22:00';
$consultationPrice = $allSettings['service']['consultation_price'] ?? '99';
$consultationDuration = $allSettings['service']['consultation_duration'] ?? '30';
?>

    <!-- 回到顶部按钮 -->
    <button id="back-to-top" class="back-to-top-btn" title="回到顶部">
        <span class="back-to-top-icon">↑</span>
    </button>

    <footer>
        <div class="container">
            <p>&copy; <?php echo htmlspecialchars($copyrightText); ?></p>
        </div>
    </footer>

    <script>
        // 将设置数据传递给JavaScript
        window.siteSettings = {
            contact: {
                wechat: <?php echo json_encode($contactWechat); ?>,
                qq: <?php echo json_encode($contactQQ); ?>,
                service_hours: <?php echo json_encode($serviceHours); ?>
            },
            service: {
                consultation_price: <?php echo json_encode($consultationPrice); ?>,
                consultation_duration: <?php echo json_encode($consultationDuration); ?>
            }
        };
        
        // 创建星空背景
        function createStarField() {
            const starField = document.querySelector('.star-field');
            if (!starField) return;
            
            for (let i = 0; i < 200; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDelay = Math.random() * 3 + 's';
                star.style.animationDuration = (Math.random() * 3 + 2) + 's';
                starField.appendChild(star);
            }
        }
        
        // 页面加载完成后初始化
        document.addEventListener('DOMContentLoaded', function() {
            createStarField();
            
            // 回到顶部按钮功能
            const backToTopBtn = document.getElementById('back-to-top');
            if (backToTopBtn) {
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > 300) {
                        backToTopBtn.style.display = 'block';
                    } else {
                        backToTopBtn.style.display = 'none';
                    }
                });
                
                backToTopBtn.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
            
            // 移动端菜单功能已在script.js中处理
            
            // 音乐控制功能
            const musicToggle = document.getElementById('music-toggle');
            const backgroundMusic = document.getElementById('background-music');
            
            if (musicToggle && backgroundMusic) {
                musicToggle.addEventListener('click', function() {
                    if (backgroundMusic.paused) {
                        backgroundMusic.play().catch(e => {
                            console.log('音频播放失败:', e);
                        });
                        musicToggle.classList.add('playing');
                    } else {
                        backgroundMusic.pause();
                        musicToggle.classList.remove('playing');
                    }
                });
            }
        });
    </script>
    <script src="assets/js/script.js"></script>
</body>
</html>