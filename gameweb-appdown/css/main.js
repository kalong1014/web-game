// 初始化轮播图
new Swiper('.swiper-container', {
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});

// 新闻选项卡切换
document.querySelectorAll('.tab-item').forEach(tab => {
    tab.addEventListener('click', function() {
        // 移除其他选项卡的激活状态
        document.querySelectorAll('.tab-item').forEach(item => {
            item.classList.remove('active');
        });
        // 激活当前选项卡
        this.classList.add('active');
        
        // 这里可以添加加载对应类型新闻的逻辑
        const newsType = this.dataset.type;
        loadNews(newsType);
    });
});

// 加载新闻函数
function loadNews(type) {
    // 这里添加实际的新闻加载逻辑
    console.log('Loading news type:', type);
} 