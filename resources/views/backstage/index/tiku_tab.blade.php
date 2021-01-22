<link rel="stylesheet" href="/backstage/index.css">
<body>
<div class="card">
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-success text-white indexlabel">
                <div class="card-body">
                    <h5 class="index_h5"><span class="fa fa-leanpub"></span>&nbsp;&nbsp;试题
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_1"></h1>
                    <a class="index_a" href="/admin/TiKu/EmsQuestion"
                       target="_self"><span class="fa fa-lea"></span>&nbsp;&nbsp;查看</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-primary text-white indexlabel">
                <div class="card-body index_card_body">
                    <h5 class="index_h5"><span class="fa fa-book"></span>&nbsp;&nbsp;题型
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_2"></h1>
                    <a class="index_a" href="/admin/TiKu/EmsQuestype"
                       target="_self"><span class="fa fa-eye"></span>&nbsp;&nbsp;查看</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-danger text-white indexlabel">
                <div class="card-body">
                    <h5 class="index_h5"><span class="fa  fa-suitcase"></span>&nbsp;&nbsp;专业
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_3"></h1>
                    <a class="index_a"
                       href="/admin/TiKu/EmsMajor"
                       target="_self"><span class="fa fa-eye"></span>&nbsp;&nbsp;查看</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white indexlabel">
                <div class="card-body">
                    <h5 class="index_h5"><span class="fa fa-black-tie"></span>&nbsp;&nbsp;种类
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_4"></h1>
                    <a class="index_a"
                       href="/admin/TiKu/EmsDeclaration"
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
    var a_3 = document.getElementById("a_3")
    var a_4 = document.getElementById("a_4");
    a_1.innerHTML = data.ems_questions;
    a_2.innerHTML = data.ems_questype;
    a_3.innerHTML = data.ems_major;
    a_4.innerHTML = data.ems_declaration;
</script>


