<template>
    <div class="relative">
        <div class="flex justify-center items-center mt-5 w-full">
            <div class="card w-[45%] lg:w-[50%] bg-base-100 shadow-xl border border-cyan-600">
                <div class="flex flex-col justify-center items-center mt-5">
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
                <div class="card-body ">
                    <h5 class="card-title text-center font-bold text-2xl text-black bg-fuchsia-500 p-3 rounded-lg"><span
                            class="mr-3">&#128203;</span>Change Model Form</h5>
                    <form @submit.prevent="handleSubmit">
                        <div class="grid grid-cols-2  gap-4 text-black">
                            <div class="flex flex-col col-span-2">
                                <label for="Barcode" class="text-xl font-bold">QR_ID <span class="text-sky-600">(Scan
                                        auto
                                        show
                                        value)</span> : <span>&#128292;</span></label>
                                <input type="text" class="input input-bordered mt-2" placeholder="QR Code ID"
                                    v-model="formChange.barcode" />
                            </div>
                            <div class="flex flex-col col-span-2">
                                <label for="model" class="text-xl font-bold">Model <span class="text-sky-600">(Select
                                        Value)</span> :
                                    <span>&#128292;</span></label>
                                <select v-model="formChange.model"
                                    class="input input-bordered w-full focus:outline-none">
                                    <option value="" disabled selected>เลือก Model Code</option>
                                    <option v-for="item in listModel" :key="item.LISTMDL_MDLCD"
                                        :value="item.LISTMDL_MDLCD">
                                        {{
                                            item.LISTMDL_MDLCD }}</option>
                                </select>
                                <!-- <input type="text" class="input input-bordered mt-2" placeholder="Model Code"
                                v-model="formChange.model" /> -->
                            </div>
                            <div class="flex flex-col">
                                <label for="won" class="text-xl font-bold">Work Order No. :
                                    <span>&#128292;</span></label>
                                <AutoComplete v-model="formChange.wonNo" :suggestions="items" field="label"
                                    @complete="search" @change="checkModel" placeholder="Search WONO..."
                                    class="input input-bordered w-full mt-2" />

                            </div>
                            <div class="flex flex-col">
                                <label for="customer" class="text-xl font-bold">Customer <span
                                        class="text-sky-600">(Auto
                                        Show
                                        value)</span> : <span>&#128292;</span></label>
                                <input type="text" class="input input-bordered mt-2" placeholder="Customer"
                                    v-model="formChange.customer" />
                            </div>

                            <div class="flex flex-col">
                                <label for="Line" class="text-xl font-bold">Line SMT : <span>&#128292;</span></label>
                                <select class="select select-bordered mt-2" v-model="formChange.line">
                                    <option value="" disabled selected>Choose Line</option>
                                    <option value="SMT-1">SMT-1</option>
                                    <option value="SMT-2">SMT-2</option>
                                    <option value="SMT-3">SMT-3</option>
                                    <option value="SMT-4">SMT-4</option>
                                    <option value="SMT-5">SMT-5</option>
                                    <option value="SMT-6">SMT-6</option>
                                    <option value="SMT-7">SMT-7</option>
                                    <option value="SMT-8">SMT-8</option>
                                    <option value="SMT-9">SMT-9</option>
                                    <option value="SMT-10">SMT-10</option>
                                    <option value="SMT-11">SMT-11</option>
                                    <option value="SMT-12">SMT-12</option>
                                    <option value="SMT-13">SMT-13</option>
                                    <option value="SMT-14">SMT-14</option>
                                    <option value="SMT-15">SMT-15</option>
                                    <option value="SMT-16">SMT-16</option>
                                    <option value="SMT-17">SMT-17</option>
                                    <option value="SMT-18">SMT-18</option>
                                    <option value="SMT-19">SMT-19</option>
                                    <option value="SMT-20">SMT-20</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="process" class="text-xl font-bold">Process <span class="text-sky-600">(Auto
                                        Show
                                        value)</span> : <span>&#128292;</span></label>
                                <input type="text" class="input input-bordered mt-2" placeholder="Process"
                                    v-model="formChange.process" />
                            </div>
                            <div class="flex flex-col">
                                <label for="empID" class="text-xl font-bold">EmpID : <span>&#128292;</span></label>
                                <input type="text" class="input input-bordered mt-2" placeholder="Employee ID"
                                    v-model="formChange.empID" />
                            </div>


                            <div class="flex flex-col">
                                <label for="shift" class="text-xl font-bold">Shift : <span>&#127747; or
                                        &#127751;</span></label>
                                <select class="select select-bordered mt-2" v-model="formChange.shift">
                                    <option value="" disabled selected>Choose Shift</option>
                                    <option value="Day">Day</option>
                                    <option value="Night">Night</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-actions mt-5 justify-between">
                            <button
                                class="btn btn-success text-2xl h-12 font-bold hover:bg-white hover:text-success hover:border-0"
                                type="submit"><i class="pi pi-save"></i> Save</button>
                            <!-- <button class="btn bg-teal-500 border-0 text-2xl h-12 font-bold text-black hover:bg-white hover:text-teal-500 hover:border-0" type="submit"><i class="pi pi-user-edit"></i> Change</button> -->

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <div class="card w-[95%] mt-3 border border-cyan-600 ">
                <div class="card-body ">
                    <h5 class="card-title text-center font-bold text-2xl text-black bg-fuchsia-500 p-3 rounded-lg"><span
                            class="mr-3">&#128214;</span>Change Model History</h5>
                    <div class="overflow-x-auto">
                        <table class="table w-full  text-black ">
                            <thead>
                                <tr class="text-center text-xl bg-info text-white">
                                    <th>QR_ID</th>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>Customer</th>
                                    <th>Model</th>
                                    <th>Process</th>
                                    <th>Won No.</th>
                                    <th>SMT</th>
                                    <th>EmpID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add your data rows here -->
                                <tr v-for="data in dataChange" :key="data.MMCHANGE_ID">
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_BARCODE }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_LSTDT }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_SHIFT }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_CUS }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_MDL }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_PRCS }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_WONNO }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_LINE }}</td>
                                    <td class="text-lg font-semibold">{{ data.MMCHANGE_EMPID }}</td>
                                    <td class="space-x-5 ">
                                        <button class="btn btn-accent text-[18px]"
                                            @click="AprChange(data.MMCHANGE_ID , data.MMCHANGE_BARCODE)" :disabled="isDisabled">อนุมัติเปลี่ยน</button>
                                        <button class="btn btn-error text-[18px]" :disabled="isDisabled">ไม่อนุมัติเปลี่ยน</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>


        </div>
        <div class="flex justify-center items-center">
            <div class="card w-[50%] mt-3 border border-cyan-600 absolute top-190 " v-if="isModalShow">
            <div class="card-body">
                <h5 class="card-title bg-pink-200 p-5 rounded-lg text-2xl"><span class="mx-2">&#128204;</span>Input Remark for Submit Approve Change Model</h5>
                <p class="text-xl font-bold">{{ mChangeQRID }}</p>
                <form @submit.prevent="SubmitAprChange(mChangeID)">
                    <div class="grid grid-cols-1 mt-5">
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="model"
                                    class="join-item rounded-s-lg bg-pink-100 w-60 text-lg font-semibold flex justify-start items-center text-black">Employee ID:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Input Employee ID..." v-model="apr.empid" />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="model"
                                    class="join-item rounded-s-lg bg-pink-100 w-60 text-lg font-semibold flex justify-start items-center text-black">Remark for Approve:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Input Remark for Approve..." v-model="apr.aprremark" />
                            </div>

                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <button class="btn btn-error h-12 text-lg mt-5" @click="CloseModal">Close</button>
                        <button class="btn btn-success h-12 text-lg mt-5" >OK / Submit</button>
                    </div>
                </form>
            </div>
        </div>
        </div>

    </div>


</template>
<script>
import 'primeicons/primeicons.css'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import "vue3-toastify/dist/index.css"
import { toast } from "vue3-toastify";
import { QrcodeStream } from "vue3-qrcode-reader";
import AutoComplete from 'primevue/autocomplete';
import Swal from 'sweetalert2'
import axios from 'axios';
export default {
    components: {
        QrcodeStream,
        AutoComplete,
    },
    setup() {
        const v$ = useVuelidate()
        return { v$ }
    },
    data() {
        return {
            formChange: {
                barcode: '',
                empID: '',
                line: '',
                customer: '',
                process: '',
                model: '',
                wonNo: '',
                shift: ''
            },
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
            isModalOpen: false,
            listModel: [],
            items: [],
            mdlcode: "",
            dataChange: [],
            isModalShow: false,
            apr:{
                empid: "",
                aprremark: ""
            },
            mChangeQRID: "",
            isDisabled: false,
            mChangeID: "",


        }
    },
    validations() {
        return {
            formChange: {
                barcode: { required },
                empID: { required },
                line: { required },
                customer: { required },
                process: { required },
                model: { required },
                wonNo: { required },
                shift: { required }
            },

        }
    },
    mounted() {
        this.GetDataChange()
    },
    methods: {
        async handleSubmit() {
            // Handle form submission logic here
            console.log("Form submitted");
            const isValid = await this.v$.$validate()
            if (!isValid) {
                toast.error("Please fill in all required fields.", {
                    position: "top-center",
                    duration: 5000,
                    theme: "colored",
                    autoClose: 2000,

                })
            } else {
                //    console.log(this.formChange)
                axios.post('/L_MetalMaskRecord/insert-change-model', {
                    formChange: this.formChange
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => {
                        console.log(response.data);
                        if (response.data) {
                            toast.success("Change Model Success", {
                                position: "top-center",
                                duration: 5000,
                                theme: "colored",
                                autoClose: 2000,
                                onClose: () => {
                                    location.reload()
                                }
                            })
                            this.formChange = {
                                barcode: '',
                                empID: '',
                                line: '',
                                customer: '',
                                process: '',
                                model: '',
                                wonNo: '',
                                shift: ''
                            }
                            // location.reload()
                        } else {
                            toast.error("Change Model Failed", {
                                position: "top-center",
                                duration: 5000,
                                theme: "colored",
                                autoClose: 2000,
                            })
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

            }
        },
        toggleCamera() {
            this.isCameraOpen = !this.isCameraOpen;
            if (this.isCameraOpen) {
                this.formChange.barcode = "";
                this.isModalOpen = true;
            }
        },
        onDecode(result) {
            this.formChange.barcode = result;
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
                        //    this.formChange.model = value.LISTMDL_MDLCD;
                        this.formChange.process = value.MMST_PROCS;

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
            const won = this.formChange.wonNo;
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
                            if (this.formChange.model === item.MDLCD) {
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
                            this.formChange.customer = item.BSGRP;
                        }))
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

        },
        GetDataChange() {
            axios.get('/L_MetalMaskRecord/api/get-change-data')
                .then(res => {
                    this.dataChange = res.data;
                    console.log(this.dataChange);
                })
                .catch(error => {
                    console.error('Error fetching change data:', error);
                });
        },
        AprChange(id,qrid) {
            this.isModalShow = true;
            this.mChangeQRID = qrid;
            this.mChangeID = id;
            this.isDisabled = true;
        },
        CloseModal(){
            this.isModalShow = false;
            this.isDisabled = false;
        },
        SubmitAprChange(id){
            console.log(id)
        }


    },

}
</script>
