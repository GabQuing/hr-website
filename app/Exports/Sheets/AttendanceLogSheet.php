<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceLogSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
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
			'Is Rest Day'
		];
	}

	public function map($item): array
	{
		return [
			$item->name,
			$item->log_date,
			$item->clock_in,
			$item->break_start,
			$item->break_end,
			$item->clock_out,
			$item->total_hours,
			$item->rest_day ? 'Yes' : 'No',
		];
	}
}
