// Защита от копирования
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('selectstart', e => e.preventDefault());
document.addEventListener('dragstart', e => e.preventDefault());
document.addEventListener('keydown', e => {
    if (e.key === 'F12' || (e.ctrlKey && e.key === 'u') || (e.ctrlKey && e.shiftKey && e.key === 'I')) e.preventDefault();
});

function saveName() {
    const nameInput = document.getElementById('username');
    const name = nameInput.value.trim();
    const msg = document.getElementById('savedUser');
    
    if (!name) {
        msg.textContent = 'Введите имя, пожалуйста.';
        return;
    }
    
    localStorage.setItem('cryptoscam_username', name);
    msg.textContent = 'Спасибо за обратную связь, ' + name + '!';
    nameInput.value = '';
}

// ✅ РЕАЛЬНЫЙ счётчик онлайна через online.php
async function updateOnline() {
    try {
        const res = await fetch('online.php');
        const data = await res.json();
        document.getElementById('ymOnline').textContent = data.online || 0;
    } catch(e) {
        document.getElementById('ymOnline').textContent = '0';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Приветствие из localStorage
    const saved = localStorage.getItem('cryptoscam_username');
    if (saved) {
        const msg = document.getElementById('savedUser');
        if (msg) msg.textContent = 'Рады видеть вас снова, ' + saved + '!';
    }
    
    // ✅ Отправляем себя на сервер (регистрируем посетителя)
    fetch('online.php', {method: 'POST'});
    
    // ✅ Запускаем счётчик каждые 5 секунд
    updateOnline();
    setInterval(updateOnline, 5000);
    
    // 404 редирект
    if (window.location.pathname.includes('404')) {
        setTimeout(() => window.location.href = '/', 3000);
    }
});
