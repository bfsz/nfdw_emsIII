<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Admin\Pages\index\AdminHomeTab;
use App\Admin\Pages\index\KaoShenHomeTab;
use App\Admin\Pages\index\KaoShiHomeTab;
use App\Admin\Pages\index\ShenBaoHomeTab;
use App\Admin\Pages\index\TikuHomeTab;
use App\Admin\Pages\index\AdminServerInfo;
use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        /**
         * 系统管理员
         */
        if (Admin::user()->isRole('administrator')) {
            return $content
                ->header('主页')
                ->description('数据统计')
                ->body(function (Row $row) {
                    $row->column(12, function (Column $column) {
                        $column->row(new AdminHomeTab());
                    });
                    $row->column(12, new AdminServerInfo());
                });
        }
        /**
         * 题库管理员
         */
        if (Admin::user()->isRole('question_administrator')) {
            return $content
                ->header('主页')
                ->description('数据统计')
                ->body(function (Row $row) {
                    $row->column(6, function (Column $column) {
                        $column->row(new TikuHomeTab());
                        $column->row(new Examples\QuestionsHome());
                    });
                    $row->column(6, function (Column $column) {

                    });
                });
        }
        /**
         * 考试管理员 exam_administrator
         */
        if (Admin::user()->isRole('exam_administrator')) {
            return $content
                ->header('主页')
                ->description('数据统计')
                ->body(function (Row $row) {
                    $row->column(12, function (Column $column) {
                        $column->row(new KaoShiHomeTab());
                    });
                    $row->column(6, new TikuHomeTab());
                    $row->column(6, new Examples\QuestionsHome());
                    $row->column(4, new Examples\ExamInfoHome());
                });
        }
        /**
         * 申报管理员 filing_administrator
         */
        if (Admin::user()->isRole('filing_administrator')) {
            return $content
                ->header('主页')
                ->description('数据统计')
                ->body(function (Row $row) {
                    $row->column(12, function (Column $column) {
                        $column->row(new ShenBaoHomeTab());
                    });
                });
        }
        /**
         * 考生 exam_users
         */
        if (Admin::user()->isRole('exam_users')) {
            return $content
                ->header('主页')
                ->description('数据统计')
                ->body(function (Row $row) {
                    $row->column(8, function (Column $column) {
                        $column->row(new KaoShenHomeTab());
                    });
                    $row->column(4, function (Column $column) {
                        $column->row(new Examples\ExamPinJunFen());
                        $column->row(new Examples\ExamQuestionZql());
                    });
                });
        }
    }
}
