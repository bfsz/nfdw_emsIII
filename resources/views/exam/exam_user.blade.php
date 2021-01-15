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
                    <h1 class="display-6">考场 : {{ $name }}</h1>
                    <hr>
                    <p class="lead">总&nbsp;&nbsp;时&nbsp;&nbsp;长&nbsp;: <span
                            class="badge badge-secondary">{{$sum_time}} 分钟</span></p>
                    <p class="lead">科&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目 : {{ $subject_name }}</p>
                    <p class="lead">试&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;卷 : {{ $exam_name }}
                        ，总分（{{ $allscore }} 分）</p>
                    <p class="lead">考&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;生 : 【{{ $user_id }}
                        】{{ $user_name }}</p>
                </div>
            </div>
            {{--遍历试题--}}
            @foreach ($exam_question as $ques)
                <div class="test border-0">
                    <form action="" method="post" id="exam_form">
                        <div class="test_content">
                            <div class="test_content_title">
                                <h2>{{ $ques->type }}</h2>
                                <p>
                                    <span>共</span><i
                                        class="content_lit">{{ $ques->count }}</i><span>题，</span><span>每小题</span><i
                                        class="content_fs">{{ $ques->score }}</i><span>分</span>
                                </p>
                            </div>
                        </div>
                        <div class="test_content_nr">
                            <ul>
                                {{--遍历题目--}}
                                @foreach ($ques->questions as $qus)
                                    <li id="qu_{{ $ques->id }}_{{$loop->iteration}}"
                                        value="{{ $qus->id }}" class="question">
                                        <button type="button" class="flag_button btn btn-light"
                                                id="qu_{{ $ques->id }}_{{$loop->iteration}}"><i
                                                id="qu_{{ $ques->id }}_{{$loop->iteration}}"
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
                                                    @switch($qus->questype_id)
                                                        @case(1) {{--单选题--}}
                                                        <div class="col-6" id="que_answer">
                                                            @for($i = 0;$i<$qus->que_selectnum;$i++)
                                                                <label
                                                                    for="0_answer_{{ $ques->id }}_option_{{$loop->iteration}}"
                                                                    class="exam_style">{{ $exam_select[$i] }}
                                                                    &nbsp;&nbsp;</label><input
                                                                    type="radio"
                                                                    class="radioOrCheck"
                                                                    name="{{ $qus->id }}"
                                                                    id="{{ $qus->id }}"
                                                                    value="{{ $exam_select[$i] }}"/>&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;
                                                                &nbsp;
                                                                &nbsp;
                                                            @endfor
                                                        </div>
                                                        @break

                                                        @case(3){{--判断题--}}
                                                        <div class="col-6" id="que_answer">
                                                            @for($i = 0;$i<$qus->que_selectnum;$i++)
                                                                <label
                                                                    for="0_answer_{{ $ques->id }}_option_{{$loop->iteration}}"
                                                                    class="exam_style">{{ $exam_select[$i] }}
                                                                    &nbsp;&nbsp;</label><input
                                                                    type="radio"
                                                                    class="radioOrCheck"
                                                                    name="{{ $qus->id }}"
                                                                    id="{{ $qus->id }}"
                                                                    value="{{ $exam_select[$i] }}"/>&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;
                                                                &nbsp;
                                                                &nbsp;
                                                            @endfor
                                                        </div>
                                                        @break
                                                        @default{{--多选题--}}
                                                        <div class="col-6" id="que_answer">
                                                            @for($i = 0;$i<$qus->que_selectnum;$i++)
                                                                <label
                                                                    for="0_answer_{{ $ques->id }}_option_{{$loop->iteration}}"
                                                                    class="exam_style">{{ $exam_select[$i] }}
                                                                    &nbsp;&nbsp;</label><input
                                                                    type="checkbox"
                                                                    class="radioOrCheck"
                                                                    name="{{ $qus->id }}"
                                                                    id="{{ $qus->id }}"
                                                                    value="{{ $exam_select[$i] }}"/>&nbsp;&nbsp;&nbsp;
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
                                                        <li id="qu_{{ $ques->id }}_{{$loop->iteration}}"
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
                                                                        @switch($qus_son->questype_id)
                                                                            @case(1) {{--单选题--}}
                                                                            <div class="col-6" id="que_answer">
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

                                                                            @case(3){{--判断题--}}
                                                                            <div class="col-6" id="que_answer">
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
                                                                            <div class="col-6" id="que_answer">
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
                                @endforeach
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
                    <div class="alert alert-danger" role="alert">
                        注意：刷新页面，表单数据将清空。请勿刷新页面！
                    </div>
                    <hr>
                    @foreach ($exam_question as $ques)
                        <div class="col-12">
                            <h4>{{ $ques->type }} | 共 <span
                                    class="badge badge-pill badge-success">{{ $ques->count }}</span> 题</h4>
                            <div class="answerSheet">
                                <ul>
                                    @foreach($ques->questions as $qu)
                                        <li value="{{$qu->id}}"><a
                                                href="#qu_{{$ques->id}}_{{$loop->iteration}}"
                                                id="#qu_{{$ques->id}}_{{$loop->iteration}}">{{$loop->iteration}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <button type="button" class="btn btn-outline-success" onclick="submit()" style="float: right">交卷
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //倒计时
    var maxtime;
    if (window.name === '') {
        maxtime = '{{ $sum_time }}';
        maxtime = maxtime * 60;
    } else {
        maxtime = window.name;
    }

    function CountDown() {
        if (maxtime >= 0) {
            minutes = Math.floor(maxtime / 60);
            seconds = Math.floor(maxtime % 60);
            msg = "距离考试结束还有" + minutes + "分" + seconds + "秒";
            document.all["timer"].innerHTML = msg;
            if (maxtime === 5 * 60) {
                Dcat.warning('注意，还有5分钟!');
            }
            --maxtime;
            window.name = maxtime;
        } else {
            clearInterval(timer);
            Dcat.swal.info('已提交', '考试时间到，结束!');
            ajax_postData(); ////规定时间结束后自动提交按钮 提交试卷
        }
    }

    timer = setInterval("CountDown()", 1000);

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
        let basic_id = '{{ $basic_id }}'; //考场ID
        let ems_starttime = {{ $ems_starttime }};//开始时间
        let data = $('form').serializeArray();
        // 创建映射 多选题name(题目ID 相同的合并)
        let map = data.reduce((p, c) => [p[c.name] = p[c.name] || '', p[c.name] += c.value, p][2], {});
        // 获取映射结果
        let res = Object.keys(map).map(key => [{name: key, value: map[key]}][0]);
        let return_data = [res];
        $.ajax({
            type: "get",
            url: '/admin/KaoSheng/examFun',
            data: {
                user_id: user_id, // 当前用户ID
                basic_id: basic_id, // 考场ID
                ems_starttime: ems_starttime, // 考场ID
                return_data: return_data, //试题id 和 答案
            },
            success: function (data) {
                // 提交成功后跳入成绩页面
                window.location.href = "http://localhost:8025/admin/KaoSheng/EmsHistory";
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
