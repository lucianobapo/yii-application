<script type="text/javascript">
    var app = angular.module('app', []);

    app.directive('graficoLinhaHachurada', function () {
        return {
            // atribuímos em forma de classe css nesse caso
            restrict: 'C',
            link: function (scope, element, attrs) {
                //some data
                var d1 = [[1, 3+randNum()], [2, 6+randNum()], [3, 9+randNum()], [4, 12+randNum()],[5, 15+randNum()],[6, 18+randNum()],[7, 21+randNum()],[8, 15+randNum()],[9, 18+randNum()],[10, 21+randNum()],[11, 24+randNum()],[12, 27+randNum()],[13, 30+randNum()],[14, 33+randNum()],[15, 24+randNum()],[16, 27+randNum()],[17, 30+randNum()],[18, 33+randNum()],[19, 36+randNum()],[20, 39+randNum()],[21, 42+randNum()],[22, 45+randNum()],[23, 36+randNum()],[24, 39+randNum()],[25, 42+randNum()],[26, 45+randNum()],[27,38+randNum()],[28, 51+randNum()],[29, 55+randNum()], [30, 60+randNum()]];
                var d2 = [[1, randNum()-5], [2, randNum()-4], [3, randNum()-4], [4, randNum()],[5, 4+randNum()],[6, 4+randNum()],[7, 5+randNum()],[8, 5+randNum()],[9, 6+randNum()],[10, 6+randNum()],[11, 6+randNum()],[12, 2+randNum()],[13, 3+randNum()],[14, 4+randNum()],[15, 4+randNum()],[16, 4+randNum()],[17, 5+randNum()],[18, 5+randNum()],[19, 2+randNum()],[20, 2+randNum()],[21, 3+randNum()],[22, 3+randNum()],[23, 3+randNum()],[24, 2+randNum()],[25, 4+randNum()],[26, 4+randNum()],[27,5+randNum()],[28, 2+randNum()],[29, 2+randNum()], [30, 3+randNum()]];
                //define placeholder class
                //var placeholder = $(element);
                //graph options
                var options = {
                    grid: {
                        show: true,
                        aboveData: true,
                        color: "#3f3f3f" ,
                        labelMargin: 5,
                        axisMargin: 0,
                        borderWidth: 0,
                        borderColor:null,
                        minBorderMargin: 5 ,
                        clickable: true,
                        hoverable: true,
                        autoHighlight: true,
                        mouseActiveRadius: 20
                    },
                    series: {
                        grow: {
                            active: false,
                            stepMode: "linear",
                            steps: 50,
                            stepDelay: true
                        },
                        lines: {
                            show: true,
                            fill: true,
                            lineWidth: 4,
                            steps: false
                        },
                        points: {
                            show:true,
                            radius: 5,
                            symbol: "circle",
                            fill: true,
                            borderColor: "#fff"
                        }
                    },
                    legend: {
                        position: "ne",
                        margin: [0,-25],
                        noColumns: 0,
                        labelBoxBorderColor: null,
                        labelFormatter: function(label, series) {
                            // just add some space to labes
                            return label+'&nbsp;&nbsp;';
                        }
                    },
                    yaxis: { min: 0 },
                    xaxis: {ticks:11, tickDecimals: 0},
                    colors: chartColours,
                    shadowSize:1,
                    tooltip: true, //activate tooltip
                    tooltipOpts: {
                        content: "%s : %y.0",
                        shifts: {
                            x: -30,
                            y: -50
                        }
                    }
                };

                $.plot(element, [

                    {
                        label: "Visits",
                        data: d1,
                        lines: {fillColor: "#f2f7f9"},
                        points: {fillColor: "#88bbc8"}
                    },
                    {
                        label: "Unique Visits",
                        data: d2,
                        lines: {fillColor: "#fff8f2"},
                        points: {fillColor: "#ed7a53"}
                    }

                ], options);
            }
        }
    });


    app.directive('graficoLinha', function () {
        return {
            // atribuímos em forma de classe css nesse caso
            restrict: 'C',
            link: function (scope, element, attrs) {

                var d1 = [
                    <?php
                        $primeira_data=time();

                        $criteria=new CDbCriteria;
		                $criteria->compare('empresa','ilhanet');
		                $criteria->compare('tipo','venda');
		                $criteria->compare('status_fechado',1);
		                $criteria->compare('status_cancelado',0);
		                $criteria->order='data_termino';
                        $ordens=ErpnetOrdem::model()->findAll($criteria);
                        $saida='';
                        $soma=0;
                        $datas=array();
                        foreach ($ordens as $ordem) {
                            if ($ordem->data_termino<$primeira_data) $primeira_data=$ordem->data_termino;
                            $soma=$soma+(is_object($ordem)?$ordem->valor:'0');
                            $datas[$ordem->data_termino]=$soma;
                            //$saida=$saida."[".($ordem->data_termino*1000).", $soma],";
                        }
                        foreach ($datas as $key=>$valor) {
                            $saida=$saida."[".($key*1000).", $valor],";
                        }
                        echo substr($saida, 0, -1);
                    ?>

                ];
                var d2 = [
                    <?php
                        $criteria=new CDbCriteria;
		                $criteria->compare('empresa','ilhanet');
		                $criteria->compare('tipo','compra');
		                $criteria->compare('status_fechado',1);
		                $criteria->compare('status_cancelado',0);
		                $criteria->order='data_termino';
                        $ordens=ErpnetOrdem::model()->findAll($criteria);
                        $saida='';
                        $soma=0;
                        $datas=array();
                        //echo '<pre>'.CVarDumper::dumpAsString($ordens).'</pre>';
                        foreach ($ordens as $ordem) {
                            if ($ordem->data_termino<$primeira_data) $primeira_data=$ordem->data_termino;
                            $soma=$soma+(is_object($ordem)?$ordem->valor:'0');
                            $datas[$ordem->data_termino]=$soma;
                            //$saida=$saida."[".($ordem->data_termino*1000).", $soma],";
                        }
                        foreach ($datas as $key=>$valor) {
                            $saida=$saida."[".($key*1000).", $valor],";
                        }
                        echo substr($saida, 0, -1);
                    ?>
                ];

                $.plot(element, [
                    { label: "<?php echo Helpers::t('appUi','Despesas'); ?>", data: d2,color: "#AA4643" },
                    { label: "<?php echo Helpers::t('appUi','Receitas'); ?>", data: d1,color: "#89A54E" }

                    //{ label: "tan(x)", data: d3 }
                ], {
                    series: {
                        lines: { show: true },
                        points: { show: true }
                    },

                    xaxis: {
                        min: <?php echo strtotime('-1 month',$primeira_data)*1000; ?>,
                        max: (new Date()).getTime(),
                        mode: "time",
                        timeformat: "%b/%Y",
                        tickSize: [1, "month"],
                        //monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        //tickLength: 0, // hide gridlines
                        axisLabel: 'Month'/*,
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                        //axisLabelPadding: 5*/
                    },

                    legend: {
                        position: "ne",
                        margin: [0,-25],
                        noColumns: 0,
                        labelBoxBorderColor: null,
                        labelFormatter: function(label, series) {
                            // just add some space to labes
                            return label+'&nbsp;&nbsp;';
                        }
                    },
                    grid: {
                        backgroundColor: { colors: [ "#fff", "#eee" ] },
                        borderWidth: {
                            top: 1,
                            right: 1,
                            bottom: 2,
                            left: 2
                        }
                    }
                });
            }
        }
    });

    app.directive('graficoBarras', function () {
        return {
            // atribuímos em forma de classe css nesse caso
            restrict: 'C',
            link: function (scope, element, attrs) {
                var d1 = [
                    <?php
                        $primeira_data=time();
                        $consulta= new DbAccess();
                        $ordens=$consulta->getDespesas('venda');
                        //die ('<pre>'.CVarDumper::dumpAsString($consulta->getDespesas('compra')).'</pre>');
                        $saida='';
                        foreach ($ordens as $ordem) {
                            if (strtotime($ordem['data'])<$primeira_data) $primeira_data=strtotime($ordem['data']);
                            $saida=$saida."[".(strtotime($ordem['data'])*1000).", ".$ordem['valor']."],";
                        }
                        echo substr($saida, 0, -1);
                    ?>

                ];
                var d2 = [
                    <?php
                        $consulta= new DbAccess();
                        $ordens=$consulta->getDespesas('compra');
                        //die ('<pre>'.CVarDumper::dumpAsString($consulta->getDespesas('compra')).'</pre>');
                        $saida='';
                        foreach ($ordens as $ordem) {
                            if (strtotime($ordem['data'])<$primeira_data) $primeira_data=strtotime($ordem['data']);
                            $saida=$saida."[".(strtotime($ordem['data'])*1000).", ".$ordem['valor']."],";
                        }
                        echo substr($saida, 0, -1);
                    ?>
                ];

                var data1 = [

                    {
                        label: "<?php echo Helpers::t('appUi','Despesas'); ?>",
                        data: d2,
                        stack: false,
                        //align: 'center',
                        bars: {
                            show: true,
                            align: "right",
                            //barWidth: 1/4,
                            barWidth: 12*24*60*60*300,

                            fill: true,
                            lineWidth: 1,
                            //order: 2,
                            fillColor:  "#AA4643"
                        },
                        color: "#AA4643"
                    },

                    {
                        label: "<?php echo Helpers::t('appUi','Receitas'); ?>",
                        data: d1,
                        stack: false,
                        bars: {
                            show: true,
                            align: "left",
                            //barWidth: 1/4,
                            barWidth: 12*24*60*60*300,

                            fill: true,
                            lineWidth: 1,
                            //order: 1,
                            fillColor:  "#89A54E"
                        },
                        color: "#89A54E"
                    }

                ];

                var options = {
                    /**/
                    xaxis: {
                        min: <?php echo strtotime('-1 month',$primeira_data)*1000; ?>,
                        max: (new Date()).getTime(),
                        mode: "time",
                        timeformat: "%b/%Y",
                        tickSize: [1, "month"],
                        //monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        //tickLength: 0, // hide gridlines
                        axisLabel: 'Month',
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                        axisLabelPadding: 5

                    },
                    yaxis: {
                        axisLabel: 'Value',
                            axisLabelUseCanvas: true,
                            axisLabelFontSizePixels: 12,
                            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                            axisLabelPadding: 5
                    },
                    grid: {
                        hoverable: true,
                            clickable: false,
                            borderWidth: 1
                    },
                    legend: {
                        position: "ne",
                        margin: [0,-25],
                        noColumns: 0,
                        labelBoxBorderColor: null,
                        labelFormatter: function(label, series) {
                            // just add some space to labes
                            return label+'&nbsp;&nbsp;';
                        }
                    },
                    series: {
                        shadowSize: 1
                    }
                };

                $.plot(element, data1,options);
            }
        }
    });

</script>