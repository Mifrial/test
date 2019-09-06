<?php

function myfseek(&$fl, $npos) // некоторые символы могут быть 2 байта, как смвол 0Ah, поэтому стандартная функция не сработает. тк размеры ключей(и данных) не одинаковы, ускорить процесс не выйдет
{
    fseek($fl, 0);
    while ($npos > 0)
    {
        fgetc($fl);
        $npos--;
    }
}

function bsearch($fname, $skey)
{
    define("ED", chr(10));
    define("EK", chr(9));
    
    if ($fname != null && $skey != null)
    {
        $ffs = fopen($fname, "rt");
        $min = 0;
        $max = -1;
        while (!feof($ffs))
        {
            fgetc($ffs);
            $max++;
        }
        $key = "";
        $tr = 0;

        while ($key != $skey && $min != $max)
        {            
            $pos = ceil(($max - $min) / 2 + $min); //переходим в середину не проверенного диапазона
            //находим границы ключа и его значения

            $ch = '';
            
            myfseek($ffs, $pos);
            $ch = fgetc($ffs);
            while ($ch != ED && $pos > $min)
            {
                $pos--;
                myfseek($ffs, $pos);
                $ch = fgetc($ffs);
            }

            if ($pos != $min) $pos++;

            $spos = $pos; //мы нашли начало этой записи

            myfseek($ffs, $pos);
            $key = "";
            

            $ch = fgetc($ffs);
            
            while ($ch != EK && $ch != ED && $pos < $max)
            {
                $key .= $ch;
                $pos++;
                $ch = fgetc($ffs);
            } //мы считали ключ

            if ($ch == ED || $pos == $max) 
            {                
                fclose($ffs);
                return null; // ошибка в файле
            }

            $pos++;
            $tr = $pos;
            $ch = fgetc($ffs); // пропускаем ED символ

            while ($ch != ED && $pos < $max)
            {
                $pos++;
                $ch = fgetc($ffs);
            } //мы нашли конец записи

            if ($pos != $max) $pos++; //начало следующей записи
            
            if (strcmp($skey, $key) == 1) //если наше значение меньше
            {
                $min = $pos;
            } else
            {
                if (strcmp($skey, $key) == -1) $max = $spos; //если наше значение меньше                    
            }
        }

        if ($min == $max)
        {
            fclose($ffs);
            return null;
        } // значение не найдено
        // раз не выкинуло - оно найдено, читаем и даём значение
        
        $skey = ""; //теперь это переменная для записи значения
        myfseek($ffs, $tr);
        $ch = fgetc($ffs);
        while ($ch != ED && $tr < $max)
        {
            $skey .= $ch;
            $tr++;
            $ch = fgetc($ffs);
        } // получена
        fclose($ffs);
        return $skey;
    }
    return null;
}

?>
