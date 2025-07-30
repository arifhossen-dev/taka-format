<?php

namespace Arifhossen\TakaFormat;

trait TakaFormat
{
    /**
     * Format a number as Bangladeshi Taka with comma separation.
     *
     * @param float|int|string $amount
     * @return string
     */
    public function takaSeperatedByComma($amount = 0): string
    {
        // Ensure $amount is numeric and not null/empty
        $amount = (float)($amount ?? 0);

        // Split integer and fractional parts
        $parts = explode('.', number_format($amount, 2, '.', ''));

        $integerPart = $parts[0];
        $fractionalPart = $parts[1] ?? null;

        // Handle negative numbers
        $isNegative = false;
        if (strpos($integerPart, '-') === 0) {
            $isNegative = true;
            $integerPart = ltrim($integerPart, '-');
        }

        // Format integer part in Bangladeshi style
        $formatted = '';
        $len = strlen($integerPart);

        if ($len > 3) {
            $formatted = substr($integerPart, -3);
            $integerPart = substr($integerPart, 0, $len - 3);

            while (strlen($integerPart) > 0) {
                $formatted = substr($integerPart, -2) . ',' . $formatted;
                $integerPart = substr($integerPart, 0, -2);
            }
        } else {
            $formatted = $integerPart;
        }

        // Add fractional part if exists
        if ($fractionalPart !== null && $fractionalPart !== '00') {
            $formatted .= '.' . $fractionalPart;
        }

        $result = ($isNegative ? '-' : '') . "৳" . $formatted;
        return $result;
    }

    /**
     * Convert a number to Bangladeshi Taka in words.
     *
     * @param float|int|string|null $amount
     * @return string
     */
    public function takaInWords($amount = null): string
    {
        $amount = (float)($amount ?? 0);

        if ($amount == 0) {
            return 'Zero Taka';
        }

        $no = floor($amount);
        $decimal = round(($amount - $no) * 100);

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
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        ];
        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

        $str = [];
        $i = 0;
        $digits_length = strlen($no);

        while ($no > 0) {
            $divider = ($i == 1) ? 10 : 100;
            $number = $no % $divider;
            $no = (int)($no / $divider);

            if ($number) {
                $counter = count($str);
                $plural = ($counter && $number > 9) ? 's' : '';
                $hundred = ($counter == 1 && isset($str[0]) && $str[0]) ? ' and ' : '';
                if ($number < 21) {
                    $str[] = $words[$number] . ' ' . $digits[$counter] . $plural . $hundred;
                } else {
                    $str[] = $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . $hundred;
                }
            } else {
                $str[] = null;
            }
            $i += ($divider == 10) ? 1 : 2;
        }

        $taka = implode('', array_reverse(array_filter($str)));
        $poysa = '';

        if ($decimal) {
            if ($decimal < 21) {
                $poysa = ' and ' . $words[$decimal] . ' Poysa';
            } else {
                $poysa = ' and ' . $words[floor($decimal / 10) * 10] . ' ' . $words[$decimal % 10] . ' Poysa';
            }
        }

        $result = trim($taka ? $taka . 'Taka' : '') . $poysa;
        return ucwords(trim($result));
    }
}