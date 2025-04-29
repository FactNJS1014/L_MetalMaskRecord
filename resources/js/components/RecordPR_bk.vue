<template>
    <div class="flex justify-center items-center">
        <div class="card p-3 mt-3">
            <div class="overflow-auto">
                <table class="table">  
                    <thead>
                        <tr class="bg-amber-500 text-xl">
                            <th>Model ที่ต้องการเปลี่ยนใช้งาน</th>
                            <th>Process</th>
                            <th>Customer</th>
                            <th>Employee</th>
                            <th>LINE PROD.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="e in changedata" :key="e.MMCHANGE_ID" class="text-[17px] font-semibold text-black">
                            <td>{{ e.MMCHANGE_MDLCHN }}</td>
                            <td>{{ e.MMCHANGE_PRCS }}</td>
                            <td>{{ e.MMCHANGE_CUS }}</td>
                            <td>{{ e.MMCHANGE_EMPID }}</td>
                            <td>{{ e.MMCHANGE_LINE }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-center">
        <div class="bg-base-100 w-[50%] rounded-2xl shadow-2xl p-5 mt-5 mb-5 border border-sky-600">
            <div class="flex flex-col justify-center items-center">
                <button @click="toggleCamera" class="btn btn-primary w-[10%] h-10">
                    <span
                        :class="isCameraOpen ? 'icon-[material-symbols--video-camera-back-rounded]  size-8' : 'icon-[material-symbols--video-camera-front-off-rounded] size-8'"></span>
                </button>
            </div>
            <!-- Modal Popup -->
            <div v-if="isModalOpen" id="middle-center-modal"
                class="overlay modal fixed inset-0 flex items-start justify-center bg-black bg-opacity-50 transition-opacity duration-300"
                :class="{ 'opacity-100': isModalOpen, 'hidden': !isModalOpen }" role="dialog" tabindex="-1">

                <div class="modal-dialog bg-white p-6 rounded-lg shadow-lg w-96 transition-transform duration-300 mt-10"
                    :class="{ 'opacity-100 scale-100': isModalOpen, 'opacity-0 scale-90': !isModalOpen }">

                    <div class="modal-content">
                        <qrcode-stream @decode="onDecode" @init="onInit" :constraints="cameraConstraints"
                            v-if="isCameraOpen" :scan-region-size="scanRegionSize" :paused="!isCameraOpen">
                            <template #default="{ decodedString }">
                                <div class="text-center">
                                    <p class="text-lg font-bold">{{ decodedString }}</p>
                                </div>
                            </template>
                            <template #error="{ error }">
                                <div class="text-red-500 text-center">
                                    <p>Error: {{ error }}</p>
                                </div>
                            </template>
                        </qrcode-stream>
                    </div>
                </div>
            </div>

            <h3 class="text-xl font-bold text-center mt-5 mb-3 bg-cyan-600 p-3 text-white rounded-lg"><span
                    class="mr-3">&#128196;</span>แบบฟอร์มบันทึก
                Metal Mask
                Sheet</h3>
            <form @submit.prevent="savedData" class="text-xl font-bold text-blue-600 ">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col col-span-2">
                        <label for="qrcode" class="label">QR Code ID: <span>&#128292;</span></label>
                        <input type="text" id="qrcode" v-model="mask.scannedResult"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>

                    <div class="flex flex-col col-span-2">
                        <label for="mdlcd" class="label">Model Code: <span>&#128292;</span></label>
                        <select v-model="mask.mdlcd" class="input input-bordered w-full focus:outline-none">
                            <option value="" disabled selected>เลือก Model Code</option>
                            <option v-for="item in listModel" :key="item.LISTMDL_MDLCD" :value="item.LISTMDL_MDLCD">{{
                                item.LISTMDL_MDLCD }}</option>
                        </select>

                    </div>
                    <div class="flex flex-col col-span-2">
                        <label for="won" class="label">Work Order: <span>&#128292;</span></label>
                        <AutoComplete v-model="mask.won" :suggestions="items" field="label" @complete="search"
                            @change="checkModel" placeholder="Search WONO..." class="input w-full" />

                    </div>
                    <input type="hidden" v-model="mask.lot">
                    <input type="hidden" v-model="mask.blocksheet">
                    <input type="hidden" v-model="mask.cus">            
                    <input type="hidden" v-model="mask.procs">            
                    <input type="hidden" v-model="mask.changeId">            
                              

                </div>
                <div class="flex justify-center items-center mt-10">
                    <button type="submit" class="btn btn-primary w-[25%] text-xl font-semibold"><span
                            class="icon-[material-symbols--save-as] size-6"></span>บันทึก</button>

                </div>
            </form>


        </div>
    </div>
</template>

<script>
import { QrcodeStream } from "vue3-qrcode-reader";
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import "vue3-toastify/dist/index.css"
import { toast } from "vue3-toastify"
import axios from "axios";
// import Autocomplete from '@trevoreyre/autocomplete-vue'
import Swal from 'sweetalert2'

import AutoComplete from 'primevue/autocomplete';

export default {
    components: {
        QrcodeStream,
        AutoComplete,

    },
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    data() {
        return {
            isCameraOpen: false,

            scanRegionSize: 3.1, // Adjust this value as needed
            cameraConstraints: {
                video: {
                    facingMode: "environment",
                    width: { ideal: 1920, min: 1280 },
                    height: { ideal: 1080, min: 720 },
                    focusMode: "continuous",
                    zoom: 2, // Try adding zoom (may not be supported on all devices)
                },
            },
            mask: {                
                  
                procs: "",                
                lot: "",           
                blocksheet: "",
                won: "",
                scannedResult: "",
                cus: "",
                changeId: "",
            },
            isModalOpen: false,
            listModel: [],
            items: [],
            mdlcode: "",
            runningSums: {},
            statusMap: {},
            changedata: []
        };
    },
    validations() {
        return {
            mask: {              
                     
                mdlcd: { required },
                won: { required },
                              
              
            }
        };
    },
    methods: {
        toggleCamera() {
            this.isCameraOpen = !this.isCameraOpen;
            if (this.isCameraOpen) {
                this.mask.scannedResult = "";
                this.isModalOpen = true;
            }
        },
        onDecode(result) {
            this.mask.scannedResult = result;
            this.isCameraOpen = false;
            this.isModalOpen = false;
            let id = result;
            const qrid = id.split('_');
            const ref_id = qrid[3];
            // console.log(ref_id)

            axios.post('/L_MetalMaskRecord/get-model-code', {
                ref_id: ref_id
            },
                {
                    headers: {
                        'Content-Type': 'application/json',

                    }
                })
                .then(response => {
                    // console.log(response.data);
                    this.listModel = response.data;
                    console.log(this.listModel)
                    this.listModel.map((value) => {
                        
                        this.mask.procs = value.MMST_PROCS;
                        

                    })


                    // Do something with response
                })
                .catch(error => {
                    console.error('Error:', error);
                });




        },
        onInit(promise) {
            promise.catch(console.error);

        },
        async savedData() {
            const isValid = await this.v$.$validate()
            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                console.log(this.mask);
                // axios.post('/L_MetalMaskRecord/save-data', {
                //     mask: this.mask
                // }, {
                //     headers: {
                //         'Content-Type': 'application/json'
                //     }
                // }).then(response => {
                //     // console.log(response.data);
                //     if (response.data) {
                //         Swal.fire({
                //             icon: 'success',
                //             title: 'Insert Data Successfully',
                //             text: 'บันทึกข้อมูลสำเร็จ',
                //             showCancelButton: false,
                //             showConfirmButton: false,
                //             timer: 1500,
                //         }).then(() => {
                //             location.reload();
                //         })
                //     }
                // })
            }

        },
        search(event) {
            const query = event.query;
            axios.post('/L_MetalMaskRecord/search', {
                query: query
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    this.items = response.data;



                })
                .catch(error => {
                    console.error('Error:', error);
                });


        },
        checkModel() {
            const won = this.mask.won;
            // console.log(this.mask.mdlcd)
            if (won.length >= 15) {
                axios.post('/L_MetalMaskRecord/get-wono', {
                    won: won
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => {
                        this.mdlcode = response.data;
                        this.mdlcode.map((item => {
                            // this.mask.cus = item.BSGRP;
                            if (this.mask.mdlcd === item.MDLCD) {
                                toast.success("Model Code is correct", {
                                    position: "top-center",
                                    duration: 5000,
                                    theme: "colored",
                                    autoClose: 2000,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Model Code is not correct',
                                    text: 'Model Code is not correct',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1500,
                                })
                            }                           
                            this.mask.lot = item.WONQT;
                            this.mask.cus = item.BGCD
                            this.mask.blocksheet = item.MDLQTY
                        }))
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

        },
        async fetchReportData() {
            try {
                const res = await axios.get('/L_MetalMaskRecord/api/get-values');
                const data = res.data;

                this.MaskData = data;

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

                Object.entries(grouped).forEach(([mdl, total]) => {
                    const notified = notifyStatus[mdl] == 1;

                    if (total >= 600 && !notified) {
                        Swal.fire({
                            title: 'แจ้งเตือน!',
                            text: `Model: ${mdl} ครบ ${total} แล้ว!`,
                            icon: 'warning',
                            confirmButtonText: 'ตกลง',
                            confirmButtonColor: '#8b5cf6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // PUT เพื่อ update notify std
                                axios.put('/L_MetalMaskRecord/update-notify-status', {
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
        async fetchChangeModel(){
            const res = await axios.get('/L_MetalMaskRecord/api/get-change-model')
            const data = res.data
            this.changedata = data
           
            console.log(data)
        }


    },
    mounted() {
        this.fetchReportData();
        this.fetchChangeModel();
    }
}
</script>

<style>
.p-autocomplete-list-container {
    overflow: auto;
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    z-index: 1000;
    font-size: 16px;
    padding: 5px;
}

.p-autocomplete-list-container .p-autocomplete-list .p-autocomplete-option:hover {
    background-color: #e0f7fa;
    color: #00796b;

}
</style>
