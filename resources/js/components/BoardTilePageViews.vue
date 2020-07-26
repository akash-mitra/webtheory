<template>
    <div class="bg-gray-100 rounded-lg border px-3 py-4 w-full">
        <TrendChart :datasets="data" :grid="grids" :labels="labels" :min="0"> </TrendChart>
    </div>
</template>

<script>
import TrendChart from 'vue-trend-chart'
export default {
    data() {
        return {
            labels: {
                xLabels: ['Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue'],
                yLabels: 4,
                yLabelsTextFormatter: (val) => Math.round(val),
            },

            data: [
                {
                    data: [10, 50, 20, 102, 40, 60, 80],
                    smooth: true,
                    fill: true,
                    showPoints: true,
                    className: 'curve-style',
                },
            ],

            grids: {
                verticalLines: true,
                horizontalLines: true,
            },
        }
    },

    components: {
        TrendChart,
    },
}
</script>
<style>
.labels {
    stroke: lightslategray;
    font-size: 0.875rem;
    font-weight: 100;
}
.curve-style .stroke {
    stroke: blue;
    stroke-width: 1;
}
.curve-style .fill {
    fill: blue;
    opacity: 0.05;
}
.curve-style .point {
    fill: blue;
    stroke: blue;
}
</style>
