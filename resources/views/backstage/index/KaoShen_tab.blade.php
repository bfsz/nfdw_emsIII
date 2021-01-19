<link rel="stylesheet" href="/backstage/index.css">
<body>
<div class="card">
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-success text-white indexlabel">
                <div class="card-body">
                    <h5 class="index_h5"><span class="fa fa-user-plus"></span>&nbsp;&nbsp;我的考试
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_1"></h1>
                    <a class="index_a" href="/admin/KaoSheng/EmsBasic"
                       target="_self"><span class="fa fa-eye"></span>&nbsp;&nbsp;查看</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-primary text-white indexlabel">
                <div class="card-body index_card_body">
                    <h5 class="index_h5"><span class="fa fa-user-circle"></span>&nbsp;&nbsp;我的成绩
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_2"></h1>
                    <a class="index_a" href="/admin/KaoSheng/EmsHistory"
                       target="_self"><span class="fa fa-eye"></span>&nbsp;&nbsp;查看</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    var data = {!! $data !!};
    var a_1 = document.getElementById("a_1");
    var a_2 = document.getElementById("a_2");
    a_1.innerHTML = data.EmsExamsession + '  场';
    a_2.innerHTML = data.EmsExamhistory + '  次';
</script>


