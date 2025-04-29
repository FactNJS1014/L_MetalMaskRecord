<template>
  <div class="w-[50%] mx-10">
    <canvas ref="maskChart"></canvas>


  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';
import Swal from 'sweetalert2'; // ✅ Import SweetAlert2
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
            label: 'Total Shots per Model',
            data: data,
            backgroundColor: randomColors,
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          onClick: (evt, elements) => {
            if (elements.length > 0) {
              const index = elements[0].index;
              const label = chart.data.labels[index];
              const value = chart.data.datasets[0].data[index];

              // 👉 เตรียม table HTML
              const tableHtml = `
                <table style="width:100%; border-collapse: collapse; text-align: center;">
                  <thead>
                    <tr style="background-color: #f3f4f6;">
                      <th style="padding: 8px; border: 1px solid #ccc;">Model</th>
                      <th style="padding: 8px; border: 1px solid #ccc;">Total Shots</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="padding: 8px; border: 1px solid #ccc;">${label}</td>
                      <td style="padding: 8px; border: 1px solid #ccc;">${value}</td>
                    </tr>
                  </tbody>
                </table>
              `;

              // 👉 แสดง SweetAlert2 พร้อม Table
              Swal.fire({
                title: 'ข้อมูล Model',
                html: tableHtml,
                width: 600,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#8b5cf6'
              });
            }
          },
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });

      this.chart = chart;
    }
  }
}
</script>
