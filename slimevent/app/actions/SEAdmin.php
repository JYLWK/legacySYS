<?php
/**
 * Admin
 *
 * @package   Slimevent
 **/

class SEAdmin extends SECommon{

	function __construct(){
		parent::__construct();
		//$this->set_unread_msg_num();
		
		if(Account::the_user_group() != F3::get("ADMIN_GROUP"))
			Sys::error(F3::get("INVALID_GROUP_CODE"), Account::the_user_id());
	}

	function show_add_user()
	{
		echo Template::serve('admin/add_user.html');
	}

	function my(){
		F3::set("title", "个人中心");
		echo Template::serve("admin/my.html");
	}

	function add_user()
	{
		$name = F3::get('POST.name');
		$pwd = F3::get('POST.pwd');
		$group = F3::get('POST.group');
		$nickname =  F3::get('POST.nickname');
		$r = Admin::add_user($name, $pwd, $group, $nickname);

		if($r === true)
			echo "添加成功";
		else
			echo $r;
	}

    function ajax_get_user_list() {
        $user_cat = F3::get('POST.type');
        $users = Admin::get_user_list($user_cat);

        for($i=0; $i<count($users); $i++) {
            $users[$i]['first_time'] = date("m-d H:i", $users[$i]['first_time']);
            $users[$i]['last_time'] = date("m-d H:i", $users[$i]['last_time']);
        }

		F3::set('users', $users);
	    echo Template::serve("admin/user_list.html");
	}

	function list_feedback(){
		F3::set("route", array("feedback"));
		$page = F3::get("GET.page");
		$page = $page == null ? 0 : $page;

		$list = Feedback::get_all_feedback($page);// TODO 分页
		$total = Feedback::get_num();

		SECommon::pagination($page, ceil($total / F3::get('PER_PAGE_SHOW')), 'feedback/list');

		F3::set('list', $list);
		echo Template::serve('feedback/list.html');
	}

}
