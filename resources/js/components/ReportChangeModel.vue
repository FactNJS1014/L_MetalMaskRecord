<template>
    <div class="flex justify-center items-center mt-5 w-full relative">
        <div class="card w-[95%]">
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
                                <th>EmpID</th>
                                <th>Status</th>
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
                                <td>{{ history.MMCHANGE_EMPID }}</td>
                                <td>{{ history.MMCHANGE_STD }}</td>
                                <td><button class="btn btn-warning text-xl" @click="ToRecordPage(history)" type="button"><i class="pi pi-file-edit"
                                            ></i>เปลี่ยนใช้งาน</button></td>
                                <td><button type="button" class="btn btn-accent text-xl" @click="PageData(history)"><i
                                            class="pi pi-eye"></i>ดูข้อมูล</button></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="absolute bg-blue-300 p-6 rounded-lg w-[60%]" v-if="IsShow">
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

import 'primeicons/primeicons.css'
import DataChange from './DataChange.vue';

export default {
    components: {
        DataChange
    },
    data() {
        return {
            changeHistory: [],
            selectedItem: {},
            IsShow: false,

        };
    },
    mounted() {
        this.fetchChangeHistory();
    },
    methods: {
        fetchChangeHistory() {
            axios.get('/L_MetalMaskRecord/api/get-change-model')
                .then(response => {
                    this.changeHistory = response.data;
                    console.log(this.changeHistory);
                })
                .catch(error => {
                    console.error('Error fetching change history:', error);
                })
        },
        PageData(item) {
            this.IsShow = true;
            this.selectedItem = { ...item };
        },
        CloseComponent() {
            this.IsShow = false;
        },
        ToRecordPage(c) {
            const cloneData = {...c};
            this.$router.push({
                name: 'recordPR',
                query:{
                    wono: cloneData.MMCHANGE_WONNO,
                    model: cloneData.MMCHANGE_MDLCHN,
                    cus: cloneData.MMCHANGE_CUS,
                    
                }
            });
        }
    }
}

</script>
