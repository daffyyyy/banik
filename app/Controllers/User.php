<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BansModel;
use App\Models\SbansModel;
use App\Models\LogsModel;

class User extends BaseController
{
	public function index()
	{
		$bans = new BansModel();
		$bans = $bans->where('user_id', session()->get('user_id'))
			->first();

		$sbans = new SbansModel();
		$sbans = $sbans->where('user_id', session()->get('user_id'))
			->first();

		$data['title'] = "Twoje informacje";
		$data['bans'] = $bans;
		$data['sbans'] = $sbans;

		return view('UserInfo', $data);
	}

	public function download16()
	{
		$logs = new LogsModel();
		$logs->addLog(['action' => 'Pobrano archiwum 1.6']);

		$bans = new BansModel(session()->get('user_name'));
		$user = $bans->where('user_id', session()->get('user_id'))
			->first();

		$bans->createZIP($user);
	}

	public function downloadgo()
	{
		$logs = new LogsModel();
		$logs->addLog(['action' => 'Pobrano archiwum GO']);

		$bans = new SbansModel(session()->get('user_name'));
		$user = $bans->where('user_id', session()->get('user_id'))
			->first();

		$bans->createZIP($user);
	}

	public function login()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'user_email' => 'required|min_length[6]|max_length[64]|valid_email',
				'user_password' => 'required|min_length[6]|max_length[255]|validateUser[user_email,user_password]',
			];

			$errors = [
				'user_email' => [
					'valid_email' => "Podaj poprawny adres e-mail"
				],
				'user_password' => [
					'validateUser' => 'E-mail lub hasło nie pasuje'
				]
			];

			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			} else {
				$user = new UserModel();

				$user = $user->where('user_email', $this->request->getVar('user_email'))
					->first();

				$this->setUserSession($user);

				$logs = new LogsModel();
				$logs->addLog(['action' => 'Zalogowano się']);

				//$session->setFlashdata('success', 'Successful Registration');
			}
		}
		return view('Index', $data);
	}
	public function logs()
	{
		$logs = new LogsModel();
		$data['title'] = "Logi";
		$data['logs'] = $logs->where('user_id', session()->get('user_id'))->orderBy('id', 'desc')->findAll();

		return view('UserLogs', $data);
	}

	public function edit()
	{
		$data = [];

		$user = new UserModel();

		$user = $user->where('user_id', session()->get('user_id'))
			->first();

		$data['title'] = "Twoje dane";

		return view('UserEdit', $data);
	}

	public function save()
	{
		helper(['form']);
		$data = [];
		$user = new UserModel();

		$bans = new BansModel();
		$sbans = new sBansModel();

		if ($this->request->getMethod() == 'post') {
			if ($this->request->getPost('new_password') != '') {
				$rules['new_password'] = 'required|min_length[6]|max_length[255]';
				$rules['new_password_confirm'] = 'matches[new_password]';
			}


			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				$bans_id = $bans->where('user_id', session()->get('user_id'))
					->first();
				$sbans_id = $sbans->where('user_id', session()->get('user_id'))
					->first();

				$newData = [
					'user_id' => session()->get('user_id'),
					'user_password' => $this->request->getPost('new_password'),
				];
				$user->save($newData);
				$bans->changePassword(['new_password' => $this->request->getPost('new_password'), 'bans_database' => $bans_id['bans_database']]);
				$sbans->changePassword(['new_password' => $this->request->getPost('new_password'), 'bans_database' => $sbans_id['bans_database']]);


				$logs = new LogsModel();
				$logs->addLog(['action' => 'Edytowano dane użytkownika']);

				return redirect()->to('/user/edit');
			}
		}
	}

	public function register()
	{
		if ($this->request->getMethod() == 'post') {
			if (file_exists("/var/www/bansy.banik.pl/public_html/" . strtolower($this->request->getVar('user_name'))) || file_exists("/var/www/bansy.banik.pl/public_html/sb" . strtolower($this->request->getVar('user_name')))) {
				return redirect()->to(base_url());
			}
			$userName = $this->request->getVar('user_name');
			$userName = str_replace(' ', '', $userName);
			$secret = "6Lcp1jgaAAAAAGqJB8dR3SSNVnwjEL8HkBN4NlU0";
			$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=" . $this->request->getVar('g-recaptcha-response');
			$verify = json_decode(file_get_contents($url));
			if ($verify->success) {
				$data = [];
				helper(['form']);
				helper('text');

				// let's do the validation here
				$rules = [
					'user_name' => 'required|min_length[3]|max_length[32]|alpha_numeric|is_unique[users.user_name]',
					'user_email' => 'required|min_length[6]|max_length[64]|valid_email|is_unique[users.user_email]',
					'user_password' => 'required|min_length[6]|max_length[255]',
					'user_password_confirm' => 'matches[user_password]',
				];

				if (!$this->validate($rules)) {
					$data['validation'] = $this->validator;
				} else {
					$user = new UserModel();

					$newUser = [
						'user_name' => $userName,
						'user_email' => $this->request->getVar('user_email'),
						'user_password' => $this->request->getVar('user_password'),
					];

					$user->save($newUser);

					$session = session();
					$user = [
						'user_id' => $user->getInsertID(),
						'user_name' => $userName,
						'user_email' => $this->request->getVar('user_email'),
						'isLoggedIn' => true,
					];

					// Send email
					$email = \Config\Services::email();

					$email->setTo($this->request->getVar('user_email'));
					$email->setFrom('no-reply@banik.pl', 'Banik.pl');

					$email->setSubject("Potwierdzenie rejestracji");
					$email->setMessage("Witaj $userName,\n\r\n\rwłaśnie założyłeś konto na Banik.pl, teraz możesz utworzyć amxbansa lub sourcebansa korzystając z panelu.\n\rW panelu możesz pobrać gotową paczkę na serwer.");

					$email->send();

					// Set user session
					$this->setUserSession($user);

					// Add log to database
					$logs = new LogsModel();
					$logs->addLog(['action' => 'Zarejestrowano się']);

					$session->setFlashdata('success', 'Udana rejestracja');
				}
			}
		}

		return view('Index', $data);
	}

	public function createAMXB()
	{
		helper(['form']);
		helper('text');

		$user = new UserModel();
		$user = $user->where('user_id', session()->get('user_id'))
			->first();
		$bans = new BansModel(session()->get('user_name'));

		// Create AMXBans
		$bansUser = random_string('alnum', 9);
		$bansPassword = random_string('alnum', 20);

		$newBans = [
			'user_id' => strval(session()->get('user_id')),
			'bans_host' => "banik.pl",
			'bans_user' => "banik_" . $bansUser,
			'bans_password' => $bansPassword,
			'bans_database' => "banik_" . $bansUser,
		];
		$bans->save($newBans);

		$config = [
			'user_name' => session()->get('user_name'),
			'user_email' => session()->get('user_email'),
			'user_password' => $user['user_password'],
			'bans_host' => "banik.pl",
			'bans_user' => "banik_" . $bansUser,
			'bans_password' => $bansPassword,
			'bans_database' => "banik_" . $bansUser,
		];

		$bans->editConfig($config);

		$logs = new LogsModel();
		$logs->addLog(['action' => 'Utworzono amxbansa']);

		return redirect()->to(base_url() . '/user');
	}

	public function createSB()
	{
		helper(['form']);
		helper('text');

		$user = new UserModel();
		$user = $user->where('user_id', session()->get('user_id'))
			->first();
		$bans = new SbansModel(session()->get('user_name'));

		$bansUser = 'sb_' . random_string('alnum', 7);
		$bansPassword = random_string('alnum', 20);

		$newBans = [
			'user_id' => strval(session()->get('user_id')),
			'bans_host' => "banik.pl",
			'bans_user' => "banik_" . $bansUser,
			'bans_password' => $bansPassword,
			'bans_database' => "banik_" . $bansUser,
		];
		$bans->save($newBans);

		$config = [
			'user_name' => session()->get('user_name'),
			'user_email' => session()->get('user_email'),
			'user_password' => $user['user_password'],
			'bans_host' => "banik.pl",
			'bans_user' => "banik_" . $bansUser,
			'bans_password' => $bansPassword,
			'bans_database' => "banik_" . $bansUser,
		];

		$bans->editConfig($config);

		$logs = new LogsModel();
		$logs->addLog(['action' => 'Utworzono sourcebans']);

		return redirect()->to(base_url() . '/user');
	}

	public function profile()
	{
		$data = [];
		helper(['form']);
		$user = new UserModel();

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'firstname' => 'required|min_length[3]|max_length[20]',
				'lastname' => 'required|min_length[3]|max_length[20]',
			];

			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}


			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				$newData = [
					'id' => session()->get('id'),
					'firstname' => $this->request->getPost('firstname'),
					'lastname' => $this->request->getPost('lastname'),
				];
				if ($this->request->getPost('password') != '') {
					$newData['password'] = $this->request->getPost('password');
				}
				$user->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/profile');
			}
		}

		$data['user'] = $user->where('id', session()->get('id'))->first();
		echo view('templates/header', $data);
		echo view('profile');
		echo view('templates/footer');
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to(base_url());
	}

	private function setUserSession($user)
	{
		$data = [
			'user_id' => $user['user_id'],
			'user_name' => $user['user_name'],
			'user_email' => $user['user_email'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}


	//--------------------------------------------------------------------

}
