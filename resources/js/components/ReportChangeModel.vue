<template>
    <div class="flex justify-center items-center mt-5 w-full relative">
        <div class="card w-[95%] bg-white">
            <div class="card-body">
                <h5 class="card-title text-center font-bold text-2xl text-black bg-pink-200 p-3 rounded-lg">
                    การแจ้งเปลี่ยนโมเดล</h5>
                <div class="overflow-x-auto">
                    <table class="table w-full  text-black ">
                        <thead>
                            <tr class="text-center text-xl bg-info text-white">
                                <th>Work Order</th>
                                <th>Model</th>
                                <th>Customer</th>
                                <th>Process</th>
                                <th>SMT</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Action เปลี่ยนโมเดลใช้งาน</th>
                                <th>Action View Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Add your data rows here -->
                            <tr v-for="(history, index) in changeHistory" :key="index"
                                class="text-center text-[17px] font-semibold">

                                <td>{{ history.MMCHANGE_WONNO }}</td>
                                <td>{{ history.MMCHANGE_MDLCHN }}</td>
                                <td>{{ history.MMCHANGE_CUS }}</td>
                                <td>{{ history.MMCHANGE_PRCS }}</td>
                                <td>{{ history.MMCHANGE_LINE }}</td>
                                <td>{{ formatDate(history.MMCHANGE_LSTDT) }}</td>
                                <td>{{ formatTime(history.MMCHANGE_LSTDT) }}</td>
                                <td><button class="btn btn-warning text-xl" @click="ToRecordPage(history)"
                                        type="button"><i class="pi pi-file-edit"></i>เปลี่ยนใช้งาน</button></td>
                                <td><button type="button" class="btn btn-accent text-xl"
                                        @click="PageData(history.MMCHANGE_MDLCHN, history.MMCHANGE_PRCS)"><i
                                            class="pi pi-eye"></i>ดูข้อมูล</button></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="absolute bg-blue-300 p-6 rounded-lg w-[60%] mt-[10%]" v-if="IsShow">
            <div class="flex justify-end items-center">
                <i class="pi pi-times " style="font-size: 24px; font-weight: bold; color: #e40004; cursor: pointer;"
                    @click="CloseComponent"></i>
            </div>
            <DataChange :lists="selectedItem" />
        </div>

    </div>

</template>
<script>
import axios from 'axios';
import dayjs from 'dayjs';

import 'primeicons/primeicons.css'
import DataChange from './DataChange.vue';

export default {
    name: 'report',
    components: {
        DataChange
    },
    data() {
        return {
            changeHistory: [],
            selectedItem: [],
            IsShow: false,
            gethistory: [],
            session: this.$session,

        };
    },
    mounted() {
        this.fetchChangeHistory();

    },
    methods: {
        fetchChangeHistory() {
            axios.get('/45_engmask/api/get-change-model')
                .then(response => {
                    this.changeHistory = response.data;
                    console.log(this.changeHistory);
                })
                .catch(error => {
                    console.error('Error fetching change history:', error);
                })
        },
        PageData(mdl, prcs) {
            this.IsShow = true;
            axios.post('/45_engmask/get-change-history', {
                mdl: mdl,
                prcs: prcs,
                headers: {
                    'Content-Type': 'application/json',
                }

            })
                .then(response => {
                    this.gethistory = response.data;
                    this.selectedItem = this.gethistory;
                    console.log(this.selectedItem)
                })
                .catch(error => {
                    console.error('Error fetching change history:', error);
                })

            // console.log(prcs)
        },
        CloseComponent() {
            this.IsShow = false;
        },
        ToRecordPage(c) {
            const cloneData = { ...c };
            this.$router.push({
                name: 'recordPR',
                query: {
                    wono: cloneData.MMCHANGE_WONNO,
                    model: cloneData.MMCHANGE_MDLCHN,
                    cus: cloneData.MMCHANGE_CUS,
                    empno: this.session.empno,
                    prcs: cloneData.MMCHANGE_PRCS,
                }
            });
        },
        formatDate(dateString) {
            return dayjs(dateString).format('YYYY-MM-DD');
        },
        formatTime(timeString) {
            return dayjs(timeString).format('HH:mm:ss');
        },

    }
}

</script>
