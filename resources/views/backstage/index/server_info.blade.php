<body>
<div class="card">
    <div class="card-body">
        <h5 style='font-weight:bold;text-align: center'>服务器信息</h5>
        <br>
        <div class="card-body" id="msg"></div>
    </div>
</div>
</body>
<script type="text/javascript">
    var data = {!! $data !!};
    var msg = document.getElementById("msg");
    var msg_html = '';
    for (var p in data) {//遍历json对象的每个key/value对,p为key
        msg_html = msg_html + "<tr>\n" +
            "    <td style='font-weight:bold'>" + p + "</td>\n" +
            "    <td style='color: #a0a0a0'>" + data[p] + "</td>\n" +
            "    </tr>"
    }
    var html = "<table class='table table-responsive-sm table-hover'><tbody>" + msg_html + "</tbody></table>";
    msg.innerHTML = html;
</script>


