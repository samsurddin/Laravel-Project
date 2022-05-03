<?php

function getCartItems($pid=NULL)
{
    start_session();
    // dd($_SESSION);
    // dd( isset($_SESSION['items'][$pid]) );
    if (!empty($_SESSION) && isset($_SESSION['items'])) {
        if (empty($pid)) {
            return $_SESSION['items'];
        } elseif ( isset($_SESSION['items'][$pid]) ) {
            return $_SESSION['items'][$pid];
        }
    }
    return false;
    // return !empty($_SESSION) && isset($_SESSION['items'])??(empty($pid)?$_SESSION['items']:(isset($_SESSION['items'][$pid])?$_SESSION['items'][$pid]:false));
}

function start_session()
{
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        // session isn't started
        session_start();
    }
}

function isExist($pid)
{
    return getCartItems($pid);
}

function getChargeAmount($chargeId=NULL)
{
    $charges = getCharges($chargeId);
    $chargeAmount = 0;
    if (is_array($charges) && !isset($charges['id'])) {
        foreach ($charges as $charge) {
            $chargeAmount += getCartCharge($charge);
        }
    } else $chargeAmount += getCartCharge($charges);
    return $chargeAmount;
}

function getCharges($chargeId=NULL)
{
    start_session();

    if (!empty($_SESSION) && isset($_SESSION['charges'])) {
        if (empty($chargeId)) {
            return $_SESSION['charges'];
        } elseif (isset($_SESSION['charges'][$chargeId])) {
            return $_SESSION['charges'][$chargeId];
        }
    }
    return false;
    // return empty($chargeId)?$_SESSION['charges']:(isset($_SESSION['charges'][$chargeId])?$_SESSION['charges'][$chargeId]:false);
}

function getCartCharge($charge)
{
    $chargeAmount = 0;
    if (isset($charge['type']) && isset($charge['amount']) && isset($charge['amount_type'])) {
        $calculated = calculateCharge($charge['amount'], $charge['amount_type']);
        if ($charge['type'] == 'promo') {
            $chargeAmount = $calculated<0?($chargeAmount+$calculated):($chargeAmount-$calculated);
        } else $chargeAmount += $calculated;
    }
    return $chargeAmount;
}

function calculateCharge($amount, $amount_type='plus', $subTotal=NULL)
{
    $item_subtotal = $subTotal?:getSubtotal();
    $chargeAmount = 0;
    if ($amount_type == 'percent') {
        $chargeAmount += $item_subtotal * ((int) $amount/100);
    }
    if ($amount_type == 'plus') {
        $chargeAmount += (int) $amount;
    }
    if ($amount_type == 'minus') {
        $chargeAmount -= (int) $amount;
    }
    if ($amount_type == 'multiply') {
        $chargeAmount += $item_subtotal * (int) $amount;
    }
    if ($amount_type == 'devide') {
        $chargeAmount += $item_subtotal / (int) $amount;
    }
    return $chargeAmount;
}

function getSubtotal($pid=NULL)
{
    $items = getCartItems($pid);
    if (!empty($pid) && isExist($pid)) {
        return $items['price'] * $items['quantity'];
    }
    $subTotal = 0;
    if (!empty($items) && is_array($items)) {
        foreach ($items as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }
    }
    return $subTotal;
}

function getTotalQuantity($item_count=false)
{
    $items = getCartItems();
    $qty = 0;
    if (!$items) {
        return $qty;
    }
    if ($item_count) {
        return count($items);
    }
    foreach ($items as $item) {
        $qty += $item['quantity'];
    }
    return $qty;
}

function getCartTotal($value='')
{
	return getSubtotal() + getChargeAmount();
}

function cart_clear()
{
    unset($_SESSION['items']);
    unset($_SESSION['charges']);
}