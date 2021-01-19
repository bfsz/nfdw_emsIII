<style>
    .img_index {
        height: 400px;
        width: 100%;
        background-size: auto;
    }
</style>
<body>
<div class="card">
    <div id="demo" class="carousel slide" data-ride="carousel" data-interval="6000">
        <!-- 指示符 -->
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        <!-- 轮播内容 -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="img_index"
                     src="http://h2.ioliu.cn/bing/PingganVillage_ZH-CN10035092925_1920x1080.jpg?imageslim">
            </div>
            <div class="carousel-item">
                <img class="img_index"
                     src="http://h2.ioliu.cn/bing/PingganVillage_ZH-CN10035092925_1920x1080.jpg?imageslim">
            </div>
            <div class="carousel-item">
                <img class="img_index"
                     src="http://h2.ioliu.cn/bing/PingganVillage_ZH-CN10035092925_1920x1080.jpg?imageslim">
            </div>
        </div>
        <!-- 左右切换按钮 -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>
</body>
