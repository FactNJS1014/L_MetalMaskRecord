<template>
    <div class="p-4">
        <div class="flex justify-center items-center">
            <div class="card w-[90 c%] lg:w-[65%] bg-white">
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
                    <div class="flex justify-between items-center">
                        <div class="flex items-start">
                            <select v-model="searchDataLine" @change="searchLine"
                                class="select select-bordered w-full max-w-xs">
                                <option value="">-- เลือก LINE --</option>
                                <option v-for="line in allLines" :key="line" :value="line.LINE_NAME">
                                    {{ line.LINE_NAME }}
                                </option>
                            </select>
                            <input type="date" class="input input-bordered w-full max-w-xs ms-3"
                                placeholder="Search Date" v-model="searchDataDate" @input="searchDate" />
                        </div>
                        <div>
                            <button class="btn btn-success" @click="ExportExcel">Export Excel</button>
                        </div>
                    </div>
                    <div class="mt-4 max-h-[400px] overflow-auto border border-gray-300 rounded">
                        <table class="table w-full min-w-[1000px] table-zebra">
                            <thead class="sticky top-0 bg-purple-800 z-10">
                                <tr class="text-center text-lg font-bold text-white">
                                    <th>QR_ID</th>
                                    <th>Line SMT</th>
                                    <th>Model Code</th>
                                    <th>Work Order</th>
                                    <th>List Number</th>
                                    <th>Customer</th>
                                    <th>PCB Number</th>
                                    <th>Metal Mask Name</th>
                                    <th>Process</th>
                                    <th>Lot Size</th>
                                    <th>Shots Qty</th>
                                    <th>Employee ID of Record Model Change</th>
                                    <th>Employee ID of Record Mask Shot</th>
                                    <th>Date of Record Model Change</th>
                                    <th>Time of Record Model Change</th>
                                    <th>Date of Record Mask Shot</th>
                                    <th>Time of Record Mask Shot</th>
                                    <th>Shift Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in GetDatas" :key="index"
                                    class="text-[16px] font-semibold text-black text-center">
                                    <td>{{ item.MMST_QRID }}</td>
                                    <td>{{ item.MMCHANGE_LINE }}</td>
                                    <td>{{ item.MSKREC_MDLCD }}</td>
                                    <td>{{ item.MSKREC_WON }}</td>
                                    <td>{{ item.MSKREC_LISTNO }}</td>
                                    <td>{{ item.MSKREC_CUS }}</td>
                                    <td>{{ item.MSKREC_PCBNO }}</td>
                                    <td>{{ item.MSKREC_MMNAME }}</td>
                                    <td>{{ item.MSKREC_PROCS }}</td>
                                    <td>{{ item.MSKREC_LOTS }}</td>
                                    <td>{{ item.MSKREC_SHOTS }}</td>
                                    <td>{{ item.MUSR_NAME }}</td>
                                    <td>{{ getUserName(item.MSKREC_EMPREC) }}</td>
                                    <td>{{ formatdate(item.MMCHANGE_LSTDT) }}</td>
                                    <td>{{ formatTime(item.MMCHANGE_LSTDT) }}</td>
                                    <td>{{ formatdate(item.MSKREC_LSTDT) }}</td>
                                    <td>{{ formatTime(item.MSKREC_LSTDT) }}</td>
                                    <td>{{ item.MMCHANGE_SHIFT }}</td>
                                    <td>{{ item.MSKREC_STD }}</td>
                                </tr>
                                <!-- <tr class="bg-gray-100 text-black text-start font-bold text-[16px]"
                                    v-for="(group, index) in groupedByLine" :key="'summary-' + index">
                                    <td colspan="16" class="py-2">
                                        รวม LINE {{ group.line }}: {{ group.count }} รายการ
                                    </td>
                                </tr> -->
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
import dayjs from 'dayjs';
export default {
    components: {
        MaskChart,
        // downloadExcel: JsonExcel,
    },
    data() {
        return {
            MaskData: [],
            runningSums: null,
            statusMap: {},
            searchDataLine: '',
            searchDataDate: '',
            qrid: '',
            GetDatas: [],
            allLines: [], // รายการทั้งหมดของ LINE ที่ใช้ใน select
            userNameMap: {},
        };
    },
    computed: {
        groupedByLine() {
            const result = {};
            this.GetDatas.forEach(item => {
                const line = item.MMCHANGE_LINE;
                if (!result[line]) {
                    result[line] = {
                        line: line,
                        count: 0
                    };
                }
                result[line].count++;
            });

            return Object.values(result).sort((a, b) => {
                const aNum = parseInt(a.line.replace(/[^\d]/g, '')) || 0;
                const bNum = parseInt(b.line.replace(/[^\d]/g, '')) || 0;
                return aNum - bNum;
            });
        }

    },

    /**
     * *ฟังก์ชันนี้จะดึงข้อมูลการใช้งาน Metal Mask ทั้งหมดจาก API
     * *และจัดกลุ่มข้อมูลตาม QRID เพื่อคำนวณผลรวม Shots
     * *หากจำนวน Shots ของ QRID ใดๆ ถึง 95000 และยังไม่ได้แจ้งเตือน จะมีการแจ้งเตือนผ่าน SweetAlert
     * *และทำการอัปเดตสถานะการแจ้งเตือนในฐานข้อมูล
     * *และส่งข้อมูลไปยัง Chartjs/MaskChart.vue เพื่อแสดงกราฟ
     */

    methods: {
        async fetchReportData() {
            try {
                const res = await axios.get('/45_engmask/api/get-values2');
                const data = res.data;

                this.MaskData = data;
                console.log(this.MaskData)
                // console.log(data)
                const grouped = {}
                const notifyStatus = {};
                // รวม Shots และจำ Notify STD
                data.forEach(item => {
                    const mdl = item.MMST_QRID;
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

                Object.entries(grouped).forEach(([mdl, total]) => {
                    const notified = notifyStatus[mdl] == 1;

                    if (total >= 95000 && !notified) {
                        Swal.fire({
                            title: 'แจ้งเตือน!',
                            text: `Model: ${mdl} ครบ ${total} แล้ว!`,
                            icon: 'warning',
                            confirmButtonText: 'ตกลง',
                            confirmButtonColor: '#8b5cf6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // PUT เพื่อ update notify std
                                axios.put('/45_engmask/update-notify-status', {
                                    mdl: mdl,

                                }).then(response => {
                                    console.log('Status updated successfully:', response.data);
                                });
                            }
                        })



                        // อัปเดต local statusMap เพื่อไม่แจ้งซ้ำ
                        this.statusMap[mdl] = 1;
                    }
                });


            } catch (error) {
                console.error('เกิดข้อผิดพลาด:', error);

            }
        },
        /**
         * *ฟังก์ชันนี้จะทำการส่งออกข้อมูล MaskData เป็นไฟล์ Excel
         * *โดยใช้ไลบรารี XLSX
         * *และกำหนดชื่อไฟล์เป็น "MetalMask_YYYY-MM-DD.xlsx"
         */
        ExportExcel() {
            // // 1. สร้างข้อมูลสรุป LINE
            // const summaryData = this.groupedByLine.map(group => ({
            //     'QRID': `รวม ${group.line}`,
            //     'Line SMT': `${group.count} รายการ`
            // }));

            // 2. สร้างข้อมูลตารางหลัก
            const tableData = this.GetDatas.map(item => ({
                'QRID': item.MMST_QRID,
                'Line SMT': item.MMCHANGE_LINE,
                'MODEL': item.MSKREC_MDLCD,
                'W/O NO': item.MSKREC_WON,
                'LIST NO': item.MSKREC_LISTNO,
                'CUSTOMER': item.MSKREC_CUS,
                'PCB NO': item.MSKREC_PCBNO,
                'MACHINE NAME': item.MSKREC_MMNAME,
                'PROCESS': item.MSKREC_PROCS,
                'LOTS': item.MSKREC_LOTS,
                'SHOTS': item.MSKREC_SHOTS,
                'EMPLOYEE ID OF RECORD MODEL CHANGE': item.MUSR_NAME,
                'EMPLOYEE ID OF RECORD MASK SHOT': this.getUserName(item.MSKREC_EMPREC),
                'DATE OF RECORD MODEL CHANGE': this.formatdate(item.MMCHANGE_LSTDT),
                'TIME OF RECORD MODEL CHANGE': this.formatTime(item.MMCHANGE_LSTDT),
                'DATE OF RECORD MASK SHOT': this.formatdate(item.MSKREC_LSTDT),
                'TIME OF RECORD MASK SHOT': this.formatTime(item.MSKREC_LSTDT),
                'SHIFT': item.MMCHANGE_SHIFT,
                'STATUS': item.MSKREC_STD
            }));

            // 3. รวมข้อมูลทั้งหมด: สรุป + ค่าว่างคั่น + ข้อมูลหลัก
            const exportData = [
                ...tableData,
                // {}, // เว้นบรรทัด

                // ...summaryData
            ];

            // 4. สร้างและเขียนไฟล์ Excel
            const worksheet = XLSX.utils.json_to_sheet(exportData);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Report Model Change");
            const currentDate = new Date().toISOString().split('T')[0];
            const excelFileName = `MetalMask_${currentDate}.xlsx`;
            XLSX.writeFile(workbook, excelFileName);
        },

        /**
         * *ฟังก์ชันนี้จะถูกเรียกเมื่อมีการพิมพ์ใน input search
         * *และจะทำการค้นหาข้อมูล MaskData ตามคำค้นหา
         * *หากไม่มีคำค้นหา จะดึงข้อมูลทั้งหมดจาก API
         */
        searchLine() {
            // ฟังก์ชันนี้จะถูกเรียกเมื่อมีการพิมพ์ใน input search
            // ไม่ต้องทำอะไรที่นี่ เพราะ watch จะจัดการการค้นหาให้
            const searchTerm = this.searchDataLine;
            console.log(searchTerm)
            if (!searchTerm) {
                this.GetDatasRep(); // ถ้าไม่มีการค้นหา ให้ดึงข้อมูลทั้งหมด
            } else {
                axios.get('/45_engmask/api/search-Line', {
                    params: {
                        searchLine: searchTerm
                    }
                })
                    .then(response => {
                        this.GetDatas = response.data;
                        console.log(this.GetDatas)
                    })
                    .catch(error => {
                        console.error('เกิดข้อผิดพลาดในการค้นหา:', error);
                    });
            }
        },
        searchDate() {
            // ฟังก์ชันนี้จะถูกเรียกเมื่อมีการพิมพ์ใน input search
            // ไม่ต้องทำอะไรที่นี่ เพราะ watch จะจัดการการค้นหาให้
            const searchTerm2 = this.searchDataDate;
            console.log(searchTerm2)
            if (!searchTerm2) {
                this.GetDatasRep(); // ถ้าไม่มีการค้นหา ให้ดึงข้อมูลทั้งหมด
            } else {
                axios.get('/45_engmask/api/search-Date', {
                    params: {
                        searchDate: searchTerm2
                    }
                })
                    .then(response => {
                        this.GetDatas = response.data;
                        console.log(this.GetDatas)
                    })
                    .catch(error => {
                        console.error('เกิดข้อผิดพลาดในการค้นหา:', error);
                    });
            }
        },
        GetDatasRep() {

            axios.get('/45_engmask/api/get-values')
                .then(response => {

                    this.GetDatas = response.data;
                    console.log(this.GetDatas)
                })
                .catch(error => {
                    console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
                });
        },
        formatdate(dateString) {
            return dayjs(dateString).format('YYYY-MM-DD');
        },
        formatTime(timeString) {
            return dayjs(timeString).format('HH:mm:ss');
        },
        loadUserNames() {
            axios.get('/45_engmask/api/get-user-name')
                .then(response => {
                    response.data.forEach(user => {
                        this.userNameMap[user.MUSR_ID] = user.MUSR_NAME;
                    });
                })
                .catch(error => {
                    console.error('โหลดชื่อผู้ใช้ไม่สำเร็จ:', error);
                });
        },
        getUserName(id) {
            return this.userNameMap[id] || 'ไม่พบชื่อผู้ใช้';
        },
        GetLines() {
            axios.get('/45_engmask/api/get-list-line')
                .then(response => {
                    this.allLines = response.data;
                    console.log(this.allLines)
                })
                .catch(error => {
                    console.error('เกิดข้อผิดพลาดในการดึงข้อมูล LINE:', error);
                });
        }


    },


    mounted() {
        this.fetchReportData(),
            this.GetDatasRep(),
            this.GetLines(),
            this.loadUserNames()


    },


}

</script>
