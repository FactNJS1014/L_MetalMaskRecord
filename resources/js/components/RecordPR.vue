<template>
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
                        <input type="text" id="qrcode" v-model="scannedResult"
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
                    <div class="flex flex-col">
                        <label for="won" class="label">Work Order: <span>&#128292;</span></label>
                        <AutoComplete v-model="won" :suggestions="items" field="label" @complete="search"
                        @change="checkModel"
                            placeholder="Search WONO..." class="input input-bordered w-full" />




                        <!-- <div>
                            <autocomplete v-model="searchQuery" :items="items" :search="onSearch"
                                placeholder="Search WONNO..." class="input input-bordered w-full focus:outline-none" />
                        </div> -->
                    </div>
                    <div class="flex flex-col">
                        <label for="listno" class="label">List No.: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.listno"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>
                    <div class="flex flex-col">
                        <label for="cus" class="label">Customer: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.cus"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>

                    <div class="flex flex-col">
                        <label for="pcbno" class="label">PCB No. <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.pcbno"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col">
                        <label for="mskname" class="label">Metal Mask Name: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.mskname"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col">
                        <label for="process" class="label">Process: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.procs"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>
                    <div class="flex flex-col">
                        <label for="rev" class="label">Revision: <span>🔢</span></label>
                        <input type="number" class="input input-bordered w-full focus:outline-none"
                            v-model="mask.rev" />
                    </div>
                    <div class="flex flex-col">
                        <label for="ref" class="label">Reference Number: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.ref"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>



                    <div class="flex flex-col">
                        <label for="dateexpire" class="label">Product Date: <span>📆</span></label>
                        <input type="date" id="name" v-model="mask.expire_d"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <!-- <div class="flex flex-col">
                        <label for="lot" class="label">Lot Size: <span>🔢</span></label>
                         />

                    </div> -->
                    <input type="hidden" v-model="mask.lot" class="input input-bordered w-full focus:outline-none" />
                    <div class="flex flex-col">
                        <label for="vendor" class="label">Vendor/Maker: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.vendor"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col">
                        <label for="remark" class="label">Remark: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.remark"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col">
                        <label for="details" class="label">Details: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.details"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col mt-3 ms-3">
                        <label for="types" class="label">Types: <span>&#9989;</span></label>
                        <div class="flex flex-row gap-2">
                            <div class="flex items-center gap-1">
                                <input type="radio" v-model="mask.types" class="radio" id="defaultRadio1"
                                    value="receive" />
                                <label class="label-text text-blue-600 text-xl" for="defaultRadio1">Receive</label>
                            </div>
                            <div class="flex items-center gap-1">
                                <input type="radio" v-model="mask.types" class="radio" id="defaultRadio2"
                                    value="takeout" />
                                <label class="label-text text-blue-600 text-xl" for="defaultRadio2">Take out</label>
                            </div>
                        </div>
                        <div class="flex flex-row gap-4">
                            <div class="flex items-center gap-1">
                                <input type="radio" v-model="mask.types" class="radio" id="defaultRadio3"
                                    value="return" />
                                <label class="label-text text-blue-600 text-xl" for="defaultRadio3">Return</label>
                            </div>
                            <div class="flex items-center gap-1">
                                <input type="radio" v-model="mask.types" class="radio" id="defaultRadio4"
                                    value="scrap" />
                                <label class="label-text text-blue-600 text-xl" for="defaultRadio4">Scrap</label>
                            </div>
                        </div>
                    </div>



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
            scannedResult: "",
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
                pcbno: "",
                ref: "",
                cus: "",
                procs: "",
                expire_d: "",
                lot: "",
                rev: "",
                mskname: "",
                vendor: "",
                remark: "",
                details: "",
                types: "",
                listno: "",
                mdlcd: "",

            },
            isModalOpen: false,
            listModel: [],
            items: [],
            won: "",
            mdlcode: "",

        };
    },
    validations() {
        return {
            mask: {
                pcbno: { required },
                ref: { required },
                cus: { required },
                procs: { required },
                expire_d: { required },
                // lot: { required },
                rev: { required },
                mskname: { required },
                vendor: { required },
                remark: { required },
                types: { required },
                listno: { required },
                mdlcd: { required },
                won: { required },
                // selectedItem: { required },
            }
        };
    },
    methods: {
        toggleCamera() {
            this.isCameraOpen = !this.isCameraOpen;
            if (this.isCameraOpen) {
                this.scannedResult = "";
                this.isModalOpen = true;
            }
        },
        onDecode(result) {
            this.scannedResult = result;
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
                    this.listModel.map((value)=>{
                        this.mask.listno = value.MMST_NO;
                        this.mask.pcbno = value.MMST_PCBNO;
                        this.mask.procs = value.MMST_PROCS;
                        this.mask.expire_d = value.MMST_PRDDATE;
                        this.mask.vendor = value.MMST_VENDOR;
                        if(value.MMST_REMARK === ""){
                            this.mask.remark = "-";
                        }else{
                            this.mask.remark = value.MMST_REMARK;
                        }
                        this.mask.rev = value.MMST_REVS;
                        this.mask.mskname = value.MMST_MSKNAME;
                        this.mask.ref = value.MMST_REFNO;

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
                toast.success("บันทึกข้อมูลสำเร็จ", {
                    position: "top-center",
                    duration: 5000,
                    theme: "colored",
                    autoClose: 2000,
                });

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
        checkModel(){
            const won = this.won;
            // console.log(this.mask.mdlcd)
            if(won.length >= 15){
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
                        if(this.mask.mdlcd === item.MDLCD){
                            toast.success("Model Code is correct", {
                                position: "top-center",
                                duration: 5000,
                                theme: "colored",
                                autoClose: 2000,
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Model Code is not correct',
                                text: 'Model Code is not correct',
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }
                        this.mask.cus = item.BSGRP;
                    }))
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

        }



    },


};
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
