<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceLogSheet implements FromQuery, WithTitle, WithHeadings
{
	private $query;

	public function __construct($query)
	{
		$this->query = $query;
	}

	/**
	 * @return Builder
	 */
	public function query()
	{
		return $this->query;
	}

	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Attendance Logs';
	}

	public function headings(): array
	{
		return [
			'Employee',
			'Date',
			'Clock In',
			'Break Start',
			'Break End',
			'Clock Out',
			'Total Hours',
		];
	}
}
