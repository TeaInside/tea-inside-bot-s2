<?php

namespace Bot\LINE\Response\Command;

use LINE;
use Bot\LINE\Contracts\CommandContract;
use Bot\LINE\Abstraction\CommandFoundation;

class Jadwal extends CommandFoundation implements CommandContract
{
	public function jadwal()
	{
		$jadwals = [
			"senin" => [
				"Upacara",
				"Bahasa Indonesia",
				"Bahasa Indonesia",
				"Agama",
				"Istirahat",
				"Bahasa Jawa",
				"Bahasa Jawa",
				"B.Inggris",
				"Istirahat",
				"B.Inggris",
				"Seni Musik",
				"Seni Musik"
			],
			"selasa" => [
				"Ekonomi",
				"Ekonomi",
				"Matematika Minat",
				"Matematika Minat",
				"Istirahat",
				"Kimia",
				"Kimia",
				"B.Indonesia",
				"Istirahat",
				"B.Indonesia",
				"Kewirausahaan",
				"Kewirausahaan"
			],
			"rabu" => [
				"Fisika",
				"Fisika",
				"Matematika Wajib",
				"Matematika Wajib",
				"Istirahat",
				"Biologi",
				"Biologi",
				"Ekonomi",
				"Istirahat",
				"Ekonomi",
				"Sejarah",
				"Sejarah"
			],
			"kamis" => [
				"Agama",
				"Agama",
				"Fisika",
				"Fisika",
				"Istirahat",
				"PKN",
				"PKN",
				"Biologi",
				"Istirahat",
				"Biologi",
				"Matematika Minat",
				"Matematika Minat"
			],
			"jumat" => [
				"Kimia",
				"Kimia",
				"BK",
				"Penjaskes",
				"Istirahat",
				"Penjaskes",
				"Penjaskes",
				"Istirahat",
				"Sholat Jum'at",
				"Matematika Wajib",
				"Matematika Wajib"
			],
			"sabtu" => [
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama"
			],
			"minggu" => [
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama"
			]
		];		

		if (! isset($jadwals[$this->b['jadwalCmd']])) {
			$ld = [
				"senin" 	=> ["senen"],
				"selasa"	=> ["seloso"],
				"rabu"		=> ["rebo","rebu"],
				"kamis"		=> ["kemis"],
				"jumat"		=> ["jum'at","jum\"at"],
				"sabtu"		=> ["sebtu"],
				"minggu"	=> ["menggu"]
			];
			$flag = 0;
			foreach ($ld as $key => $val) {
				foreach ($val as $val) {
					if ($this->b['jadwalCmd'] === $val) {
						$jadwals = $jadwals[$key];
						$day = $key;
						$flag = 1;
						break;
					}
					if ($flag) {
						break;
					}
				}
			}
			if (! $flag) {
				return false;
			}
		} else {
			$day = $this->b['jadwalCmd'];
			if (isset($jadwals[$day])) {
				$jadwals = implode("\n", $jadwals[$day]);
			} else {
				return false;
			}
		}

		$text = "Jadwal Hari ".ucfirst($day)."\n\n".implode("\n", $jadwals);

		LINE::bg()::push(
			[
				"to" => $this->b['chatId'],
				"messages" => [
					[
						"type" => "text",
						"text" => $text
					]
				]
			]
		);
		return true;
	}
}
