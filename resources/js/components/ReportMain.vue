<template>
  <div class="p-4">
    <div class="flex justify-center items-center">
      <div class="card w-[65%] bg-white">
        <div class="card-header bg-violet-200">
          <h5 class="card-title text-center text-sky-700 font-bold">ข้อมูลการใช้งาน Metal Mask </h5>
        </div>
        <div class="card-body mt-4">
          <!-- ตารางรวมผล Shots ตาม QRID -->
          <!-- <h5 class="text-center font-bold text-purple-700 text-xl">รวม Shots แต่ละ Model</h5> -->
          <div class="mt-3 flex items-center justify-center">
            <MaskChart v-if="runningSums" :chartData="runningSums" :rawData="MaskData" />
          </div>
          <h5 class="text-center font-bold text-purple-700 text-xl mt-6">รายการใช้งาน Metal Mask ทั้งหมด</h5>
          <div class="flex justify-end items-center">
            <button class="btn btn-success" @click="ExportExcel">Export Excel</button>
          </div>
          <div class="overflow-auto mt-4 h-[60%]">
            <table class="table">
              <thead>
                <tr class="text-center text-lg font-bold text-white bg-purple-800">
                  <th>QR_ID</th>
                  <th>Model Code</th>
                  <th>Work Order</th>
                  <th>List Number</th>
                  <th>Customer</th>
                  <th>PCB Number</th>
                  <th>Metal Mask Name</th>
                  <th>Process</th>                
                  <th>Lot Size</th>
                  <th>Shots Qty</th>                 
                  <th>Employee ID of Record</th>
                  <th>Date of Record</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in MaskData" :key="index" class="text-[16px] font-semibold text-black">
                  <td class="text-center">{{ item.MSKREC_QRID }}</td>
                  <td class="text-center">{{ item.MSKREC_MDLCD }}</td>
                  <td class="text-center">{{ item.MSKREC_WON }}</td>
                  <td class="text-center">{{ item.MSKREC_LISTNO }}</td>
                  <td class="text-center">{{ item.MSKREC_CUS }}</td>
                  <td class="text-center">{{ item.MSKREC_PCBNO }}</td>
                  <td class="text-center">{{ item.MSKREC_MMNAME }}</td>
                  <td class="text-center">{{ item.MSKREC_PROCS }}</td>                 
                  <td class="text-center">{{ item.MSKREC_LOTS }}</td>
                  <td class="text-center">{{ item.MSKREC_SHOTS }}</td>                  
                  <td class="text-center">{{ item.MSKREC_EMPREC }}</td>
                  <td class="text-center">{{ item.MSKREC_LSTDT }}</td>
                </tr>
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import MaskChart from "../Chartjs/MaskChart.vue";
import * as XLSX from 'xlsx';
export default {
  components: {
    MaskChart,
    // downloadExcel: JsonExcel,
  },
  data() {
    return {
      MaskData: [],
      runningSums: null,
      statusMap: {}
    };
  },
  methods: {
    async fetchReportData() {
      try {
        const res = await axios.get('/45_engmask/api/get-values');
        const data = res.data;

        this.MaskData = data;
        console.log(data)
        const grouped = {}
        const notifyStatus = {};
        // รวม Shots และจำ Notify STD
        data.forEach(item => {
          const mdl = item.MSKREC_QRID;
          const shots = parseInt(item.MSKREC_SHOTS) || 0;

          grouped[mdl] = (grouped[mdl] || 0) + shots;

          // Store status for each QRID (assumes the same QRID has same status)
          if (!(mdl in notifyStatus)) {
            notifyStatus[mdl] = item.MSKREC_NOTIFY_STD;
          }
        });
        console.log(grouped)

        this.runningSums = grouped;
        console.log(this.runningSums)
        console.log(notifyStatus)       


      } catch (error) {
        console.error('เกิดข้อผิดพลาด:', error);

      }
    },
    ExportExcel() {
      const fields = {
        'MSKREC_QRID':'QR Code Number',
        'MSKREC_MDLCD':'Model Code',
        'MSKREC_WON':'Work Order',
        'MSKREC_LISTNO':'List Number',
        'MSKREC_CUS':'Customer',
        'MSKREC_PCBNO':'PCB Number',
        'MSKREC_PROCS':'Process',
        'MSKREC_LOTS':'Lot Size',
        'MSKREC_SHOTS':'Shots Qty',
        'MSKREC_EMPREC':'Employee',
        'MSKREC_LSTDT':'Date Record',
      }

      const data = this.MaskData.map(item => {
        const row = {};
        for (const key in item) {
          if (fields[key]) {
            row[fields[key]] = item[key];
          }
        }
        return row;
      })
      // console.log(data)
      const worksheet = XLSX.utils.json_to_sheet(data);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
      const currentDate = new Date().toISOString().split('T')[0];      
      const excelFileName = `MetalMask_${currentDate}.xlsx`;
      XLSX.writeFile(workbook, excelFileName);
    }

  },
  mounted() {
    this.fetchReportData();
  }
}

</script>
