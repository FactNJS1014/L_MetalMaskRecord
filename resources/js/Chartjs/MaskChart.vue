<template>
  <div class="w-full max-w-[1000px] mx-auto" style="height: 500px;"> <!-- เพิ่มความสูงที่นี่ -->
    <canvas ref="maskChart"></canvas>
  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

export default {
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
      const colors = labels.map(() => {
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
            label: 'Total Shots per Model',
            data: data,
            backgroundColor: colors,
            borderColor: 'rgba(255,255,255,1)',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // ปิดเพื่อให้สามารถขยายได้ตาม container
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                boxWidth: 20,
                padding: 10,
                usePointStyle: true
              }
            }
          }
        }
      });

      this.chart = chart;
    }
  }
}
</script>
