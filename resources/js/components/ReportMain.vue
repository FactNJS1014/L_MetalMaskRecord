<template>
  <div class="p-4">
    <div class="flex justify-center items-center">
      <div class="card w-[65%]">
        <div class="card-header bg-violet-200">
          <h5 class="card-title text-center text-yellow-600 font-bold">ข้อมูลการใช้งาน Metal Mask </h5>
        </div>
        <div class="card-body mt-4">
          <!-- ตารางรวมผล Shots ตาม QRID -->
            <!-- <h5 class="text-center font-bold text-purple-700 text-xl">รวม Shots แต่ละ Model</h5> -->
          <div class="mt-3 flex items-center justify-center">
            <MaskChart v-if="runningSums" :chartData="runningSums" :rawData="MaskData" />
          </div>
          <h5 class="text-center font-bold text-purple-700 text-xl mt-6">รายการใช้งาน Metal Mask ทั้งหมด</h5>
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
                  <th>Revision</th>
                  <th>Reference Number</th>
                  <th>Date</th>
                  <th>Lot Size</th>
                  <th>Shots Qty</th>
                  <th>Vendor</th>
                  <th>Details</th>
                  <th>Types</th>
                  <th>Remark</th>
                  <th>Employee ID of Record</th>
                  <th>Date of Record</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in MaskData" :key="index" class="text-[16px] font-semibold">
                  <td class="text-center">{{ item.MSKREC_QRID }}</td>
                  <td class="text-center">{{ item.MSKREC_MDLCD }}</td>
                  <td class="text-center">{{ item.MSKREC_WON }}</td>
                  <td class="text-center">{{ item.MSKREC_LISTNO }}</td>
                  <td class="text-center">{{ item.MSKREC_CUS }}</td>
                  <td class="text-center">{{ item.MSKREC_PCBNO }}</td>
                  <td class="text-center">{{ item.MSKREC_MMNAME }}</td>
                  <td class="text-center">{{ item.MSKREC_PROCS }}</td>
                  <td class="text-center">{{ item.MSKREC_REVS }}</td>
                  <td class="text-center">{{ item.MSKREC_REFNO }}</td>
                  <td class="text-center">{{ item.MSKREC_PRODDATE }}</td>
                  <td class="text-center">{{ item.MSKREC_LOTS }}</td>
                  <td class="text-center">{{ item.MSKREC_SHOTS }}</td>
                  <td class="text-center">{{ item.MSKREC_VENDOR }}</td>
                  <td class="text-center">{{ item.MSKREC_DETAILS }}</td>
                  <td class="text-center">{{ item.MSKREC_TYPES }}</td>
                  <td class="text-center">{{ item.MSKREC_REMARK }}</td>
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
import "vue3-toastify/dist/index.css"
import { toast } from "vue3-toastify";
import Swal from 'sweetalert2'
import axios from 'axios';
import MaskChart from "../Chartjs/MaskChart.vue";
export default {
  components: {
    MaskChart
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
          const mdl = item.MSKREC_MDLCD;
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

        // Object.entries(grouped).forEach(([mdl, total]) => {
        //   const notified = notifyStatus[mdl] == 1;

        //   if (total >= 600 && !notified) {
        //     Swal.fire({
        //       title: 'แจ้งเตือน!',
        //       text: `Model: ${mdl} ครบ ${total} แล้ว!`,
        //       icon: 'warning',
        //       confirmButtonText: 'ตกลง',
        //       confirmButtonColor: '#8b5cf6'
        //     }).then((result) => {
        //       if (result.isConfirmed) {
        //         // PUT เพื่อ update notify std
        //         axios.put('/L_MetalMaskRecord/update-notify-status', {
        //           mdl: mdl,

        //         }).then(response => {
        //           console.log('Status updated successfully:', response.data);
        //         });
        //       }
        //     })



        //     // อัปเดต local statusMap เพื่อไม่แจ้งซ้ำ
        //     this.statusMap[mdl] = 1;
        //   }
        // });


      } catch (error) {
        console.error('เกิดข้อผิดพลาด:', error);

      }
    }

  },
  mounted() {
    this.fetchReportData();
  }
}

</script>
