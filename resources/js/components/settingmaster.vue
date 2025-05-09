<template>
    <div class="mt-3 flex justify-center items-center">
        <div class="grid grid-cols-2 w-full gap-4 py-4 px-[30%]">
            <button class="cursor-pointer transition hover:shadow-md hover:scale-105 duration-300"
                @click="OpenMenuSettingModel" v-if="Menu">
                <div class="flex flex-col">
                    <div class="card bg-yellow-300">
                        <div class="flex justify-center items-center">
                            <img :src="imagePath01" alt="" class="w-3/4">
                        </div>
                        <div class="card-title text-center py-6 bg-blue-800 rounded-b-lg">
                            <h5 class="font-bold text-[25px] text-white">Setting Models</h5>
                        </div>
                    </div>
                </div>
            </button>

            <button class="cursor-pointer transition hover:shadow-md hover:scale-105 duration-300"
                @click="OpenMenuSettingMask" v-if="Menu">
                <div class="flex flex-col">
                    <div class="card bg-green-300 ">
                        <div class="flex justify-center items-center">
                            <img :src="imagePath02" alt="" class="w-3/4">
                        </div>
                        <div class="card-title text-center py-6 bg-blue-800 rounded-b-lg">
                            <h5 class="font-bold text-[25px] text-white">Setting Metal Mask</h5>
                        </div>
                    </div>
                </div>
            </button>
            <button class="cursor-pointer transition hover:shadow-md hover:scale-105 duration-300" v-if="Menu"
                @click="OpenMenulistModels">
                <div class="flex flex-col">
                    <div class="card bg-sky-300">
                        <div class="flex justify-center items-center">
                            <img :src="imagePath03" alt="" class="w-3/4">
                        </div>
                        <div class="card-title text-center py-6 bg-blue-800 rounded-b-lg">
                            <h5 class="font-bold text-[25px] text-white">ข้อมูลตั้งค่า Models</h5>
                        </div>
                    </div>
                </div>
            </button>

            <button class="cursor-pointer transition hover:shadow-md hover:scale-105 duration-300" v-if="Menu"
                @click="OpenMenulistMask">
                <div class="flex flex-col">
                    <div class="card bg-red-300">
                        <div class="flex justify-center items-center">
                            <img :src="imagePath04" alt="" class="w-3/4">
                        </div>
                        <div class="card-title text-center py-6 bg-blue-800 rounded-b-lg">
                            <h5 class="font-bold text-[20px] text-white lg:text-[25px]">ข้อมูลตั้งค่า Metal Mask</h5>
                        </div>
                    </div>
                </div>
            </button>
        </div>

    </div>

    <div class="mt-3 flex justify-center items-center">

        <div class="card w-[50%] mb-3 border border-emerald-300 bg-white shadow-lg" v-if="settingModel">
            <div class="card-body">

                <h5 class="card-title mb-0 text-center bg-emerald-300 p-5 rounded-lg text-black font-bold text-2xl">
                    Setting Model Form</h5>

                <form @submit.prevent="SubmitAddModel">
                    <div class="grid grid-cols-2 mt-5">
                        <div class="flex flex-col col-span-2 w-full">
                            <div class="join mb-3">
                                <label for="qrid"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-center items-center">QR
                                    Code ID:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="QR Code Number..." v-model="formf.codeid" />

                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="model"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">Model:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Model..." v-model="formf.model" />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="pcbno"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">PCB
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="PCB Number..." v-model="formf.pcbno" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="process"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">Process:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Process..." v-model="formf.procs" />
                            </div>

                        </div>




                    </div>
                    <table class="table">
                        <thead>
                            <tr class="text-center bg-emerald-100">
                                <th colspan="4">Mask No.</th>
                            </tr>
                            <tr class="text-center border">
                                <th class="border">1</th>
                                <th class="border">2</th>
                                <th class="border">3</th>
                                <th class="border">4</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border">
                                <td class="border">
                                    <input type="number" class="input input-bordered" placeholder="Mask No. 1"
                                        v-model="formf.nofirst" />
                                </td>
                                <td class="border">
                                    <input type="number" class="input input-bordered" placeholder="Mask No. 2"
                                        v-model="formf.nosecond" />
                                </td>
                                <td class="border">
                                    <input type="number" class="input input-bordered" placeholder="Mask No. 3"
                                        v-model="formf.nothird" />
                                </td>
                                <td class="border">
                                    <input type="number" class="input input-bordered" placeholder="Mask No. 4"
                                        v-model="formf.nofourth" />
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <div class="flex justify-end items-center mt-5">
                        <button type="submit"
                            class="btn btn-primary bg-emerald-300 text-black font-bold text-xl rounded-lg p-6 hover:bg-emerald-100 ">
                            &#128190; Save</button>

                    </div>

                </form>
            </div>
        </div>
        <div class="card w-[70%] mb-3 border border-emerald-300 bg-white shadow-lg" v-if="settingMsk">

            <div class="card-body">


                <h5
                    class="card-title mb-0 text-center bg-emerald-300 p-5 rounded-lg text-black font-bold text-2xl mt-3">
                    Setting Metal Mask Form</h5>


                <form @submit.prevent="SubmitAddMask">
                    <div class="grid grid-cols-2 mt-5">
                        <div class="flex flex-col col-span-2">
                            <div class="join mb-3">
                                <label for="qrid"
                                    class="join-item rounded-s-lg bg-emerald-100 w-37 text-lg font-semibold flex justify-start items-center">QR
                                    Code ID:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="QR Code ID..." v-model="forms.qrid" />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="listno"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">List
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="List Number Sequence..." v-model="forms.listno" />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="customer"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Customer:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Customer..." v-model="forms.cus" />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="pcbno"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">PCB
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="PCB Number..." v-model="forms.pcbnum" />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="maskname"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">
                                    Mask Name:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Metal Mask Name..." v-model="forms.maskname" />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="process"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Process:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Process..." v-model="forms.process" />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="revision"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Revision:</label>
                                <input type="number" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Revision..." v-model="forms.revision" />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="ref"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Ref.
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Reference Number..." v-model="forms.ref" />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="productdate"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Product
                                    Date:</label>
                                <input type="date" class="input input-bordered join-item rounded-e-lg" v-model="forms.productdate" />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="vendor"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Vendor/Maker:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Vendor/Maker..." v-model="forms.vendor" />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="remark"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Remark:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Remark..." v-model="forms.remark" />
                            </div>

                        </div>

                    </div>
                    <div class="flex justify-end items-center">
                        <button type="submit"
                            class="btn btn-primary bg-emerald-300 text-black font-bold text-xl rounded-lg p-6 hover:bg-emerald-100 ">
                            &#128190; Save</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="card w-[70%] mb-3 border border-emerald-300 bg-white shadow-lg" v-if="reportSettingModels">
            <div class="card-header bg-emerald-600">
                <h5 class="text-center text-[22px] text-white font-bold">ข้อมูลรายการ Setting Models ทั้งหมด </h5>
            </div>
            <div class="card-body">
                <div class="w-full p-3 rounded ">
                    <div class="flex justify-end mb-4 mt-3 items-center">
                        <input type="text" placeholder="Search..." class="input input-bordered w-full max-w-xs"
                            v-model="searchModels" @input="SearchFilterModels" />

                    </div>
                    <DataTable :value="listModels" tableStyle="min-width: 50rem" showGridlines paginator :rows="10"
                        :rowsPerPageOptions="[5, 10, 20, 50]"
                       >
                        <Column field="LISTMDL_MDLCD" header="Model Code" style="min-width: 250px;"></Column>
                        <Column field="LISTMDL_GRPPCB" header="Group PCB" style="min-width: 250px;"></Column>
                        <Column field="LISTMDL_PROCS" header="Process" style="min-width: 150px;"></Column>
                        <Column field="LISTMDL_MSKNO1" header="Mask No.1" style="min-width: 150px;"></Column>
                        <Column field="LISTMDL_MSKNO2" header="Mask No.2" style="min-width: 150px;"></Column>
                        <Column field="LISTMDL_MSKNO3" header="Mask No.3" style="min-width: 150px;"></Column>
                        <Column field="LISTMDL_MSKNO4" header="Mask No.4" style="min-width: 150px;"></Column>
                        <Column field="LISTMDL_QRID" header="QR Code ID" style="min-width: 300px;"></Column>
                        <Column field="LISTMDL_STD" header="Status" style="min-width: 100px;"></Column>

                    </DataTable>
                </div>
            </div>
        </div>
        <div class="card w-[70%] mb-3 border border-emerald-300 bg-white shadow-lg" v-if="reportSettingMask">
            <div class="card-header bg-emerald-600">
                <h5 class="text-center text-[22px] text-white font-bold">ข้อมูลรายการ Setting Metal Mask ทั้งหมด </h5>
            </div>
            <div class="card-body">
                <div class="w-full p-3 rounded ">
                    <div class="flex justify-end mb-4 mt-3 items-center">
                        <input type="text" placeholder="Search..." class="input input-bordered w-full max-w-xs"
                            v-model="searchMask" @input="SearchFilterMask" />
                    </div>
                    <DataTable :value="listMask" tableStyle="min-width: 50rem" showGridlines paginator :rows="10"
                        :rowsPerPageOptions="[5, 10, 20, 50]" scrollable :scrollHeight="dynamicHeight">
                        <Column field="MMST_QRID" header="QR Code ID" style="min-width: 400px"></Column>
                        <Column field="MMST_NO" header="List Number" style="min-width: 200px"></Column>
                        <Column field="MMST_CUS" header="Customer" style="min-width: 200px"></Column>
                        <Column field="MMST_PCBNO" header="PCB Number" style="min-width: 300px"></Column>
                        <Column field="MMST_MSKNAME" header="Metal Mask Name" style="min-width: 400px"></Column>
                        <Column field="MMST_PROCS" header="Process"></Column>
                        <Column field="MMST_REVS" header="Revision"></Column>
                        <Column field="MMST_PRDDATE" header="Product Date" style="min-width: 300px"></Column>
                        <Column field="MMST_VENDOR" header="Vendor" style="min-width: 300px"></Column>
                        <Column field="MMST_REMARK" header="Remark" style="min-width: 400px"></Column>

                    </DataTable>
                </div>
            </div>
        </div>

    </div>
    <div class="flex justify-center items-center">
        <button class="btn btn-accent text-[50px] bg-white h-4/5" @click="btnGoback" v-if="btnback">&#128281;</button>

    </div>
</template>
<script>
import axios from 'axios'
import Swal from 'sweetalert2'

export default {
    name: 'Settingmaster',
    data() {
        return {
            settingModel: false,
            settingMsk: false,
            DataModelChange: [],
            GetData: "",
            formf: {
                model: '',
                pcbno: '',
                procs: '',
                codeid: '',
                nofirst: '',
                nosecond: '',
                nothird: '',
                nofourth: '',
            },
            forms:{
                qrid: '',
                listno: '',
                customer: '',
                pcbnum: '',
                maskname: '',
                process: '',
                revision: '',
                ref: '',
                productdate: '',
                vendor: '',
                remark: '',
            },
            Menu: true,
            btnback: false,
            reportSettingModels: false,
            listModels: [],
            reportSettingMask: false,
            listMask: [],
            searchModels: "",
            searchMask: "",
            imagePath01: '',
            imagePath02: '',
            imagePath03: '',
            imagePath04: '',
        }
    },
    mounted() {
        this.settingModel = false
        this.settingMsk = false
        this.reportSettingModels = false

        this.GetlistModels()
        this.reportSettingMask = false
        this.GetlistMask()

        this.imagePath01 = window.imagePath1
        this.imagePath02 = window.imagePath2
        this.imagePath03 = window.imagePath3
        this.imagePath04 = window.imagePath4
    },
    methods: {

        PullData(code) {
            axios.get('/45_engmask/api/get-pull-data', {
                params: {
                    code: code
                }
            }).then(res => {
                this.GetData = res.data
                this.GetData.map((data) => {
                    this.formf.model = data.MMCHANGE_MDL
                    this.formf.pcbno = data.MMST_PCBNO
                    this.formf.procs = data.MMST_PROCS
                    this.formf.ref = data.MMST_REFNO
                    this.formf.codeid = data.MMST_QRID
                })
            })
        },
        SubmitChange() {
            console.log(this.formf)
        },
        btnGoback() {
            this.settingModel = false
            this.settingMsk = false
            this.Menu = true
            this.btnback = false
            this.reportSettingModels = false
            this.reportSettingMask = false
        },
        OpenMenuSettingModel() {
            this.settingModel = true
            this.settingMsk = false
            this.Menu = false
            this.btnback = true
            this.reportSettingModels = false
            this.reportSettingMask = false
        },
        OpenMenuSettingMask() {
            this.settingModel = false
            this.settingMsk = true
            this.Menu = false
            this.btnback = true
            this.reportSettingModels = false
            this.reportSettingMask = false
        },
        OpenMenulistModels() {
            this.settingModel = false
            this.settingMsk = false
            this.Menu = false
            this.btnback = true
            this.reportSettingModels = true
            this.reportSettingMask = false
        },
        GetlistModels() {
            axios.get('/45_engmask/api/get-list-models')
                .then(res => {
                    this.listModels = res.data
                })
        },
        OpenMenulistMask() {
            this.settingModel = false
            this.settingMsk = false
            this.Menu = false
            this.btnback = true
            this.reportSettingModels = false
            this.reportSettingMask = true
        },
        GetlistMask() {
            axios.get('/45_engmask/api/get-list-mask')
                .then(res => {
                    this.listMask = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        },
        SearchFilterModels() {
            const searchValue = this.searchModels
            if (searchValue === "") {
                this.GetlistModels()
            } else {
                axios.post('/45_engmask/search-list-models', {
                    search: searchValue
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(res => {
                    this.listModels = res.data
                }).catch(err => {
                    console.log(err)
                })
            }
        },
        SearchFilterMask() {
            const searchValue = this.searchMask
            if (searchValue === "") {
                this.GetlistMask()
            } else {
                axios.post('/45_engmask/search-list-masks', {
                    search: searchValue
                }).then(res => {
                    this.listMask = res.data
                }).catch(err => {
                    console.log(err)
                })
            }
        },
        SubmitAddModel(){
            console.log(this.formf)
            if(this.formf.nosecond == '' || this.formf.nothird == '' || this.formf.nofourth == ''){
                this.formf.nosecond = 0
                this.formf.nothird = 0
                this.formf.nofourth = 0
            }
            axios.post('/45_engmask/add-setting-models', {
                formf: this.formf
            }).then(res => {
                console.log(res.data)
                if(res.data == 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Insert or Update Data Successfully',
                        text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.formf = {
                        model: '',
                        pcbno: '',
                        procs: '',
                        codeid: '',
                        nofirst: '',
                        nosecond: '',
                        nothird: '',
                        nofourth: '',
                    }
                }
            }).catch(err => {
                console.log(err)
            })
        },
        EditData(data){
            const cloneData = data;
            console.log(cloneData)

        },
        SubmitAddMask(){
            console.log(this.forms)
            axios.post('/45_engmask/add-setting-mask', {
                forms: this.forms
            }).then(res => {
                console.log(res.data)
                if(res.data == 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Insert or Update Data Successfully',
                        text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.forms = {
                        qrid: '',
                        listno: '',
                        customer: '',
                        pcbnum: '',
                        maskname: '',
                        process: '',
                        revision: '',
                        ref: '',
                        productdate: '',
                        vendor: '',
                        remark: '',
                    }
                }
            }).catch(err => {
                console.log(err)
            })
        },
    }
}
</script>

