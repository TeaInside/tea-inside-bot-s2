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
				"Bahasa Jawa",
				"Bahasa Jawa",
				"Agama",
				"Istirahat",
				"B.Inggris",
				"B.Inggris",
				"Fisika",
				"Istirahat",
				"Fisika",
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
				"Matematika Wajib",
				"Matematika Wajib",
				"Fisika",
				"Fisika",
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
				"B.Indonesia",
				"B.Indonesia",
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
		} else {
			$jadwals = $jadwals[$day = $this->b['jadwalCmd']];
		}

		$text = "Jadwal Hari ".ucfirst($day)."\n\n".implode("\n", $jadwals);

		LINE::push(
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
	}
}
