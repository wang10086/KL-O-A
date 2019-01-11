<?php
namespace Main\Model;
use Think\Model;
use Sys\P;
class SalaryModel extends Model
{

    /**
     * individual_tax 个人所得税
     * $cout_money 个人金额 $userid 用户id
     */
    public function individual_tax($cout_money,$userid){
        $where['account_id']   = array('eq',$userid);
        $where['statu']        = array('neq',3);
        $tax                   = M('salary_individual_tax')->where('account_id='.$userid)->order('id DESC')->find();
        if($tax){
            $counting          = $tax['individual_tax'];
        }else{
            if($cout_money <= 5000){
                $counting      = '0';
            }else{
                $cout          = $cout_money-5000;
                if($cout <= 3000){
                    $countin   = $cout*0.03;
                }elseif($cout > 3000 && $cout <= 12000){
                    $countin   = $cout*0.10-210;
                }elseif($cout > 12000 && $cout <= 25000){
                    $countin   = $cout*0.20-1410;
                }elseif($cout > 25000 && $cout <= 35000){
                    $countin   = $cout*0.25-2660;
                }elseif($cout > 35000 && $cout <= 55000){
                    $countin   = $cout*0.30-4410;
                }elseif($cout > 55000 && $cout <= 80000){
                    $countin   = $cout*0.35-7160;
                }elseif($cout > 80000){
                    $countin   = $cout*0.45-15160;
                }
                $counting      = round($countin,2);
            }
        }
        return $counting;
    }

    /***
     * year_end 年终奖
     * $Year_end 年终金额
     */

    public function year_end($Year_end){

        if($Year_end < 1500){
            $price1   = $Year_end*0.03;
        }
        if($Year_end > 1500 && $Year_end < 4500){
            $price1   = $Year_end*0.1-105;
        }
        if($Year_end > 4500 && $Year_end < 9000){
            $price1   = $Year_end*0.2-555;
        }
        if($Year_end > 9000 && $Year_end < 35000){
            $price1   = $Year_end*0.25-1055;
        }
        if($Year_end > 35000 && $Year_end < 55000){
            $price1   = $Year_end*0.3-2755;
        }
        if($Year_end > 55000 && $Year_end < 80000){
            $price1   = $Year_end*0.35-5505;
        }
        if($Year_end>80000){
            $price1   = $Year_end*0.45-13505;
        }
        $price = round($price1,2);
        return $price;
    }


}
?>