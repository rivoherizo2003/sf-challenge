<?php
/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 03/08/2018
 * Time: 23:41
 */

namespace AppBundle\Services;


class Utility
{
    /**
     * generate code
     * @param $p_sCode
     * @param $p_iStatus
     * @param $p_sPrefix
     * @param $p_iIsCodeMonthYear
     * @return string
     */
    public function generateCode($p_sCode, $p_iStatus, $p_sPrefix, $p_iIsCodeMonthYear){
        $l_dtDateTime   = new \DateTime();
        if ( $p_iIsCodeMonthYear == 1 ) //code with month and year
            $l_sMonthYear = sprintf("%s", substr($l_dtDateTime->format('m'), 0)) . substr($l_dtDateTime->format('Y'), -2);
        else //code with only year code
            $l_sMonthYear = sprintf("%s", substr($l_dtDateTime->format('Y'), -2));

        if ( empty($p_sCode) || is_null($p_sCode) ) {
            $l_sCode = sprintf("%s-%'.06d", $l_sMonthYear, 1);
        }
        else {
            $l_arrExplodedCode = explode('-', $p_sCode);
            if ( count($l_arrExplodedCode) >= 1 )
                $l_iLastId   = (int)$l_arrExplodedCode[1];
            else
                $l_iLastId = 0;

            $l_sNextId   = $l_iLastId + 1;
            $l_sCode = sprintf("%s-%'.06d", $l_sMonthYear, $l_sNextId);
        }
        if ( $p_iStatus == 0 ) { // suspended
            return trim("TMP". $p_sPrefix . $l_sCode);
        }
        else {
            return trim($p_sPrefix.$l_sCode);
        }
    }
}