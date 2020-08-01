<template>
    <div class="bg-gray-100 rounded-lg border w-full">
        <div id="pvchart"></div>
    </div>
</template>

<script>
import { Chart } from 'frappe-charts/dist/frappe-charts.min.esm'
export default {
    data() {
        return {
            chart: null,
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{ name: 'Views', values: [5, 5, 5, 5, 5, 5, 5] }],
            },
        }
    },

    mounted() {
        let chart = this.renderChart()

        util.ajax('get', '/api/dashboard/daily', {}, (response) => {
            let views_series = response.map((d) => {
                return parseInt(d.total_views)
            })

            this.data.labels = response.map((d) => {
                return this.parseDay(d.date_key.toString())
            })

            this.data.datasets = [{ name: 'Views', values: views_series }]

            chart.update(this.data)
        })
    },

    methods: {
        parseDay(str) {
            // let days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
            let y = str.substr(0, 4),
                m = str.substr(4, 2) - 1,
                d = str.substr(6, 2)
            let D = new Date(y, m, d)
            // return days[D.getDay()]
            return D.getDate()
        },

        renderChart() {
            return new Chart('#pvchart', {
                // or a DOM element,
                // new Chart() in case of ES6 module with above usage
                title: null,
                data: this.data,
                type: 'line', // or 'bar', 'line', 'scatter', 'pie', 'percentage'
                height: 350,
                colors: ['blue'],
                // 'light-blue', 'blue', 'violet', 'red', 'orange', 'yellow', 'green', 'light-green', 'purple', 'magenta', 'light-grey', 'dark-grey'
                lineOptions: {
                    regionFill: 1, // to fill area under curve
                    heatline: 1, // color gradient based on value
                    spline: 1, // smoothing
                },
                axisOptions: {
                    xIsSeries: true, // since it is a time series
                    xAxisMode: 'tick',
                },
            })
        },
    },
}
</script>
