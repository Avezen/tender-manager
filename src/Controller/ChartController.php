<?php

namespace App\Controller;

use Hisune\EchartsPHP\Config;
use Hisune\EchartsPHP\ECharts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChartController extends AbstractController
{
    /**
     * @Route("/charts/product-group", name="product_group_chart")
     */
    public function productGroupChart()
    {
        $chart = new ECharts();
        $chart->tooltip->show = true;
        $chart->legend->data[] = 'chart';
//        $chart->xAxis[] = array(
//            'type' => 'category',
//            'data' => array("1","2","3","4","5","6")
//        );
//        $chart->yAxis[] = array(
//            'type' => 'value'
//        );
        $chart->series[] = Config::jsExpr('
    {
            name:\'Grupy produktowe\',
            type:\'pie\',
            selectedMode: \'single\',
            radius: [0, \'30%\'],

            label: {
                normal: {
                    position: \'inner\'
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:[
                {value:335, name:\'Grupa #1\', selected:false},
                {value:679, name:\'Grupa #2\'},
                {value:1548, name:\'Grupa #3\'}
            ]
        },
        {
            name:\'Realizacja\',
            type:\'pie\',
            radius: [\'45%\', \'55%\'],
            color: [\'#c23531\',\'#2f4554\', \'#61a0a8\', \'green\', \'red\',\'#749f83\',  \'#ca8622\', \'#bda29a\',\'#6e7074\', \'#546570\', \'#c4ccd3\'],
            label: {
                normal: {
                    formatter: \'{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  \',
                    backgroundColor: \'#eee\',
                    borderColor: \'#aaa\',
                    borderWidth: 1,
                    borderRadius: 4,
                    // shadowBlur:3,
                    // shadowOffsetX: 2,
                    // shadowOffsetY: 2,
                    // shadowColor: \'#999\',
                    // padding: [0, 7],
                    rich: {
                        a: {
                            color: \'#999\',
                            lineHeight: 22,
                            align: \'center\'
                        },
                        // abg: {
                        //     backgroundColor: \'#333\',
                        //     width: \'100%\',
                        //     align: \'right\',
                        //     height: 22,
                        //     borderRadius: [4, 4, 0, 0]
                        // },
                        hr: {
                            borderColor: \'#aaa\',
                            width: \'100%\',
                            borderWidth: 0.5,
                            height: 0
                        },
                        b: {
                            fontSize: 16,
                            lineHeight: 33
                        },
                        per: {
                            color: \'#eee\',
                            backgroundColor: \'#334455\',
                            padding: [2, 4],
                            borderRadius: 2
                        }
                    }
                }
            },
            data:[
                {
                    value:335, 
                    name:\'Zrealizowane\',
                    backgroundColor: \'red\'
                },
                {value:310, name:\'Zrealizowane\'},
                {value:369, name:\'Niezrealizowane\'},
                {value:500, name:\'Zrealizowane\'},
                {value:1048, name:\'Niezrealizowane\'},
            ]
        }
        ');
        Config::$renderScript = false;

        //echo $chart->render('simple-custom-id');

        return $this->render('dashboard/index.html.twig', ['chart' => $chart->render('simple-custom-id')]);
    }
}
