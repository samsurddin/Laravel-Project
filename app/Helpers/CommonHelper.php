<?php

use App\Models\Category;
use Carbon\Carbon;

function getCategoryTreeList($type='list', $category_tree=NULL)
{
	$cls = 'is_child';
	if (empty($category_tree)) {
		$category_tree = Category::where(['parent_id' => NULL])->with('parent')->with('child')->get()->toArray();
		$cls = '';
	}

	$output = '';
	if ($type == 'list') {
		$output .= '<ul class="cat-tree '.$cls.'">';
	}
	foreach ($category_tree as $all_cat) {
		$output .= '<li><a href="'. route('categories.show', $all_cat['slug']) .'">'.$all_cat['name'] . '</a>';
			if (!empty($all_cat['child'])){
				getCategoryTree('list', $all_cat['child']);
			}
		$output .= '</li>';
	}
	if ($type == 'list') {
		$output .= '</ul>';
	}

	echo $output;
}

function getCategoryTreeOption($selected='', $category_tree=NULL, $repeat=0)
{
	$desh = '-';
	if (empty($category_tree)) {
		$category_tree = Category::where(['parent_id' => NULL])->with('parent')->with('child')->get()->toArray();
		$desh = '';
	}

	// dd($category_tree);

	$desh = str_repeat($desh, $repeat);

	foreach ($category_tree as $all_cat) {
		if (empty($all_cat['parent_id'])) {
			$repeat = 0;
		}
		$opt_sel = '';
		if (!empty($selected) && $selected == $all_cat['id']) {
			$opt_sel = 'selected';
		}
		echo '<option value="'. $all_cat['id'] .'" '.$opt_sel.'>'.$desh.' '.$all_cat['name'] . '</option>';
		if (!empty($all_cat['child'])){
			$repeat++;
			getCategoryTreeOption($selected, $all_cat['child'], $repeat);
		}
	}
}

function mk_loc_dd($data, $selected_data=[])
{
	// dd($selected_data);
	$division_dd = '';
	$district_dd = '';
	foreach ($data as $division) {
		$selected = '';
		if (isset($selected_data['division']) && $selected_data['division'] == $division['id']) {
			$selected = 'selected';
		}
		$division_dd .= '<option value="'. $division['id'] .'" '. $selected .'>'. $division['name'] .'</option>';
		
		$district_dd .= '<optgroup label="'. $division['name'] .'">';
		foreach ($division['districts'] as $district) {
			$selected = '';
			if (isset($selected_data['district']) && $selected_data['district'] == $district['id']) {
				$selected = 'selected';
			}
			$district_dd .= '<option value="'. $district['id'] .'" '. $selected .'>'. $district['name'] .'</option>';
		}
		$district_dd .= '</optgroup>';
	}
	// dd($division_dd, $selected_data);
	return ['division_dd' => $division_dd, 'district_dd' => $district_dd];
}

function postcodes_dd($data, $selected='')
{
	$pc_dd = '';
	if (is_object($data) && !empty($data)) {
		foreach ($data as $pc) {
			$select_text = $pc->postCode 
							/* . ', ' . $pc->postOffice */ 
							. ', ' . $pc->upazila 
							. ', ' . $pc->district->name 
							. ', ' . $pc->division->name;

			$pc_dd .= generate_option($pc->postCode, $select_text, $selected);
		}
	}
	return $pc_dd;
}

function location_dd($data, $selected=[])
{
	$shipping_dd = $billing_dd = ['division'=>'', 'district'=>'', 'postcode'=>''];

	$selected_shipping = $selected['shipping']??($selected['division']??'');
	// dd($selected_shipping);
	$selected_billing = $selected['billing']??($selected['division']??'');
	foreach ($data as $division) {
		$shipping_dd['division'] .= generate_option($division['id'], $division['name'], $selected_shipping['division']);
		$billing_dd['division'] .= generate_option($division['id'], $division['name'], $selected_billing['division']);
		
		$shipping_dd['district'] .= '<optgroup type="division" label="'. $division['name'] .'">';
		$billing_dd['district'] .= '<optgroup type="division" label="'. $division['name'] .'">';

		$shipping_dd['postcode'] .= '<optgroup type="division" label="'. $division['name'] .'">';
		$billing_dd['postcode'] .= '<optgroup type="division" label="'. $division['name'] .'">';
		foreach ($division['city_with_postcodes'] as $district) {
			$shipping_dd['district'] .= generate_option($district['id'], $district['name'], $selected_shipping['district']);
			$billing_dd['district'] .= generate_option($district['id'], $district['name'], $selected_billing['district']);

			// postcode drop-down
			$shipping_dd['postcode'] .= '<optgroup type="district" label="'. $district['name'] .'">';
			$billing_dd['postcode'] .= '<optgroup type="district" label="'. $district['name'] .'">';
			foreach ($district['postcodes'] as $postcode) {
				$select_text = $postcode['postCode'] 
								/* . ', ' . $postcode['postOffice'] */ 
								. ', ' . $postcode['upazila'] 
								. ', ' . $district['name'] 
								. ', ' . $division['name'];
				// $additional = ' data-division="'.$postcode['division_id'].'" data-district="'.$postcode['district_id'].'"';

				$shipping_dd['postcode'] .= generate_option($postcode['postCode'], $select_text, $selected_shipping['postcode']);
				$billing_dd['postcode'] .= generate_option($postcode['postCode'], $select_text, $selected_billing['postcode']);
			}
			$shipping_dd['postcode'] .= '</optgroup>';
			$billing_dd['postcode'] .= '</optgroup>';
		}
		$shipping_dd['postcode'] .= '</optgroup>';
		$billing_dd['postcode'] .= '</optgroup>';

		$shipping_dd['district'] .= '</optgroup>';
		$billing_dd['district'] .= '</optgroup>';
	}

	return [
		'shipping' => $shipping_dd,
		'billing' => $billing_dd,
	];
}

function make_loc_dd($order=[])
{
    $divisions = App\Models\Division::select(['id', 'name'])->with('city_with_postcodes')->get()->toArray();
    // dd($divisions);

    if (!empty($order)) {
    	$order = is_object($order)?$order->toArray():$order;
	    $selected = [
	        'shipping' => [
	            'division' => old('shipping_state', $order['shipping_state']), 
	            'district' => old('shipping_city', $order['shipping_city']),
	            'postcode' => old('shipping_zip', $order['shipping_zipcode']),
	        ],
	        'billing' => [
	            'division' => old('billing_state', $order['billing_state']), 
	            'district' => old('billing_city', $order['billing_city']),
	            'postcode' => old('billing_zip', $order['billing_zipcode']),
	        ]
	    ];
    }

    return location_dd($divisions, $selected);
}

function generate_option($value='', $text='', $selected='', $additional='')
{
	if (!empty($selected) && $selected == $value) {
		$selected = 'selected';
	}
	return '<option value="'. $value .'" '. $selected .' '. $additional .'>'. $text .'</option>';
}

function show_date($date, $format='d M Y')
{
    return Carbon::parse($date)->format($format);
}

function date_to_human($date)
{
    return Carbon::parse($date)->diffForHumans();
}

function order_status_dd($statuses, $selected_id='')
{
	if (!is_array($statuses)) {
		$statuses = $statuses->toArray();
	}
	$order_status_dd = '';
    foreach ($statuses as $status) {
        $selected = '';
        if ($status['id'] == $selected_id) {
            $selected = 'selected="selected"';
        }
        $order_status_dd .= '<option value="'. $status['id'] .'" '. $selected .'>'. $status['title'] .'</option>';
    }
    return $order_status_dd;
}