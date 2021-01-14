<?php


namespace App\Admin\Controllers\KaoSheng;

use App\Http\Controllers\Controller;
use App\Models\KaoShi\EmsExamhistory;
use App\Models\KaoShi\EmsExamsession;
use App\Models\Tiku\EmsQuestion;
use Dcat\Admin\Admin;
use Illuminate\Http\Request;

class EmsKaoShiSubmit extends Controller
{
    /*
     * 试卷提交后处理方法
     * */
    public function examFun(Request $request)
    {
        //查询当前登录用户 与 id 是否一致，一致则执行下一步操作
        $login_id = Admin::user()->id;
        $id = $request->get('user_id');
        $basic_id = $request->get('basic_id');
        $ems_starttime = $request->get('ems_starttime');// 开始时间

        if ($login_id == $id) {
            $return_data = $request->get('return_data'); // 试题id、答案
            $history_time = date("Y-m-d H:i:s"); // 结束时间记录
            $session_token_status = EmsExamsession::where('session_user_id', $id)
                ->where('session_basic_id', $basic_id)->get('session_token_status');
            $token_status = $session_token_status[0]->session_token_status + 1; // 考试次数

            //根据用户id查询临时考试记录 将考生提交返回的数据更新到历史记录表
            $emsExxamSession = EmsExamsession::where('session_user_id', $id)
                ->where('session_basic_id', $basic_id)
                ->update(['session_user_answer' => $return_data, 'session_history_time' => $history_time, 'session_token_status' => $token_status]);

            //更新成功后计算得分
            if ($emsExxamSession == 1) {
                //获取该用户下 考生答案 统计得分
                $data = EmsExamsession::where('session_user_id', $id)->where('session_basic_id', $basic_id)->get();
                //考生答案
                $answers = json_decode($data[0]->session_user_answer)[0];
                //试卷
                $exams = json_decode($data[0]->session_exam_question);
                //遍历考生答案去 比对 试题 试题：题目id、题目答案、题目分值   考生答案：题目id、答案
                $exams_arr = []; //得分列表
                $all_score = 0;//总分
                for ($i = 0, $iMax = count($exams); $i < $iMax; $i++) {
                    $counts = $exams[$i]->count;
                    $score = $exams[$i]->score;
                    $questions = $exams[$i]->questions;
                    for ($j = 0; $j < $counts; $j++) {
                        if ($questions[$j]->que_son_num == null) {//一般题
                            $yb_id = $questions[$j]->id;
                            $answer = trim($questions[$j]->que_answer);
                            for ($m = 0, $mMax = count($answers); $m < $mMax; $m++) {
                                if ($yb_id == $answers[$m]->name && $answer == $answers[$m]->value) {//判断题目id且答案一致
                                    $all_score = $all_score + $score;
//                                    DB::table('questions')->where('id',$yb_id)->increment('que_sure_count');
                                    EmsQuestion::where('id', $yb_id)->increment('que_sure_count');
                                    array_push($exams_arr, ['id' => $yb_id, 'tm' => 0, 'answer' => $answer, 'ksAnswer' => $answers[$m]->value, 'score' => $score, 'status' => 1]);
                                }
                                if ($yb_id == $answers[$m]->name && $answer != $answers[$m]->value) {//判断题目id一致且答案不一致
//                                    DB::table('questions')->where('id',$yb_id)->increment('que_error_count');
                                    EmsQuestion::where('id', $yb_id)->increment('que_error_count');
                                    array_push($exams_arr, ['id' => $yb_id, 'tm' => 0, 'answer' => $answer, 'ksAnswer' => $answers[$m]->value, 'score' => 0, 'status' => 0]);
                                }
                            }
                        } else {//题冒题子题
                            $tm_count = $questions[$j]->que_son_num;
                            $tm_data = $questions[$j]->que_son_value;
                            for ($k = 0; $k < $tm_count; $k++) {
                                $tm_id = $tm_data[$k]->id;
                                $tm_answer = trim($tm_data[$k]->que_answer);
                                for ($m = 0, $mMax = count($answers); $m < $mMax; $m++) {
                                    if ($tm_id == $answers[$m]->name && $tm_answer == $answers[$m]->value) {//判断题目id且答案一致
                                        $all_score += $score;
//                                        DB::table('questions')->where('id',$tm_id)->increment('que_sure_count');
                                        EmsQuestion::where('id', $tm_id)->increment('que_sure_count');
                                        array_push($exams_arr, ['id' => $tm_id, 'tm' => 1, 'answer' => $tm_answer, 'ksAnswer' => $answers[$m]->value, 'score' => $score, 'status' => 1]);
                                    }
                                    if ($tm_id == $answers[$m]->name && $tm_answer != $answers[$m]->value) {//判断题目id一致且答案不一致
//                                        DB::table('questions')->where('id',$tm_id)->increment('que_error_count');
                                        EmsQuestion::where('id', $tm_id)->increment('que_error_count');
                                        array_push($exams_arr, ['id' => $tm_id, 'tm' => 1, 'answer' => $tm_answer, 'ksAnswer' => $answers[$m]->value, 'score' => 0, 'status' => 0]);
                                    }
                                }
                            }
                        }
                    }
                }

                $examDatas = EmsExamsession::with(['emsBasic', 'emsExam', 'emsSubject'])
                    ->where('session_user_id', $id)
                    ->where('session_basic_id', $basic_id)->get();

                //是否通过考试
                $is_pass = $examDatas[0]->emsExam->exam_jigescore;
                $exam_score = $examDatas[0]->emsExam->exam_score;
                if ($all_score < $is_pass) {
                    $needresit = 1; // 需要补
                    $ems_ispass = 0; // 不及格
                } else {
                    $needresit = 0; //不需要补考
                    $ems_ispass = 1; // 及格
                }

                // 时间计算
                $ems_timelist = strtotime($history_time) - $ems_starttime;
                $ems_starttime = date('Y-m-d H:i:s', $ems_starttime);


                //临时记录插入成绩表
                $emsHistory = new EmsExamhistory();
                $emsHistory->ems_user_id = (int)$id;
                $emsHistory->ems_basic_id = (int)$examDatas[0]->session_basic_id; //考场ID
                $emsHistory->ems_exam_id = (int)$examDatas[0]->session_exam_id; //试卷ID
                $emsHistory->ems_subject_id = (int)$examDatas[0]->session_subject_id; //申报ID
                $emsHistory->ems_scorelist = json_encode($exams_arr);
                $emsHistory->ems_score = (double)$all_score;
                $emsHistory->ems_allscore = $exam_score;
                $emsHistory->ems_time = $examDatas[0]->session_sum_time; //总时长
                $emsHistory->ems_status = 1; //状态
                $emsHistory->ems_starttime = $ems_starttime; //开始时间
                $emsHistory->ems_endtime = $history_time; //结束时间
                $emsHistory->ems_timelist = $ems_timelist; //时间记录
                $emsHistory->ems_needresit = $needresit; //是否需要补考
                $emsHistory->ems_ispass = $ems_ispass; //是否及格
                $emsHistory->ems_decidetime = date("Y-m-d H:i:s"); //评卷时间
                $emsHistory->save();

                //删除临时记录表 只允许补考一次
                if ($token_status >= 2) {
                    $ds = EmsExamsession::where('session_user_id', $id)->where('session_basic_id', $basic_id)->get('id');
                    EmsExamsession::find($ds[0]->id)->delete();
                }
            }
        } else {
            return 'error';
        }
    }
}
