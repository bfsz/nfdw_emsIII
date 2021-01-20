<style>
    .question_dtid {
        background-color: #4e9876;
        color: #ffffff;
    }

    .question_flag {
        background-color: rgba(209, 4, 0, 0.53);
        color: #ffffff;
    }

    .datika {
        position: fixed;
        z-index: 10;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <div class="jumbotron jumbotron-fluid shadow p-3 mb-5 bg-white rounded">
                <div class="container">
                    <h1 class="display-6">模拟考试名：{{ $name }}</h1>
                </div>
            </div>
            {{--遍历试题--}}
            @foreach ($mock_question as $qus)
                <div class="test border-0">
                    <form action="" method="post" id="exam_form">
                        <div class="test_content_nr">
                            <ul>
                                {{--遍历题目--}}
                                <li id="qu_{{ $qus->id }}_{{$loop->iteration}}"
                                    value="{{ $qus->id }}" class="question">
                                    <button type="button" class="flag_button btn btn-light"
                                            id="qu_{{ $qus->id }}_{{$loop->iteration}}"><i
                                            id="qu_{{ $qus->id }}_{{$loop->iteration}}"
                                            class="fa fa-bookmark-o text-warning">&nbsp;&nbsp; 标记</i>
                                    </button>
                                    @switch($qus->que_son_num)
                                        @case(null){{--一般题--}}
                                        <div class="test_content_nr_tt" name="que_index">
                                            <i>{{$loop->iteration}}</i>
                                            <p>{!! $qus->que_index !!}</p>
                                        </div>

                                        <div class="test_content_nr_main" name="que_select">
                                            <ul>
                                                <p>{!! $qus->que_select !!}<p>
                                            </ul>
                                            <div class="row">
                                                <div class="col-6"></div>
                                                {{--遍历选项 判断题型--}}
                                                @switch(strlen($qus->que_answer))
                                                    @case(1) {{--单选题--}}
                                                    <div class="col-6" id="que_answer">单选
                                                        @for($i = 0;$i<$qus->que_selectnum;$i++)
                                                            <label
                                                                for="0_answer_{{ $qus->id }}_option_{{$loop->iteration}}"
                                                                class="exam_style">{{ $mock_select[$i] }}
                                                                &nbsp;&nbsp;</label><input
                                                                type="radio"
                                                                class="radioOrCheck"
                                                                name="{{ $qus->id }}"
                                                                id="{{ $qus->id }}"
                                                                value="{{ $mock_select[$i] }}"/>&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;
                                                            &nbsp;
                                                            &nbsp;
                                                        @endfor
                                                    </div>
                                                    @break
                                                    @default{{--多选题--}}
                                                    <div class="col-6" id="que_answer">多选
                                                        @for($i = 0;$i<$qus->que_selectnum;$i++)
                                                            <label
                                                                for="0_answer_{{ $qus->id }}_option_{{$loop->iteration}}"
                                                                class="exam_style">{{ $mock_select[$i] }}
                                                                &nbsp;&nbsp;</label><input
                                                                type="checkbox"
                                                                class="radioOrCheck"
                                                                name="{{ $qus->id }}"
                                                                id="{{ $qus->id }}"
                                                                value="{{ $mock_select[$i] }}"/>&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;
                                                            &nbsp;
                                                            &nbsp;
                                                        @endfor
                                                    </div>
                                                @endswitch
                                            </div>
                                        </div>
                                        @break
                                        @default {{--题冒题--}}
                                        <div class="test_content_nr_tt">
                                            <i class="">{{$loop->iteration}}</i>
                                            <p>{!! $qus->que_index !!}</p>
                                        </div>
                                        @foreach($qus->que_son_value as $qus_son)
                                            <div class="test_content_nr">
                                                <ul>
                                                    <li id="qu_{{ $qus->id }}_{{$loop->iteration}}"
                                                        value="{{ $qus_son->id }}">
                                                        <ul>
                                                            <div class="alert alert-success" role="alert">
                                                                <p>{!! $qus_son->que_index !!}</p>
                                                            </div>
                                                            <div class="test_content_nr_main">
                                                                <ul>
                                                                    {!! $qus_son->que_select !!}
                                                                </ul>
                                                                <div class="row">
                                                                    <div class="col-6"></div>
                                                                    {{--遍历选项 判断题型--}}
                                                                    @switch(strlen($qus_son->que_answer))
                                                                        @case(1) {{--单选题--}}
                                                                        <div class="col-6" id="que_answer">单选
                                                                            @for($i = 0;$i<$qus_son->que_selectnum;$i++)
                                                                                <label
                                                                                    for="0_answer_{{ $qus_son->id }}_option_{{$loop->iteration}}"
                                                                                    class="exam_style">{{ $exam_select[$i] }}
                                                                                    &nbsp;&nbsp;</label><input
                                                                                    type="radio"
                                                                                    class="radioOrCheck"
                                                                                    name="{{ $qus_son->id }}"
                                                                                    id="{{$loop->iteration}}"
                                                                                    value="{{ $exam_select[$i] }}"/>
                                                                                &nbsp;&nbsp;&nbsp;
                                                                                &nbsp;&nbsp;&nbsp;
                                                                                &nbsp;
                                                                                &nbsp;
                                                                            @endfor
                                                                        </div>
                                                                        @break
                                                                        @default{{--多选题--}}
                                                                        <div class="col-6" id="que_answer">多选
                                                                            @for($i = 0;$i<$qus_son->que_selectnum;$i++)
                                                                                <label
                                                                                    for="0_answer_{{ $qus_son->id }}_option_{{$loop->iteration}}"
                                                                                    class="exam_style">{{ $exam_select[$i] }}
                                                                                    &nbsp;&nbsp;</label><input
                                                                                    type="checkbox"
                                                                                    class="radioOrCheck"
                                                                                    name="{{ $qus_son->id }}"
                                                                                    id="{{$loop->iteration}}"
                                                                                    value="{{ $exam_select[$i] }}"/>
                                                                                &nbsp;&nbsp;&nbsp;
                                                                                &nbsp;&nbsp;&nbsp;
                                                                                &nbsp;
                                                                                &nbsp;
                                                                            @endfor
                                                                        </div>
                                                                    @endswitch
                                                                </div>
                                                            </div>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endforeach
                                    @endswitch
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

        {{--答题卡导航栏--}}
        <div class="col-3">
            <div class="card datika"
                 style="margin-right: 10px;margin-top:10px;margin-bottom: 10px;height: 100%;">
                <div class="col-12 card-body">
                    <h1>
                        <div id="timer" style="color:red"></div>
                    </h1>
                    <hr>
                    <div class="col-12">
                        <h4> 共 <span
                                class="badge badge-pill badge-success">{{ $mock_count }}</span> 题</h4>
                        <div class="answerSheet">
                            <ul>
                                @foreach ($mock_question as $qu)
                                    <li value="{{$qu->id}}"><a
                                            href="#qu_{{$qu->id}}_{{$loop->iteration}}"
                                            id="#qu_{{$qu->id}}_{{$loop->iteration}}">{{$loop->iteration}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr>

                    <button type="button" class="btn btn-outline-success" onclick="submit()" style="float: right">交卷
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {
        //答题 已答题标记 jquery checkbox change click事件的执行顺序
        $('.radioOrCheck').on("click", function () {
            $('.question').on("change", function () {
                let examId = $(this).attr('id'); // 得到题目ID
                let cardLi = $('a[href="#' + examId + '"]'); // 根据题目ID找到对应答题卡
                // 设置已答题
                if (!cardLi.hasClass('question_dtid')) {
                    cardLi.addClass('question_dtid');
                }
            });
        });
        // 标记
        $('.flag_button').click(function () {
            let examId = $(this).attr('id'); // 得到题目ID
            let cardLi = $('a[href="#' + examId + '"]'); // 根据题目ID找到对应答题卡
            if (!cardLi.hasClass('question_flag')) {
                cardLi.addClass('question_flag');
                $("#" + examId + " .fa").attr("class", "fa fa-bookmark text-warning");
            } else {
                cardLi.removeClass('question_flag');
                $("#" + examId + " .fa").removeClass('fa fa-bookmark text-warning').addClass('fa fa-bookmark-o text-warning');
            }
        });
    });

    Dcat.ready(function () {

    });


    // 点击确认交卷业务处理
    function submit() {
        Dcat.confirm('确定交卷吗？请仔细检查试卷后交卷。', null, function () {
            ajax_postData(); //提交后台处理
        });
    }

    // 表单提交处理
    function ajax_postData() {
        let user_id = '{{ $user_id }}'; //用户ID
        let mock_id = '{{ $mock_id }}'; //模拟ID
        let mock_startdate = {{ $mock_startdate }};//开始时间
        let data = $('form').serializeArray();
        // 创建映射 多选题name(题目ID 相同的合并)
        let map = data.reduce((p, c) => [p[c.name] = p[c.name] || '', p[c.name] += c.value, p][2], {});
        // 获取映射结果
        let res = Object.keys(map).map(key => [{name: key, value: map[key]}][0]);
        let return_data = JSON.stringify(res);
        $.ajax({
            type: "get",
            url: '/admin/KaoSheng/mockFun',
            data: {
                user_id: user_id, // 当前用户ID
                mock_id: mock_id, // 模拟ID
                mock_startdate: mock_startdate, // 考场ID
                return_data: return_data, //试题id 和 答案
            },
            success: function (data) {
                // 提交成功后跳入成绩页面
                window.location.href = "http://localhost:8025/admin/KaoSheng/EmsMockexam";
            },
            error: function (request, status, error) {
                Dcat.error('服务器出现未知错误', '提交失败，请联系管理员');
            },
        });
    }

    document.onkeydown = function (e) {
        e = window.event || e;
        var k = e.keyCode;
        //屏蔽ctrl+R，F5键，ctrl+F5键  F3键！验证
        if ((e.ctrlKey === true && k === 82) || (k === 116) ||
            (e.ctrlKey === true && k === 116) || k === 114) {
            // e.keyCode = 0;
            alert("当前页面不能刷新！");
            e.returnValue = false;
            e.cancelBubble = true;
            return false;

        }
        if (k === 8) {
            alert("不能返回或后退！");
            // e.keyCode = 0;
            e.returnValue = false;
            return false;
        }
        //屏蔽 Ctrl+n   验证可以实现效果
        if (e.ctrlKey && k === 78) {
            // e.keyCode = 0;
            e.returnValue = false;
            e.cancelBubble = true;
            return false;
        }
        //屏蔽F11   验证可以实现效果
        if (k === 122) {
            e.keyCode = 0;
            e.returnValue = false;
            e.cancelBubble = true;
            return false;
        }
        //屏蔽 shift+F10  验证可以实现效果
        if ((e.shiftKey && k === 121) || (e.ctrlKey && k === 121)) {
            e.keyCode = 0;
            e.returnValue = false;
            e.cancelBubble = true;
            return false;
        }

        //屏蔽Alt+F4
        if ((e.altKey) && (k === 115)) {
            window.showModelessDialog("about:blank", "",
                "dialogWidth:1px;dialogheight:1px");
            e.keyCode = 0;
            e.returnValue = false;
            e.cancelBubble = true;
            return false;
        }
        //屏蔽 Alt+ 方向键 ← ;屏蔽 Alt+ 方向键 → ！验证
        if ((e.altKey) &&
            ((k === 37) || (k === 39))) {
            alert("不准你使用ALT+方向键前进或后退网页！");
            e.keyCode = 0;
            e.returnValue = false;
            e.cancelBubble = true;
            return false;
        }

    };

    //屏蔽右键菜单，！验证
    document.oncontextmenu = function (event) {
        if (window.event) {
            event = window.event;
        }
        try {
            var the = event.srcElement;
            if (!((the.tagName === "INPUT" && the.type.toLowerCase() === "text") || the.tagName === "TEXTAREA")) {
                return false;
            }
            return true;
        } catch (e) {
            return false;
        }
    };
</script>
