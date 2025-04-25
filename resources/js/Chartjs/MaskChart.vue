<template>
    <div>
      <canvas ref="maskChart"></canvas>
    </div>
  </template>
  
  <script>
  import { Chart, registerables } from 'chart.js';
  Chart.register(...registerables);
  
  export default {
    name: 'MaskChart',
    props: {
      chartData: Object
    },
    mounted() {
      this.renderChart();
    },
    methods: {
      renderChart() {
        new Chart(this.$refs.maskChart, {
          type: 'bar',
          data: {
            labels: Object.keys(this.chartData),
            datasets: [{
              label: 'Total Shots per Model',
              data: Object.values(this.chartData),
              backgroundColor: 'rgba(139, 92, 246, 0.6)',
              borderColor: 'rgba(139, 92, 246, 1)',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    }
  }
  </script>
  