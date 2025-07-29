// 侧边栏切换功能
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 768) {
        // 移动端：显示/隐藏侧边栏
        sidebar.classList.toggle('show');
        overlay.classList.toggle('active');
    } else {
        // 桌面端：折叠/展开侧边栏
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
}

// 清除缓存功能
function clearCache() {
    const button = document.querySelector('.clear-cache-btn');
    const originalText = button.innerHTML;
    
    // 显示加载状态
    button.classList.add('loading');
    button.innerHTML = '<i>🔄</i><span>清除中...</span>';
    button.disabled = true;
    
    // 发送清除缓存请求
    makeRequest('../api/clear_cache.php', 'POST')
        .then(response => {
            if (response.success) {
                showMessage('缓存清除成功！页面将自动刷新...', 'success');
                
                // 延迟1.5秒后刷新页面，让用户看到成功消息
                setTimeout(() => {
                    // 添加时间戳参数强制刷新
                    const url = new URL(window.location);
                    url.searchParams.set('_t', response.timestamp || Date.now());
                    window.location.href = url.toString();
                }, 1500);
            } else {
                showMessage('清除缓存失败: ' + response.message, 'danger');
                resetButton();
            }
        })
        .catch(error => {
            showMessage('清除缓存失败: ' + error.message, 'danger');
            resetButton();
        });
    
    function resetButton() {
        button.classList.remove('loading');
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

// 标签页功能
function showTab(tabName) {
    // 隐藏所有标签页内容
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.remove('active');
    });
    
    // 移除所有标签按钮的激活状态
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('active');
    });
    
    // 显示选中的标签页内容
    const selectedTab = document.getElementById(tabName);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
    
    // 激活对应的标签按钮
    const selectedButton = document.querySelector(`[onclick="showTab('${tabName}')"]`);
    if (selectedButton) {
        selectedButton.classList.add('active');
    }
}

// 确认删除功能
function confirmDelete(message = '确定要删除这条记录吗？') {
    return confirm(message);
}

// 显示回复表单（客服消息功能）
function showReplyForm(messageId) {
    // 这里可以实现回复表单的显示逻辑
    // 目前先用简单的prompt代替
    const reply = prompt('请输入回复内容：');
    if (reply && reply.trim()) {
        // 创建表单并提交
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'messages.php';
        
        const messageIdInput = document.createElement('input');
        messageIdInput.type = 'hidden';
        messageIdInput.name = 'message_id';
        messageIdInput.value = messageId;
        
        const replyInput = document.createElement('input');
        replyInput.type = 'hidden';
        replyInput.name = 'reply_content';
        replyInput.value = reply.trim();
        
        const submitInput = document.createElement('input');
        submitInput.type = 'hidden';
        submitInput.name = 'reply';
        submitInput.value = '1';
        
        form.appendChild(messageIdInput);
        form.appendChild(replyInput);
        form.appendChild(submitInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// 页面加载完成后的初始化
document.addEventListener('DOMContentLoaded', function() {
    // 响应式处理
    function handleResize() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.querySelector('.main-content');
        
        if (window.innerWidth > 768) {
            // 桌面端：重置移动端样式
            sidebar.classList.remove('show');
            overlay.classList.remove('active');
        } else {
            // 移动端：重置桌面端样式
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
        }
    }
    
    // 监听窗口大小变化
    window.addEventListener('resize', handleResize);
    
    // 初始化时执行一次
    handleResize();
    
    // 激活第一个标签页（如果存在）
    const firstTab = document.querySelector('.tab-button');
    if (firstTab) {
        firstTab.click();
    }
});

// 表单验证
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            field.style.borderColor = '#ddd';
        }
    });
    
    return isValid;
}

// 显示消息提示
function showMessage(message, type = 'info') {
    // 移除现有的消息提示
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    // 插入到页面顶部
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.insertBefore(alertDiv, mainContent.firstChild);
        
        // 3秒后自动消失（除非是成功消息，因为页面会刷新）
        if (type !== 'success') {
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    }
}

// AJAX请求封装
function makeRequest(url, method = 'GET', data = null) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url);
        
        if (method === 'POST') {
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        }
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    resolve(response);
                } catch (e) {
                    resolve(xhr.responseText);
                }
            } else {
                reject(new Error('请求失败'));
            }
        };
        
        xhr.onerror = function() {
            reject(new Error('网络错误'));
        };
        
        xhr.send(data);
    });
}