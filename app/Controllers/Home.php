<?php

namespace App\Controllers;

use App\Models\BansModel;
use App\Models\SbansModel;

class Home extends BaseController
{
	public function index()
	{
		if (!$count = cache('stats')) {
			$bans = new BansModel();
			$sbans = new SbansModel();

			$count = [
				'amxbans' => $count['amxbans'] = $bans->countAllResults(),
				'sourcebans' => $count['sourcebans'] = $sbans->countAllResults(),
			];

			// Save into the cache for 5 minutes
			cache()->save('stats', $count, 300);
		}

		return view('Index', $count);
	}

	public function contact()
	{
		$data['title'] = "Kontakt";
		return view('Contact', $data);
	}

	//--------------------------------------------------------------------

}
