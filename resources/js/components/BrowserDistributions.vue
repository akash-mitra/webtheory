<template>
    <div>
        <div class="text-sm uppercase text-gray-500 my-4">Top Browsers</div>
        <div class="bg-white rounded text-xs text-gray-700 h-64 overflow-auto">
            <div id="browser-chart"></div>
        </div>
    </div>
</template>

<script>
import { Chart } from 'frappe-charts/dist/frappe-charts.min.esm'
export default {
    data() {
        return {
            chart: null,
            browsers: {
                labels: ['Edge', 'Opera', 'Chrome', 'Firefox'],
                datasets: [{ name: 'browsers', values: [5, 5, 5, 5] }],
            },
        }
    },
    mounted() {
        util.ajax('get', '/api/dashboard/browser', {}, (response) => {
            this.browsers.labels = response.map((item) => item.browser)
            let total_views = response.map((item) => parseInt(item.total_views))
            console.log(total_views)
            this.browsers.datasets = [{ name: 'browsers', values: total_views }]

            // chart.update(this.browsers)
            let chart = this.renderChart()
        })
    },

    methods: {
        renderChart() {
            return new Chart('#browser-chart', {
                // or a DOM element,
                // new Chart() in case of ES6 module with above usage
                title: null,
                data: this.browsers,
                type: 'donut', // or 'bar', 'line', 'scatter', 'pie', 'percentage'
                height: 250,
                colors: ['light-blue'],
                // 'light-blue', 'blue', 'violet', 'red', 'orange', 'yellow', 'green', 'light-green', 'purple', 'magenta', 'light-grey', 'dark-grey'
                maxSlices: 5,
                axisOptions: {
                    xIsSeries: false,
                    xAxisMode: 'tick',
                },
            })
        },
    },
}
</script>
