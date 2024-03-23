<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceSummarySheet implements WithTitle, WithHeadings, FromArray, WithMapping
{
	private $item;

	public function __construct($item)
	{
		$this->item = $item;
	}

	public function array(): array
	{
		return $this->item;
	}

	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Attendance Summary';
	}

	public function headings(): array
	{
		return [
			'Employee',
			'Days Present',
			'Days Absent',
			'Late Minutes',
			'Undertime Minutes',
			'Total Lates Min',
			'Total Hours',
		];
	}

	public function map($item): array
	{
		return [
			(string) $item['user'],
			(string) $item['days_present'],
			(string) $item['numberOfAbsences'],
			(string) $item['total_lates'],
			(string) $item['total_undertimes'],
			(string) $item['total_lates_undertimes'],
			(string) $item['total_hours'],
		];
	}
}
