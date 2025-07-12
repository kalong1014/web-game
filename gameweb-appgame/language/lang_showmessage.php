<?php

if(!defined('IN_YYJIA')) {

	exit('Access Denied');

}



$_SGLOBAL['msglang'] = array(



	'box_title' => '消息',



	//common

	'do_success' => '进行的操作完成了',

	'no_privilege' => '您目前没有权限进行此操作',

	'you_do_not_have_permission_to_visit' => '您已被禁止访问。',



	//network.php

	'points_deducted_yes_or_no' => '本次操作将扣减您 \\1 个积分，\\2 个经验值，确认继续？<br><br><a href="\\3" class="submit">继续操作</a> &nbsp; <a href="javascript:history.go(-1);" class="button">取消</a>',

	'points_search_error' => "您现在的积分或经验值不足，无法完成本次搜索",



	//source/do_login.php

	'users_were_not_empty_please_re_login' => '对不起，用户名不能为空，请重新登录',

	'login_failure_please_re_login' => '对不起,登录失败,请重新登录',



	//source/cp_class.php

	'did_not_specify_the_type_of_operation' => '没有正确指定要操作的分类',

	'enter_the_correct_class_name' => '请正确输入分类名',



	'note_wall_reply_success' => '已经回复到 \\1 的留言板',



	//source/cp_comment.php



	'content_is_too_short' => '输入的内容不能少于2个字符',

	'comments_do_not_exist' => '指定的评论不存在',



	//source/cp_common.php

	'security_exit' => '你已经安全退出了',
	'security_exit2' => '你已经安全退出了\\1',


	//source/cp_sendmail.php

	'email_input' => '您还没有设置邮箱，请在<a href="cp.php?ac=profile&op=contact">联系方式</a>中准确填写您的邮箱',

	'email_check_sucess' => '您的邮箱（\\1）验证激活完成了',

	'email_check_error' => '您输入的邮箱验证链接不正确。您可以在个人资料页面，重新接收新的邮箱验证链接。',

	'email_check_send' => '验证邮箱的激活链接已经发送到您刚才填写的邮箱,您会在几分钟之内收到激活邮件，请注意查收。',

	'email_error' => '填写的邮箱格式错误,请重新填写',



	//source/cp_upload.php

	'upload_images_completed' => '上传图片完成了',



	//source/do_login.php

	'to_login' => '您还没有登入，现在引导您进入登录前页面',
	'qq_login'=>'QQ授权完成，即将跳转首页\\1',
	'qq_login2'=>'QQ授权完成，即将跳转首页',
	'weibo_login'=>'微博授权完成，即将跳转首页\\1',
	'weibo_login2'=>'微博授权完成，即将跳转首页',
	'login_success' => '登录成功了，现在引导您进入登录前页面\\1',
	'login_success2' => '登录成功了，现在引导您进入登录前页面',
	'not_open_registration' => '非常抱歉，本站目前暂时不开放注册',



	//source/do_lostpasswd.php

	'getpasswd_account_notmatch' => '您的用户名或邮箱输入不正确，请重新输入，如有疑问请与管理员联系。',

	'getpasswd_email_notmatch' => '输入的Email地址与用户名不匹配，请重新确认。',

	'getpasswd_send_succeed' => '取回密码的方法已经通过 Email 发送到您的信箱中，<br />请在 3 天之内修改您的密码。',

	'user_does_not_exist' => '该用户不存',

	'getpasswd_illegal' => '您所用的 ID 不存在或已经过期，无法取回密码。',

	'profile_passwd_illegal' => '密码空或包含非法字符，请返回重新填写。',

	'getpasswd_succeed' => '您的密码已重新设置，请使用新密码登录。',



	//source/do_register.php

	'registered' => '注册成功\\1',
	'registered2' => '注册成功',

	'password_inconsistency' => '两次输入的密码不一致',

	'profile_passwd_illegal' => '密码空或包含非法字符，请重新填写。',

	'user_name_is_not_legitimate' => '用户名不合法',

	'include_not_registered_words' => '用户名包含不允许注册的词语',

	'user_name_already_exists' => '用户名已经存在',

	'email_format_is_wrong' => '填写的 Email 格式有误',

	'email_not_registered' => '填写的 Email 不允许注册',

	'email_has_been_registered' => '填写的 Email 已经被注册',

	'register_error' => '注册失败',



	//source/function_common.php

	'information_contains_the_shielding_text' => '对不起，发布的信息中包含站点屏蔽的文字',

	'site_temporarily_closed' => '站点暂时关闭',





	'incorrect_code' => '输入的验证码不符，请重新确认',





	

);



?>