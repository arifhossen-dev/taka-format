<?php

namespace Arifhossen\TakaFormat;

trait TakaFormat
{
    public function takaSeperatedByComma($amount = 0): string
    {
        $taka = "";

        // split the fractional part
        $amountArr = explode('.', $amount);

        $taka .= substr($amountArr[0], -3, 3); // to get hundreds
        $restAmount = substr($amountArr[0], 0, -3);

        while (strlen($restAmount) > 0) {
            $taka = substr($restAmount, -2, 2).','.$taka;
            $restAmount = substr($restAmount, 0, -2);
        }

        // adding fractional part if exists
        if (isset($amountArr[1])) {
            $taka = $taka.".".$amountArr[1];
        }

        return "৳".$taka;
    }

    public function takaInWords($amount = null): string
    {
        $amount ?: ""; // return if $amount is null

        $decimal = round($amount - ($no = floor($amount)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = [];
        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        ];
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $amount = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($amount) {
                $plural = (($counter = count($str)) && $amount > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($amount < 21) ? $words[$amount].' '.$digits[$counter].$plural.' '.$hundred : $words[floor($amount / 10) * 10].' '.$words[$amount % 10].' '.$digits[$counter].$plural.' '.$hundred;
            } else {
                $str[] = null;
            }
        }
        $Taka = implode('', array_reverse($str));
        $poysa = ($decimal) ? " and ".($words[$decimal / 10]." ".$words[$decimal % 10]).' poysa' : '';
        return ($Taka ? $Taka.'taka ' : '').$poysa;
    }
}