<template>
    <div class="flex items-center justify-center">
        <div class="bg-base-100 w-[50%] rounded-2xl shadow-2xl p-5 mt-5 mb-5">
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

            <h3 class="text-xl font-bold text-center mt-5 mb-3 bg-cyan-600 p-3 text-white rounded-lg"><span class="mr-3">&#128196;</span>แบบฟอร์มบันทึก
                Metal Mask
                Sheet</h3>
            <form @submit.prevent="savedData" class="text-xl font-bold text-blue-600 ">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col col-span-2">
                        <label for="qrcode" class="label">QR Code ID: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="scannedResult"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>

                    <div class="flex flex-col">
                        <label for="cus" class="label">Customer: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.cus"
                            class="input input-bordered w-full focus:outline-none" />
                    </div>
                    <div class="flex flex-col">
                        <label for="won" class="label">Work Order: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.won"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
                    <div class="flex flex-col">
                        <label for="model" class="label">Model Code: <span>&#128292;</span></label>
                        <input type="text" id="name" v-model="mask.mdlcd"
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
                    <div class="flex flex-col">
                        <label for="lot" class="label">Lot Size: <span>🔢</span></label>
                        <input type="text" id="name" v-model="mask.lot"
                            class="input input-bordered w-full focus:outline-none" />

                    </div>
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

                </div>
                <div class="flex justify-start mt-5">
                    <button type="submit" class="btn btn-primary w-[20%] text-xl font-semibold"><span
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

export default {
    components: { QrcodeStream},
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
                won: "",
                lot: "",
                rev: "",
                mdlcd: "",
                mskname: "",
                vendor: "",
                remark: "",
            },
            isModalOpen: false,
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
                won: { required },
                lot: { required },
                rev: { required },
                mdlcd: { required },
                mskname: { required },
                vendor: { required },
                remark: { required },
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
        },
        onInit(promise) {
            promise.catch(console.error);

        },
        async savedData() {
            const isValid = await this.v$.$validate()
            if (!isValid) {
                toast.error("Please fill in all required fields.", {
                    position: "top-center",
                    duration: 5000,
                    theme: "colored",
                    autoClose: 2000,
                });
            } else {
                toast.success("บันทึกข้อมูลสำเร็จ", {
                    position: "top-center",
                    duration: 5000,
                    theme: "colored",
                    autoClose: 2000,
                });

            }
        },
        handleItemSelected(item) {
            this.selectedItem = item;
        }

    },
};
</script>
