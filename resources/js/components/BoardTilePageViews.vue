<template>
    <div class="bg-gray-100 rounded-lg border w-full relative">
        <div id="pvchart"></div>
        <div
            class="absolute top-0 left-0 w-full h-64 flex items-center justify-center"
            v-if="noData"
        >
            <p class="text-sm px-6">
                This graph will start showing data after it has collected at least 3 days of
                information
            </p>
        </div>
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
                datasets: [
                    { name: 'Visitors', values: [10, 16, 15, 18, 18, 19, 14] },
                    { name: 'Views', values: [15, 21, 20, 23, 23, 24, 19] },
                ],
            },
            colors: ['dark-grey', 'light-grey'],
            noData: false,
        }
    },

    mounted() {
        let today = new Date()
        let startDay = new Date(Date.now() - 12 * 24 * 60 * 60 * 1000)
        let url =
            '/api/dashboard/views/daily?start_date_key=' +
            util.formatDate(startDay, 'Ymd') +
            '&end_date_key=' +
            util.formatDate(today, 'Ymd')

        util.ajax('get', url, {}, (response) => {
            // response = []
            if (response.length < 3) {
                this.noData = true
            } else {
                this.colors = ['light-blue', 'blue']
                let views_series = response.map((d) => {
                    return parseInt(d.total_views)
                })
                let visitors_series = response.map((d) => {
                    return parseInt(d.unique_visitors)
                })

                this.data.labels = response.map((d) => {
                    return this.parseDay(d.date_key.toString())
                })

                this.data.datasets = [
                    { name: 'Visitors', values: visitors_series },
                    { name: 'Views', values: views_series },
                ]
            }

            this.renderChart()
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
            return d + ' ' + D.toLocaleString('default', { month: 'short' })
        },

        renderChart() {
            return new Chart('#pvchart', {
                title: null,
                data: this.data,
                type: 'bar', // or 'bar', 'line', 'scatter', 'pie', 'percentage'
                height: 350,
                colors: this.colors,
                // 'light-blue', 'blue', 'violet', 'red', 'orange', 'yellow', 'green', 'light-green', 'purple', 'magenta', 'light-grey', 'dark-grey'
                // lineOptions: {
                //     regionFill: 1, // to fill area under curve
                //     heatline: 1, // color gradient based on value
                //     spline: 1, // smoothing
                // },
                axisOptions: {
                    xIsSeries: true, // since it is a time series
                    xAxisMode: 'tick',
                },
                barOptions: {
                    stacked: 1, // default 0, i.e. adjacent
                },
            })
        },
    },
}
</script>
