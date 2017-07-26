<?php

class NumberToLettersService
{
    public function numberToLetters($full)
    {
        if (!$full) {
            return '';
        }
        $edinici = [
            0 => '',
            1 => 'един',
            2 => 'два',
            3 => 'три',
            4 => 'четири',
            5 => 'пет',
            6 => 'шест',
            7 => 'седем',
            8 => 'осем',
            9 => 'девет',
        ];
        $desetici = [
            0  => 'десет',
            1  => 'единадесет',
            2  => 'дванадесет',
            3  => 'тринадесет',
            4  => 'четиринадесет',
            5  => 'петнадесет',
            6  => 'шестнадесет',
            7  => 'седемнадесет',
            8  => 'осемнадесет',
            9  => 'деветнадесет',
            10 => [
                2 => 'двадесет',
                3 => 'тридесет',
                4 => 'четиридесет',
                5 => 'петдесет',
                6 => 'шестдесет',
                7 => 'седемдесет',
                8 => 'осемдесет',
                9 => 'деветдесет',
            ],
        ];
        $stotici = [
            0 => '',
            1 => 'сто',
            2 => 'двеста',
            3 => 'триста',
            4 => 'четиристотин',
            5 => 'петстотин',
            6 => 'шестстотин',
            7 => 'седемстотин',
            8 => 'осемстотин',
            9 => 'деветстотин',
        ];
        $num    = explode('.', $full)[0];
        $array  = explode('.', $full);
        $penies = 0;
        if (isset($array[1])) {
            $penies = $array[1];
        }
        $e   = $num % 10;
        $d   = ($num / 10) % 10;
        $s   = ($num / 100) % 10;
        $h   = ($num / 1000) % 10;
        $dh  = ($num / 10000) % 10;
        $str = '';
        if ($d == 1 && strlen((string) $num) <= 2) {
            $str = $desetici[$e];
        } elseif ($d == 0) {
            $str = $edinici[$e];
        } elseif ($d > 1) {
            $str = $desetici[10][$d];
        } elseif ($d == 1 && $e == 0 && strlen((string) $num) > 2) {
            $str = ' и ' . $desetici[$e];
        } elseif ($d == 1 && strlen((string) $num) > 2) {
            $str = ' ' . $desetici[$e];
        }
        if ($d > 1 && $e) {
            $str = $str . ' и ' . $edinici[$e];
        }
        if ($s && !$d && !$e) {
            $str = $stotici[$s];
        } elseif ($s && (!$d || $d == 1) && $e) {
            $str = $stotici[$s] . ' и ' . $str;
        } else {
            $str = $stotici[$s] . ' ' . $str;
        }

        if ($h && !$s && !$d && !$e && strlen((string) $num) < 5) {
            if ($h == 1) {
                $str = 'хиляда ';
            } elseif ($h == 2) {
                $str = 'две хиляди';
            } else {
                $str = $edinici[$h] . ' хиляди ';
            }
        } elseif ($h && $s && (!$d || $d == 1) && $e && !$dh) {
            if ($h == 1) {
                $str = 'хиляда ' . $str;
            } elseif ($h == 2) {
                $str = 'две хиляди ' . $str;
            } else {
                $str = $edinici[$h] . ' хиляди ' . $str;
            }
        } elseif ($h && !$dh) {
            if (!$d) {
                if ($h == 1) {
                    $str = 'хиляда и' . $str;
                } elseif ($h == 2) {
                    $str = 'две хиляди и' . $str;
                } else {
                    $str = $edinici[$h] . ' хиляди и' . $str;
                }
            } elseif (!$s && $d) {
                if ($h == 1) {
                    $str = 'хиляда и' . $str;
                } elseif ($h == 2) {
                    $str = 'две хиляди и' . $str;
                } else {
                    $str = $edinici[$h] . ' хиляди и' . $str;
                }
            } else {
                if ($h == 1) {
                    $str = 'хиляда ' . $str;
                } elseif ($h == 2) {
                    $str = 'две хиляди ' . $str;
                } else {
                    $str = $edinici[$h] . ' хиляди ' . $str;
                }
            }
        }
        if ($dh && $h == 0) {
            $str = $desetici[$h] . ' хиляди ' . $str;
        } elseif ($dh == 1) {
            $str = $desetici[$h] . ' хиляди ' . $str;
        } elseif ($dh > 1) {
            $str = $desetici[10][$dh] . ' и ' . $edinici[$h] . ' хиляди ' . $str;
        }
        if ($penies) {
            $e   = $penies % 10;
            $d   = ($penies / 10) % 10;
            $pen = '';
            if ($d == 1 && strlen((string) $penies) <= 2) {
                $pen = $desetici[$e];
            } elseif ($d == 0) {
                $pen = $edinici[$e];
            } elseif ($d > 1) {
                $pen = $desetici[10][$d];
            } elseif ($d == 1 && $e == 0 && strlen((string) $penies) > 2) {
                $pen = ' и ' . $desetici[$e];
            } elseif ($d == 1 && strlen((string) $penies) > 2) {
                $pen = ' ' . $desetici[$e];
            }
            if ($d > 1 && $e) {
                $pen = $pen . ' и ' . $edinici[$e];
            }
        }
        if (isset($pen)) {
            if ($num == 1) {
                if ($penies == 1) {
                    return $str . ' лев и една стотинка';
                }
                return $str . ' лев и ' . $pen . ' стотинки';
            }
            if ($penies == 1) {
                return $str . ' лева и една стотинка';
                # code...
            }
            return $str . ' левa и ' . $pen . ' стотинки';
        }
        if ($num == 1) {
            return $str . ' лев';
        }
        return $str . ' лева';
    }
}
