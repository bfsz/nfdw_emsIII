<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection project_dept
     * @property Grid\Column|Collection organ_name
     * @property Grid\Column|Collection user_phone
     * @property Grid\Column|Collection pid_number
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection decl_name
     * @property Grid\Column|Collection explain
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection major_name
     * @property Grid\Column|Collection que_index
     * @property Grid\Column|Collection que_status
     * @property Grid\Column|Collection que_head_satuts
     * @property Grid\Column|Collection que_head_id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection create_by
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection file_desc
     * @property Grid\Column|Collection file_name
     * @property Grid\Column|Collection file_path
     * @property Grid\Column|Collection declaration_id
     * @property Grid\Column|Collection major_id
     * @property Grid\Column|Collection que_answer
     * @property Grid\Column|Collection que_create_byid
     * @property Grid\Column|Collection que_create_byname
     * @property Grid\Column|Collection que_describe
     * @property Grid\Column|Collection que_error_count
     * @property Grid\Column|Collection que_last_byid
     * @property Grid\Column|Collection que_last_byname
     * @property Grid\Column|Collection que_level
     * @property Grid\Column|Collection que_select
     * @property Grid\Column|Collection que_selectnum
     * @property Grid\Column|Collection que_sequence
     * @property Grid\Column|Collection que_son_num
     * @property Grid\Column|Collection que_son_value
     * @property Grid\Column|Collection que_sure_count
     * @property Grid\Column|Collection questype_id
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection type_choice
     * @property Grid\Column|Collection type_name
     * @property Grid\Column|Collection last_by
     * @property Grid\Column|Collection subject
     * @property Grid\Column|Collection subject_dept
     * @property Grid\Column|Collection subject_desc
     * @property Grid\Column|Collection subject_set
     * @property Grid\Column|Collection subject_status
     * @property Grid\Column|Collection subject_uesrs
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection project_dept(string $label = null)
     * @method Grid\Column|Collection organ_name(string $label = null)
     * @method Grid\Column|Collection user_phone(string $label = null)
     * @method Grid\Column|Collection pid_number(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection decl_name(string $label = null)
     * @method Grid\Column|Collection explain(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection major_name(string $label = null)
     * @method Grid\Column|Collection que_index(string $label = null)
     * @method Grid\Column|Collection que_status(string $label = null)
     * @method Grid\Column|Collection que_head_satuts(string $label = null)
     * @method Grid\Column|Collection que_head_id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection create_by(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection file_desc(string $label = null)
     * @method Grid\Column|Collection file_name(string $label = null)
     * @method Grid\Column|Collection file_path(string $label = null)
     * @method Grid\Column|Collection declaration_id(string $label = null)
     * @method Grid\Column|Collection major_id(string $label = null)
     * @method Grid\Column|Collection que_answer(string $label = null)
     * @method Grid\Column|Collection que_create_byid(string $label = null)
     * @method Grid\Column|Collection que_create_byname(string $label = null)
     * @method Grid\Column|Collection que_describe(string $label = null)
     * @method Grid\Column|Collection que_error_count(string $label = null)
     * @method Grid\Column|Collection que_last_byid(string $label = null)
     * @method Grid\Column|Collection que_last_byname(string $label = null)
     * @method Grid\Column|Collection que_level(string $label = null)
     * @method Grid\Column|Collection que_select(string $label = null)
     * @method Grid\Column|Collection que_selectnum(string $label = null)
     * @method Grid\Column|Collection que_sequence(string $label = null)
     * @method Grid\Column|Collection que_son_num(string $label = null)
     * @method Grid\Column|Collection que_son_value(string $label = null)
     * @method Grid\Column|Collection que_sure_count(string $label = null)
     * @method Grid\Column|Collection questype_id(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection type_choice(string $label = null)
     * @method Grid\Column|Collection type_name(string $label = null)
     * @method Grid\Column|Collection last_by(string $label = null)
     * @method Grid\Column|Collection subject(string $label = null)
     * @method Grid\Column|Collection subject_dept(string $label = null)
     * @method Grid\Column|Collection subject_desc(string $label = null)
     * @method Grid\Column|Collection subject_set(string $label = null)
     * @method Grid\Column|Collection subject_status(string $label = null)
     * @method Grid\Column|Collection subject_uesrs(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection project_dept
     * @property Show\Field|Collection organ_name
     * @property Show\Field|Collection user_phone
     * @property Show\Field|Collection pid_number
     * @property Show\Field|Collection id
     * @property Show\Field|Collection decl_name
     * @property Show\Field|Collection explain
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection major_name
     * @property Show\Field|Collection que_index
     * @property Show\Field|Collection que_status
     * @property Show\Field|Collection que_head_satuts
     * @property Show\Field|Collection que_head_id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection name
     * @property Show\Field|Collection create_by
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection order
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection input
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection method
     * @property Show\Field|Collection path
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection file_desc
     * @property Show\Field|Collection file_name
     * @property Show\Field|Collection file_path
     * @property Show\Field|Collection declaration_id
     * @property Show\Field|Collection major_id
     * @property Show\Field|Collection que_answer
     * @property Show\Field|Collection que_create_byid
     * @property Show\Field|Collection que_create_byname
     * @property Show\Field|Collection que_describe
     * @property Show\Field|Collection que_error_count
     * @property Show\Field|Collection que_last_byid
     * @property Show\Field|Collection que_last_byname
     * @property Show\Field|Collection que_level
     * @property Show\Field|Collection que_select
     * @property Show\Field|Collection que_selectnum
     * @property Show\Field|Collection que_sequence
     * @property Show\Field|Collection que_son_num
     * @property Show\Field|Collection que_son_value
     * @property Show\Field|Collection que_sure_count
     * @property Show\Field|Collection questype_id
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection type_choice
     * @property Show\Field|Collection type_name
     * @property Show\Field|Collection last_by
     * @property Show\Field|Collection subject
     * @property Show\Field|Collection subject_dept
     * @property Show\Field|Collection subject_desc
     * @property Show\Field|Collection subject_set
     * @property Show\Field|Collection subject_status
     * @property Show\Field|Collection subject_uesrs
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection project_dept(string $label = null)
     * @method Show\Field|Collection organ_name(string $label = null)
     * @method Show\Field|Collection user_phone(string $label = null)
     * @method Show\Field|Collection pid_number(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection decl_name(string $label = null)
     * @method Show\Field|Collection explain(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection major_name(string $label = null)
     * @method Show\Field|Collection que_index(string $label = null)
     * @method Show\Field|Collection que_status(string $label = null)
     * @method Show\Field|Collection que_head_satuts(string $label = null)
     * @method Show\Field|Collection que_head_id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection create_by(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection file_desc(string $label = null)
     * @method Show\Field|Collection file_name(string $label = null)
     * @method Show\Field|Collection file_path(string $label = null)
     * @method Show\Field|Collection declaration_id(string $label = null)
     * @method Show\Field|Collection major_id(string $label = null)
     * @method Show\Field|Collection que_answer(string $label = null)
     * @method Show\Field|Collection que_create_byid(string $label = null)
     * @method Show\Field|Collection que_create_byname(string $label = null)
     * @method Show\Field|Collection que_describe(string $label = null)
     * @method Show\Field|Collection que_error_count(string $label = null)
     * @method Show\Field|Collection que_last_byid(string $label = null)
     * @method Show\Field|Collection que_last_byname(string $label = null)
     * @method Show\Field|Collection que_level(string $label = null)
     * @method Show\Field|Collection que_select(string $label = null)
     * @method Show\Field|Collection que_selectnum(string $label = null)
     * @method Show\Field|Collection que_sequence(string $label = null)
     * @method Show\Field|Collection que_son_num(string $label = null)
     * @method Show\Field|Collection que_son_value(string $label = null)
     * @method Show\Field|Collection que_sure_count(string $label = null)
     * @method Show\Field|Collection questype_id(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection type_choice(string $label = null)
     * @method Show\Field|Collection type_name(string $label = null)
     * @method Show\Field|Collection last_by(string $label = null)
     * @method Show\Field|Collection subject(string $label = null)
     * @method Show\Field|Collection subject_dept(string $label = null)
     * @method Show\Field|Collection subject_desc(string $label = null)
     * @method Show\Field|Collection subject_set(string $label = null)
     * @method Show\Field|Collection subject_status(string $label = null)
     * @method Show\Field|Collection subject_uesrs(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     * @method \Lake\FormMedia\Form\Field\Photo photo(...$params)
     * @method \Lake\FormMedia\Form\Field\Photos photos(...$params)
     * @method \Lake\FormMedia\Form\Field\Video video(...$params)
     * @method \Lake\FormMedia\Form\Field\Audio audio(...$params)
     * @method \Lake\FormMedia\Form\Field\File files(...$params)
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
