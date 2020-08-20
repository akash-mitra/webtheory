<template>
    <div>
        <div class="text-sm uppercase text-gray-500 my-4">Top Browsers</div>
        <div class="bg-white rounded text-xs text-gray-700 h-64 overflow-auto relative">
            <div id="browser-chart"></div>
            <div
                v-if="noData"
                class="absolute top-0 left-0 h-64 flex items-center justify-center w-full"
            >
                There is not enough browser data yet
            </div>
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
                labels: ['Chrome', 'Firefox'],
                datasets: [{ name: 'browsers', values: [10, 5] }],
            },
            noData: false,
            colors: ['light-grey', 'dark-grey'],
        }
    },
    mounted() {
        util.ajax('get', '/api/dashboard/browser', {}, (response) => {
            // response = []

            if (response.length < 1) {
                this.noData = true
            } else {
                this.colors = ['light-blue', 'blue', 'violet', 'green', 'yellow', 'light-grey']
                this.browsers.labels = response.map((item) => item.browser)
                let total_views = response.map((item) => parseInt(item.total_views))
                console.log(total_views)
                this.browsers.datasets = [{ name: 'browsers', values: total_views }]
            }
            // chart.update(this.browsers)
            let chart = this.renderChart()
        })
    },

    methods: {
        renderChart() {
            return new Chart('#browser-chart', {
                title: null,
                data: this.browsers,
                type: 'donut', // or 'bar', 'line', 'scatter', 'pie', 'percentage'
                height: 250,
                colors: this.colors,
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
