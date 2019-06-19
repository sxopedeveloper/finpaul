<?php
class Utilities
{
	public function __construct()
	{
		
	}

	private function array_to_csv($array)
	{
		if (count($array) == 0)
		{
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($array)));
		foreach ($array as $row) 
		{
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}

    public function csv_to_array($file)
    {
		if(($handle = fopen($file, 'r')) !== FALSE)
		{
			$array = array();
			while(!feof($handle))
			{
				$array[] = fgetcsv($handle, 0);
			}
			return $array;
		}
    }

	public function export_custom_report($data, $title)
	{
		$filename = "data_export_" . date("Y-m-d") . ".csv";

		header('Content-Type: text/csv; charset=UTF-8');
		header("Cache-Control: no-store, no-cache");  
		header("Content-Disposition: attachment;filename=".$title."_".date("Y-m-d").".csv");

		echo $this->array_to_csv($data);
	}

	public function substring_index ($subject, $delim, $count)
    {
        if ($count < 0) 
		{
            return implode($delim, array_slice(explode($delim, $subject), $count));
        } 
        else 
		{
            return implode($delim, array_slice(explode($delim, $subject), 0, $count));
        }
    }

    public function calculate_revenue ($input_arr)
    {

    }

    public function calculate_commissionable_gross ($input_arr)
    {

    }

	public function calculate_quote ($input_arr)
	{
		$subtotal_1 = $input_arr['retail_price'] - $quote_details['fleet_discount'] - $quote_details['dealer_discount'];
		$subtotal_2 = $subtotal_1 + $input_arr['options_total'] + $input_arr['accessories_total'] + $quote_details['predelivery'];
		$gst = ($subtotal_2) * 0.10;
		$subtotal_3 = $subtotal_2 + $gst;
		$total = $subtotal_3 + $input_arr['luxury_tax'] + $input_arr['ctp']  + $input_arr['registration'] + $input_arr['premium_plate_fee'] + $input_arr['stamp_duty'];

		$output_arr = array {
			'subtotal_1' => $subtotal_1,
			'subtotal_2' => $subtotal_2,
			'gst' => $gst,
			'subtotal_3' => $subtotal_3,
			'total' => $total
		}

		return $output_arr;
	}
}
?>