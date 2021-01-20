<div class="jumbotron">
    <h3>{{$mkems_name}}</h3>
    <br>
    <h5>开始时间：{{$mkems_startdate}} - 结束时间：{{$mkems_enddate}}</h5>
    <h5>用时：{{$mkems_timespent}} / 分钟</h5>
    <h5>题量：{{$mkems_question_count}} &nbsp;&nbsp;答对：{{$corrects}} &nbsp;&nbsp;答错：{{$wrongs}}</h5>
    <h5>正确率：{{$correct_rate}} %</h5>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>题干</th>
                    <th>选项</th>
                    <th>正确答案</th>
                    <th>你的答案</th>
                    <th>答题情况</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($mkems_analysis as $qs)
                    <tr>
                        <td>{{ $qs->id }}</td>
                        <td>{!! $qs->que_index !!}</td>
                        <td>{!! $qs->que_select !!}</td>
                        <td>{{ $qs->answer }}</td>
                        <td>{{ $qs->ksAnswer }}</td>
                        @if ($qs->answer === $qs->ksAnswer)
                            <td class="table-success">正确</td>
                        @else
                            <td class="table-danger">错误</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

