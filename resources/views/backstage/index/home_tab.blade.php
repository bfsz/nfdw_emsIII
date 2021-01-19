<link rel="stylesheet" href="/backstage/index.css">
<body>
<div class="card">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-success text-white indexlabel">
                <div class="card-body">
                    <h5 class="index_h5"><span class="fa fa-user-plus"></span>&nbsp;&nbsp;角色数量
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_2"></h1>
                    <a class="index_a" href="/admin/auth/roles"
                       target="_self"><span class="fa fa-eye"></span>&nbsp;&nbsp;查看</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white indexlabel">
                <div class="card-body index_card_body">
                    <h5 class="index_h5"><span class="fa fa-user-circle"></span>&nbsp;&nbsp;用户数量
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_1"></h1>
                    <a class="index_a" href="/admin/auth/users"
                       target="_self"><span class="fa fa-eye"></span>&nbsp;&nbsp;查看</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white indexlabel">
                <div class="card-body">
                    <h5 class="index_h5"><span class="fa fa-file-text-o"></span>&nbsp;&nbsp;日志数量
                    </h5>
                    <br class="border">
                    <h1 class="index_h1" id="a_3"></h1>
                    <a class="index_a"
                       href="/admin/auth/operation-logs"
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
    var a_3 = document.getElementById("a_3");
    a_1.innerHTML = data.admin_users;
    a_2.innerHTML = data.admin_roles;
    a_3.innerHTML = data.admin_operation_log;
</script>


