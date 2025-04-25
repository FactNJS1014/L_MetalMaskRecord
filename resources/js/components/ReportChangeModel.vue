<template>
    <div class="flex justify-center items-center mt-5 w-full">
        <div class="card w-[95%]">
            <div class="card-body">
                <h5 class="card-title text-center font-bold text-2xl text-black bg-orange-500 p-3 rounded-lg">
                    ประวัติการเปลี่ยนโมเดล</h5>
                <div class="overflow-x-auto">
                    <table class="table w-full  text-black ">
                        <thead>
                            <tr class="text-center text-xl bg-info text-white">                                
                                <th>Date of Change</th>
                                <th>Shift</th>
                                <th>Customer</th>
                                <th>Model</th>
                                <th>Model of Change</th>
                                <th>Process</th>
                                <th>Won No.</th>
                                <th>SMT</th>
                                <th>Employee ID of Change</th>
                                <th>ID Name Record</th>
                                <th>Approve Change By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Add your data rows here -->
                            <tr v-for="(history, index) in changeHistory" :key="index" class="text-center text-[17px] font-semibold">
                                <td>{{ history.MMCHANGE_LSTDT }}</td>
                                <td>{{ history.MMCHANGE_SHIFT }}</td>
                                <td>{{ history.MMCHANGE_CUS }}</td>
                                <td>{{ history.MMCHANGE_MDL }}</td>
                                <td>{{ history.MMCHANGE_MDLCHN }}</td>
                                <td>{{ history.MMCHANGE_PRCS }}</td>
                                <td>{{ history.MMCHANGE_WONNO }}</td>
                                <td>{{ history.MMCHANGE_LINE }}</td>
                                <td>{{ history.MMCHANGE_EMPID }}</td>
                                <td></td>
                                <td>{{ history.MMCHANGE_APPR_EMPID }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            changeHistory: [],
        };
    },
    mounted() {
        this.fetchChangeHistory();
    },
    methods: {
        fetchChangeHistory() {
            axios.get('/L_MetalMaskRecord/api/get-change-history')
                .then(response => {
                    this.changeHistory = response.data;
                    console.log(this.changeHistory);
                })
                .catch(error => {
                    console.error('Error fetching change history:', error);
                })
        }
    }
}

</script>
