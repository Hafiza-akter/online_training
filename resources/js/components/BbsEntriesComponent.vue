<template>
    <div>
        <p>開始時刻</p>
        <p>{{dateText}}</p>
        <!--
        <Vue-Tabulator v-model="tableData" :options="options" />
        -->
        <Bar-Chart :chartData="chartItems" :options="chartOptions"/>
    </div>
</template>

<script>
    //import VueTabulator from 'vue-tabulator';
    import BarChart from './BarChart.js'

    export default {
        props: {
            user_id: String,
        },

        components: {
            BarChart
        },

        data: function() {
            return {
                dateText: '00:00:00',
                //tableData: [],
                //options: {},
                chartItems: {},
                chartOptions: {},
            }
        },

        mounted() {
            console.log('Component mounted.');

            /* publicのpush通知受信用(実験)
            window.Echo.channel('public-bbs-entries-channel').listen('PublicBbsEntriesEvent',function(message){
                console.log('public-bbs-entries-channel received');
                console.log(message);
			});
            */

            let obj = this; // オブジェクトへの参照を保持


            window.Echo.private('private-bbs-entries-channel.'+ this.user_id).listen('PrivateBbsEntriesEvent',function(message){
                console.log('private-bbs-entries-channel');
                console.log(message);

                obj.dateText = message.data.date;
                /*
                obj.tableData = message.data.list;
                obj.options = {
                    columns:[
                        {title:"回数", field:"count"},
                        {title:"時間[s]", field:"time"},
                    ],
                    headerSort:false,
                    layout:"fitDataTable",
                };
                */
                let counts = [];
                let times = [];

                for(let i in message.data.list){
                    counts.push(message.data.list[i].count);
                    times.push(message.data.list[i].time);
                }

                obj.chartItems = {
                    labels: counts,
                    datasets: [{
                        label: '時間',
                        data: times,
                    }],
                };

                obj.chartOptions = {
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                        display: true,
                        // X軸グリッド非表示
                        gridLines: {
                            display:false
                        }
                        }],
                        // Y軸
                        yAxes: [{
                        display: true,
                        position: 'right',
                        ticks: {
                            // 0から始まる
                            beginAtZero: true,
                        },
                        }]
                    },
                };

			});
        },
    }
</script>