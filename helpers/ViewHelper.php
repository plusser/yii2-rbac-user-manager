<?php

namespace rbacUserManager\helpers;

use crud\interfaces\SearchModelInterface;
use yii\jui\DatePicker;

class ViewHelper
{

    public static function GridViewDateTimeColumn(SearchModelInterface $searchModel, string $attribute): array
    {
        return [
            'attribute'         => $attribute,
            'value'             => function($data) use ($attribute){return date('d-m-Y H:i:s', $data->{$attribute});},
            'headerOptions'     => ['style'	=> 'text-align: center;'],
            'contentOptions'    => ['style'	=> 'text-align: center;'],
            'filterOptions'     => ['style'	=> 'width: 180px;'],
            'filter'            => DatePicker::widget([
                'model'         => $searchModel,
                'attribute'     => $attribute,
                'language'      => 'ru',
                'dateFormat'    => 'yyyy-MM-dd',
                'options'       => ['class'	=> 'form-control'],
            ]),
        ];
    }

}
