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

                /*
                var sin = [], cos = [];
                for (var i = 0; i < 14; i += 0.5) {
                    sin.push([i, Math.sin(i)]);
                    cos.push([i, Math.cos(i)]);
                }

                var d1 = [
                    <?php
                        $criteria=new CDbCriteria;
		                $criteria->compare('empresa','ilhanet');
		                $criteria->compare('tipo','venda');
		                $criteria->compare('status_fechado',1);
		                $criteria->compare('status_cancelado',0);
		                $criteria->order='data_termino';
                        $ordens=ErpnetOrdem::model()->findAll($criteria);
                        $saida='';
                        $soma=0;
                        //echo '<pre>'.CVarDumper::dumpAsString($ordens).'</pre>';
                        foreach ($ordens as $ordem) {
                            $soma=$soma+(is_object($ordem)?$ordem->valor:'0');
                            //echo "[(".(strtotime("+".($i-1)." days",$ordem->data_termino))." * 1000), $soma],";
                            $saida=$saida."[(".$ordem->data_termino." * 1000), $soma],";
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
                        //echo '<pre>'.CVarDumper::dumpAsString($ordens).'</pre>';
                        foreach ($ordens as $ordem) {
                            $soma=$soma+(is_object($ordem)?$ordem->valor:'0');
                            $saida=$saida."[(".$ordem->data_termino." * 1000), $soma],";
                        }
                        echo substr($saida, 0, -1);
                    ?>
                ];

                sin = d1;
                cos = d2;


                //graph options
                var options = {
                    xaxis: {
                        mode: "time",
                        //minTickSize: [1, "day"],
                        timeformat: "%d/%m"
                    },


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
                        grow: {active: false},
                        lines: {
                            show: true,
                            fill: false,
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
                    //legend: { position: "se" },
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
                    colors: chartColours,
                    shadowSize:1,
                    tooltip: true, //activate tooltip
                    tooltipOpts: {
                        content: "%s : %y.3",
                        shifts: {
                            x: -30,
                            y: -50
                        }
                    }
                };
                var plot = $.plot(element,
                    [{
                        label: "",
                        data: sin,
                        lines: {fillColor: "#f2f7f9"},
                        points: {fillColor: "#88bbc8"}
                    },
                        {
                            label: "",
                            data: cos,
                            lines: {fillColor: "#fff8f2"},
                            points: {fillColor: "#ed7a53"}
                        }], options);*/
                var d1 = [
                    <?php
                        $criteria=new CDbCriteria;
		                $criteria->compare('empresa','ilhanet');
		                $criteria->compare('tipo','venda');
		                $criteria->compare('status_fechado',1);
		                $criteria->compare('status_cancelado',0);
		                $criteria->order='data_termino';
                        $ordens=ErpnetOrdem::model()->findAll($criteria);
                        $saida='';
                        $soma=0;
                        //echo '<pre>'.CVarDumper::dumpAsString($ordens).'</pre>';
                        foreach ($ordens as $ordem) {
                            $soma=$soma+(is_object($ordem)?$ordem->valor:'0');
                            //echo "[(".(strtotime("+".($i-1)." days",$ordem->data_termino))." * 1000), $soma],";
                            //$saida=$saida."[(".$ordem->data_termino." * 1000), $soma],";
                            $saida=$saida."[".($ordem->data_termino*1000).", $soma],";
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
                        //echo '<pre>'.CVarDumper::dumpAsString($ordens).'</pre>';
                        foreach ($ordens as $ordem) {
                            $soma=$soma+(is_object($ordem)?$ordem->valor:'0');
                            $saida=$saida."[".($ordem->data_termino*1000).", $soma],";
                        }
                        echo substr($saida, 0, -1);
                    ?>
                ];

                /*
                var d1 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.25) {
                    d1.push([i, Math.sin(i)]);
                }

                var d2 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.25) {
                    d2.push([i, Math.cos(i)]);
                }

                var d3 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.1) {
                    d3.push([i, Math.tan(i)]);
                }*/

                $.plot(element, [
                    { label: "<?php echo Helpers::t('appUi','Receitas'); ?>", data: d1 },
                    { label: "<?php echo Helpers::t('appUi','Despesas'); ?>", data: d2 }
                    //{ label: "tan(x)", data: d3 }
                ], {
                    series: {
                        lines: { show: true },
                        points: { show: true }
                    },
                    /*
                    xaxis: {
                        min: (new Date(2011, 11, 15)).getTime(),
                        max: (new Date(2012, 04, 18)).getTime(),
                        mode: "time",
                        timeformat: "%b",
                        tickSize: [1, "month"],
                        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        tickLength: 0, // hide gridlines
                        axisLabel: 'Month',
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                        axisLabelPadding: 5
                    },

                    xaxis: {
                        ticks: [
                            0, [ Math.PI/2, "\u03c0/2" ], [ Math.PI, "\u03c0" ],
                            [ Math.PI * 3/2, "3\u03c0/2" ], [ Math.PI * 2, "2\u03c0" ]
                        ]
                    },
                    yaxis: {
                        ticks: 10,
                        min: -2,
                        max: 2,
                        tickDecimals: 3
                    },*/
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
                var d1 = [];
                for (var i = 0; i < 14; i += 0.5) {
                    d1.push([i, Math.sin(i)]);
                }

                var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];

                var d3 = [];
                for (var i = 0; i < 14; i += 0.5) {
                    d3.push([i, Math.cos(i)]);
                }

                var d4 = [];
                for (var i = 0; i < 14; i += 0.1) {
                    d4.push([i, Math.sqrt(i * 10)]);
                }

                var d5 = [];
                for (var i = 0; i < 14; i += 0.5) {
                    d5.push([i, Math.sqrt(i)]);
                }

                var d6 = [];
                for (var i = 0; i < 14; i += 0.5 + Math.random()) {
                    d6.push([i, Math.sqrt(2*i + Math.sin(i) + 5)]);
                }

                $.plot(element, [{
                    data: d1,
                    //lines: { show: true, fill: true }
                    bars: { show: true }
                }, {
                    data: d2,
                    bars: { show: true }
                }/*, {
                    data: d3,
                    //points: { show: true }
                    bars: { show: true }
                }, {
                    data: d4,
                    //lines: { show: true }
                    bars: { show: true }
                }, {
                    data: d5,
                    //lines: { show: true },
                    //points: { show: true }
                    bars: { show: true }
                }, {
                    data: d6,
                    //lines: { show: true, steps: true }
                    bars: { show: true }
                }*/]);
            }
        }
    });

</script>