<template>
    <div class="flex items-center justify-center">
        <div class="bg-white w-[90%] lg:w-[50%] rounded-2xl shadow-2xl p-5 mt-5 mb-5 border border-sky-600">
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
                    <div class="modal-header flex justify-between items-center">
                        <h5 class="text-lg font-bold text-gray-800">{{ scannedResult }}</h5>


                    </div>
                    <div class="modal-content">
                        <div id="reader" style="width: 100%; max-width: 500px; margin: auto;"></div>
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
                        <label for="qrcode" class="label">QR Code ID: <span class="text-[16px]">กรณีกรอกเอง ใส่เลข mask no. 3 หลัก เช่น 001 , 008 เป็นต้น</span><span>&#128292;</span></label>

                        <input type="text" id="qrcode" v-model="mask.scannedResult"
                            class="input join-item input-bordered w-full focus:outline-none" @input="fetchRecData" />


                    </div>
                    <div class="flex flex-col col-span-2">
                        <label for="mdlcd" class="label">Employee ID: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.empid" placeholder="Input Employee ID"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>

                    <div class="flex flex-col col-span-2">
                        <label for="mdlcd" class="label">Model Code: <span>&#128292;</span></label>
                        <input type="text" v-model="mask.mdlcd" class="input input-bordered w-full focus:outline-none"
                            placeholder="Model Code">
                        <!-- <select v-model="mask.mdlcd" class="input input-bordered w-full focus:outline-none">
                            <option value="" disabled selected>เลือก Model Code</option>
                            <option v-for="item in listModel" :key="item.LISTMDL_MDLCD" :value="item.LISTMDL_MDLCD">{{
                                item.LISTMDL_MDLCD }}</option>
                        </select> -->

                    </div>
                    <div class="flex flex-col">
                        <label for="won" class="label">Work Order: <span>&#128292;</span></label>
                        <!-- <AutoComplete v-model="mask.won" :suggestions="items" field="label" @complete="search"
                            @change="checkModel" placeholder="Search WONO..." class="input w-full" /> -->

                        <input type="text" v-model="mask.won" class="input input-bordered w-full focus:outline-none"
                            placeholder="Search WONO..." />

                    </div>
                    <div class="flex flex-col">
                        <!-- <label for="listno" class="label">List No.: <span>&#128292;</span></label> -->
                        <input type="hidden" id="name" v-model="mask.listno"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>
                    <div class="flex flex-col">
                        <!-- <label for="cus" class="label">Customer: <span>&#128292;</span></label> -->
                        <input type="hidden" id="name" v-model="mask.cus"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>

                    <div class="flex flex-col">
                        <!-- <label for="pcbno" class="label">PCB No. <span>&#128292;</span></label> -->
                        <input type="hidden" id="name" v-model="mask.pcbno"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col">
                        <!-- <label for="mskname" class="label">Metal Mask Name: <span>&#128292;</span></label> -->
                        <input type="hidden" id="name" v-model="mask.mskname"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col">
                        <!-- <label for="process" class="label">Process: <span>&#128292;</span></label> -->
                        <input type="hidden" id="name" v-model="mask.procs"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>
                    <div class="flex flex-col">
                        <!-- <label for="rev" class="label">Revision: <span>🔢</span></label> -->
                        <input type="hidden" class="input input-bordered w-full focus:outline-none"
                            v-model="mask.rev" />
                    </div>
                    <div class="flex flex-col">
                        <!-- <label for="ref" class="label">Reference Number: <span>&#128292;</span></label> -->
                        <input type="hidden" id="name" v-model="mask.ref"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>



                    <div class="flex flex-col">
                        <!-- <label for="dateexpire" class="label">Product Date: <span>📆</span></label> -->
                        <input type="hidden" id="name" v-model="mask.expire_d"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <!-- <div class="flex flex-col">
                        <label for="lot" class="label">Lot Size: <span>🔢</span></label>
                         />

                    </div> -->
                    <input type="hidden" v-model="mask.lot" class="input input-bordered w-full focus:outline-none" />
                    <div class="flex flex-col">
                        <!-- <label for="vendor" class="label">Vendor/Maker: <span>&#128292;</span></label> -->
                        <input type="hidden" id="name" v-model="mask.vendor"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>

                    <input type="hidden" v-model="mask.blocksheet">



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

import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import "vue3-toastify/dist/index.css"
import { toast } from "vue3-toastify"
import axios from "axios";
// import Autocomplete from '@trevoreyre/autocomplete-vue'
import Swal from 'sweetalert2'

import AutoComplete from 'primevue/autocomplete';
import { Html5Qrcode } from "html5-qrcode";
export default {
    components: {
        AutoComplete,
        Html5Qrcode

    },
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    data() {

        return {
            isCameraOpen: false,
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
                listno: "",
                mdlcd: "",
                blocksheet: "",
                won: "",
                scannedResult: "",
                empid: "",
            },
            isModalOpen: false,
            listModel: [],
            items: [],
            mdlcode: "",
            runningSums: {},
            statusMap: {},
            found: false,
            html5QrCode: null,
            MaskData: [],
            getProcs: "",
            // decodedResult: "",

        };
    },
    validations() {
        if (this.getProcs === "CP") {
            return {}
        }
        return {
            mask: {
                pcbno: { required },
                ref: { required },
                cus: { required },
                procs: { required },
                expire_d: { required },
                // // lot: { required },
                rev: { required },
                mskname: { required },
                vendor: { required },

                listno: { required },
                mdlcd: { required },
                won: { required },

                // selectedItem: { required },
            }
        };
    },
    methods: {
        async toggleCamera() {
            this.isModalOpen = !this.isModalOpen;
            this.isModalOpen = true;
            await this.$nextTick(); // รอให้ DOM render ก่อนเริ่มกล้อง
            this.startScanner();
        },


        async startScanner() {
            const qrRegionId = "reader";

            if (!this.html5QrCode) {
                this.html5QrCode = new Html5Qrcode(qrRegionId);
            }

            const devices = await Html5Qrcode.getCameras();
            if (devices && devices.length) {
                const cameraId = devices[0].id; // กล้องตัวแรก (หรือเลือกจากรายการ)

                const config = { fps: 10, qrbox: 250 };

                try {
                    await this.html5QrCode.start(
                        cameraId,
                        config,
                        (decodedText) => {
                            this.mask.scannedResult = decodedText;
                            this.stopScanner();
                        },
                        (errorMessage) => {
                            // เงียบ error
                        }
                    );
                } catch (err) {
                    console.error("Camera start error:", err);
                    alert("ไม่สามารถเปิดกล้องได้: " + err.message);
                    this.stopScanner();
                }
            } else {
                alert("ไม่พบกล้องในอุปกรณ์นี้");
            }
        },
        async stopScanner() {
            if (this.html5QrCode && this.html5QrCode.isScanning) {
                await this.html5QrCode.stop();
                await this.html5QrCode.clear();
            }
            this.isModalOpen = false;

        },

        async savedData() {
            const isValid = await this.v$.$validate()
            console.log(this.mask);
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
                axios.post('/45_engmask/save-data', {
                    mask: this.mask
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    console.log(response.data);
                    if (response.data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Insert Data Successfully',
                            text: 'บันทึกข้อมูลสำเร็จ',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1500,
                        })
                            .then(() => {
                                location.reload();
                                this.mask = {
                                    pcbno: "",
                                    ref: "",
                                    cus: "",
                                    procs: "",
                                    expire_d: "",
                                    lot: "",
                                    rev: "",
                                    mskname: "",
                                    vendor: "",
                                    listno: "",
                                    mdlcd: "",
                                    blocksheet: "",
                                    won: "",
                                    scannedResult: "",
                                    empid: "",

                                }
                            })
                    }
                })
            }

        },
        search(event) {
            const query = event.query;
            axios.post('/45_engmask/search', {
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

        getLotsAndBs() {
            const won = this.dataWon;
            // console.log(won)

            axios.post('/45_engmask/get-wono', {
                won: won
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    this.mdlcode = response.data;
                    this.mdlcode.map((item => {
                        this.mask.cus = item.BGCD;
                        this.mask.lot = item.WONQT;
                        this.mask.blocksheet = item.MDLQTY;
                    }))
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        },

        startScanner() {
            const html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: 250 };

            html5QrCode.start(
                { facingMode: "environment" }, // กล้องหลัง
                config,
                (decodedText, decodedResult) => {
                    this.mask.scannedResult = decodedText;
                    this.isModalOpen = false;
                    this.isCameraOpen = false;
                    html5QrCode.stop().then(() => {

                        axios.post('/45_engmask/get-model-code', {
                            ref_id: this.mask.scannedResult,
                            prcs: this.mask.procs,
                            // mdlcd: this.mask.mdlcd,
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
                                for (let i = 0; i < this.listModel.length; i++) {
                                    if (this.mask.mdlcd === this.listModel[i].LISTMDL_MDLCD) {
                                        this.found = true;

                                        toast.success('Model Code is match!', {
                                            position: "top-center",
                                            duration: 5000,
                                            theme: "colored",
                                            autoClose: 2000,

                                        });
                                        break; // stop checking after a match
                                    }
                                }

                                // Show error only if not found after loop
                                if (!this.found) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Model Code is not found!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                                this.listModel.map((value) => {
                                    this.mask.listno = value.MMST_NO;
                                    this.mask.pcbno = value.MMST_PCBNO;
                                    this.mask.procs = value.MMST_PROCS;
                                    this.mask.expire_d = value.MMST_PRDDATE;
                                    this.mask.vendor = value.MMST_VENDOR;
                                    if (value.MMST_REMARK === "") {
                                        this.mask.remark = "-";
                                    } else {
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
                    }).catch(err => {
                        console.error("Failed to stop camera", err);
                    });
                },
                (errorMessage) => {
                    // ignore scan errors
                }
            ).catch(err => {
                console.error("Unable to start scanning.", err);
            });
        },




    },

    beforeUnmount() {
        if (this.codeReader) {
            this.codeReader.reset()
        }
    },
    mounted() {
        // this.fetchReportData();
        this.mask.won = this.dataWon;
        this.mask.mdlcd = this.dataModel;
        this.mask.cus = this.dataCus;
        this.mask.procs = this.dataProcess;
        // this.mask.empid = this.dataEmpid;
        this.getLotsAndBs();
        this.getProcs = this.dataProcess;
        console.log(this.getProcs)
        // this.fetchRecData()

    },
    computed: {
        dataWon() {
            return this.$route.query.wono;
        },
        dataModel() {
            return this.$route.query.model;
        },
        dataCus() {
            return this.$route.query.cus;
        },
        // dataEmpid() {
        //     return this.$route.query.empno
        // },
        dataProcess() {
            return this.$route.query.prcs;
        },
    },
   watch: {
    'mask.scannedResult'(newVal) {
        if (newVal.length == 3) {
            axios.post('/45_engmask/get-show-code', {
                ref_id: newVal,
                prcs: this.mask.procs,
            },
            {
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                this.listModel = response.data;
                console.log(this.listModel)

                this.found = false; // Reset before checking

                for (let i = 0; i < this.listModel.length; i++) {
                    if (this.mask.mdlcd === this.listModel[i].LISTMDL_MDLCD) {
                        this.found = true;
                        toast.success('Model Code is match!', {
                            position: "top-center",
                            duration: 5000,
                            theme: "colored",
                            autoClose: 2000,
                        });
                        break;
                    }
                }

                if (!this.found) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Model Code is not found!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                }

                // Use the first model to fill form fields
                if (this.listModel.length > 0) {
                    const value = this.listModel[0];
                    this.mask.listno = value.MMST_NO;
                    this.mask.pcbno = value.MMST_PCBNO;
                    this.mask.procs = value.MMST_PROCS;
                    this.mask.expire_d = value.MMST_PRDDATE;
                    this.mask.vendor = value.MMST_VENDOR;
                    this.mask.remark = value.MMST_REMARK === "" ? "-" : value.MMST_REMARK;
                    this.mask.rev = value.MMST_REVS;
                    this.mask.mskname = value.MMST_MSKNAME;
                    this.mask.ref = value.MMST_REFNO;
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
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
