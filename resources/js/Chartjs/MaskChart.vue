<template>
    <div class="w-full max-w-[1000px] mx-auto">
        <div class="h-[600px]">
            <canvas ref="maskChart"></canvas>
        </div>

    </div>
</template>


<script>
import { Chart, registerables } from 'chart.js';
import Swal from 'sweetalert2';
Chart.register(...registerables);

export default {
    name: 'MaskChart',
    props: {
        chartData: Object,
        rawData: Array
    },

    mounted() {
        this.renderChart();
    },
    methods: {
        renderChart() {
            const labels = Object.keys(this.chartData);
            const data = Object.values(this.chartData);

            const randomColors = labels.map(() => {
                const r = Math.floor(Math.random() * 256);
                const g = Math.floor(Math.random() * 256);
                const b = Math.floor(Math.random() * 256);
                return `rgba(${r}, ${g}, ${b}, 0.6)`;
            });

            const chart = new Chart(this.$refs.maskChart, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Shots per Mask ID',
                        data: data,
                        backgroundColor: randomColors,
                        borderColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: (evt, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const label = chart.data.labels[index];
                            const value = chart.data.datasets[0].data[index];

                            const relatedData = this.rawData
                                .filter(item => item.MMST_QRID === label)
                                .sort((a, b) => new Date(b.MSKREC_PRODDATE) - new Date(a.MSKREC_PRODDATE))
                                .slice(0, 5);

                            let rows = relatedData.map(item => `
                <tr>
                  <td style="padding: 8px; border: 1px solid #ccc;">${item.MSKREC_LISTNO}</td>
                  <td style="padding: 8px; border: 1px solid #ccc;">${item.MSKREC_MMNAME}</td>
                  <td style="padding: 8px; border: 1px solid #ccc;">${item.MSKREC_SHOTS}</td>
                </tr>
              `).join('');

                            const tableHtml = `
                <h4 style="margin-bottom: 10px;" class="text-[19px] font-semibold text-blue-600">QR Code ID: ${label} | Total Mask Shots: ${value}</h4>
                <table style="width:100%; border-collapse: collapse; text-align: center;">
                  <thead style="background-color: #f3f4f6;">
                    <tr>
                      <th style="padding: 8px; border: 1px solid #ccc;">Metal Mask No.</th>
                      <th style="padding: 8px; border: 1px solid #ccc;">Metal Mask Name</th>
                      <th style="padding: 8px; border: 1px solid #ccc;">Shots</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${rows}
                  </tbody>
                </table>
              `;

                            Swal.fire({
                                title: 'ข้อมูล Metal Mask Shots',
                                html: tableHtml,
                                width: 800,
                                confirmButtonText: 'ตกลง',
                                confirmButtonColor: '#8b5cf6'
                            });
                        }
                    },

                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                                font: {
                                    size: 10
                                },
                                padding: 5,
                                usePointStyle: true
                            }
                        },
                    },
                    layout: {
                        padding: 10
                    }
                }
            });

            this.chart = chart;

        }
    }
}
</script>
