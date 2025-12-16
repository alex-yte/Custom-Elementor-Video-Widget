const initVideoWidget = () => {
    document.querySelectorAll('.cevw-video-widget').forEach(widget => {
        // Пропускаем если уже инициализирован
        if (widget.dataset.initialized) return;
        widget.dataset.initialized = true;

        const video  = widget.querySelector('video');
        const button = widget.querySelector('.cevw-play-button');

        if (!video || !button) return;

        button.addEventListener('click', e => {
            e.stopPropagation();
            e.preventDefault();
            video.play();
            button.style.display = 'none';
        });

        widget.addEventListener('click', () => {
            if (!video.paused) {
                video.pause();
                button.style.display = 'flex';
            }
        });

        video.addEventListener('ended', () => {
            button.style.display = 'flex';
        });
    });
};

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', initVideoWidget);

// Инициализация для Elementor редактора (динамически добавленные элементы)
if (window.elementorFrontend) {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/cevw_video.default', initVideoWidget);
}

// Для Elementor при изменении содержимого (встроенный редактор)
const observer = new MutationObserver(() => {
    initVideoWidget();
});

observer.observe(document.body, { childList: true, subtree: true });
