<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class OvertimeSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
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

	public function map($item): array
	{
		return [
			$item->requestor_name,
			$item->ot_classification,
			$item->shift_date,
			$item->day_name,
			$item->time_start,
			$item->time_end,
			$item->total_hours,
			$item->reason,
			$item->rest_day ? 'Yes' : 'No',
			$item->approver_name,
			$item->approved_at,
		];
	}

	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Overtimes';
	}

	public function headings(): array
	{
		return [
			'Requested By',
			'OT Classification',
			'Date',
			'Day of Week',
			'Start Time',
			'End Time',
			'Total Hours',
			'Reason',
			'Is Rest Day',
			'Approved By',
			'Approved At',
		];
	}
}
