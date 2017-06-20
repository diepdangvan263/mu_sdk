<?php

class Application_User extends Controller
{
	public function init()
	{
		$this->user = new Model_Account();

		$appkey = filter_input(INPUT_GET, 'dd', FILTER_SANITIZE_URL);
		if (isset($appkey) && $appkey == 0) {
			$this->app_key = $this->registry['config']['appkey']['android'];
		} else {
			$this->app_key = $this->registry['config']['appkey']['ios'];
		}
	}

	public function login()
	{
		if (empty($_POST['username']) && empty($_POST['userpass'])) {
			die(Language::get('login_error'));
		} else {
			$param = array(
				'username' => $_POST['username'],
				'userpass' => $_POST['userpass']
			);
			$url = 'http://login.muoriginfree.com:8880/platform/api/users/login_ldr.json?app='.$this->app_key.'&act=user.phonelogin&lang=vi';
			$result = Helper::curlSendPOST($param, $url);
			echo $result;

			$data = json_decode($result, true);
			unset($data['data']['indulge']);
			unset($data['data']['uid']);
			unset($data['data']['KL_SSO']);
			unset($data['data']['KL_PERSON']);
			unset($data['data']['isnew']);

			if (isset($data['data'])) {
				$user = $this->user->read($data['data']['account_id']);
				if (!empty($user)) {
					$edit = array(
						'ipv4' => $_SERVER['REMOTE_ADDR'],
						'modified' => date('Y-m-d H:i:s', time())
					);
					$this->user->edit($edit, $data['data']['account_id']);
				} else {
					$data['data']['password'] = $_POST['userpass'];
					$data['data']['ipv4'] = $_SERVER['REMOTE_ADDR'];
					$data['data']['created'] = date('Y-m-d H:i:s', time());
					$data['data']['modified'] = date('Y-m-d H:i:s', time());
					$this->user->add($data['data']);
				}
				$this->registry['log']->add('account', $user['uname'], 'Tài khoản ' . $user['uname'] . ' đăng nhập thành công lúc ' . date('Y-m-d H:i:s', time()));
			}
		}
	}

	public function register()
	{
		if (empty($_POST['user_name']) && empty($_POST['password']) && empty($_POST['email'])) {
			die(Language::get('register_error'));
		} else {
			$param = array(
				'user_name' => $_POST['user_name'],
				'password' => $_POST['password'],
				'email' => $_POST['email']
			);
			$url = 'http://login.muoriginfree.com:8880/platform/api/users/register_ldr.json?app='.$this->app_key.'&act=user.phonelogin&lang=vi';
			$result = Helper::curlSendPOST($param, $url);
			echo $result;

			$data = json_decode($result, true);
			unset($data['data']['indulge']);
			unset($data['data']['uid']);
			unset($data['data']['KL_SSO']);
			unset($data['data']['KL_PERSON']);
			unset($data['data']['isnew']);

			if (isset($data['data'])) {
				$data['data']['password'] = $_POST['password'];
				$data['data']['ipv4'] = $_SERVER['REMOTE_ADDR'];
				$data['data']['created'] = date('Y-m-d H:i:s', time());
				$data['data']['modified'] = date('Y-m-d H:i:s', time());
				$this->user->add($data['data']);
				$this->registry['log']->add('account', $data['data']['uname'], 'Tài khoản ' . $data['data']['uname'] . ' đăng kí thành công lúc ' . date('Y-m-d H:i:s', time()));
			}
		}
	}
}
