<?php

function short_order_number($order_number)
{
	$order_number = explode('-', $order_number);
    return end($order_number);
}