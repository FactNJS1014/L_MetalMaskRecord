<template>
    <div class="mt-3 flex justify-center items-center">
        <div class="grid grid-cols-2 w-full gap-4 py-4 px-[30%]">
            <button class="cursor-pointer transition hover:shadow-md hover:scale-105 duration-300"
                @click="OpenMenuSettingModel" v-if="Menu">
                <div class="flex flex-col">
                    <div class="card bg-yellow-300">
                        <div class="flex justify-center items-center">
                            <img src="../../../public/pictures/Setting Model-new.svg" alt="" class="w-3/4">
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
                            <img src="/public/pictures/SettingMask.svg" alt="" class="w-3/4">
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
                            <img src="/public/pictures/RP Model.svg" alt="" class="w-3/4">
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
                            <img src="/public/pictures/RP Mask.svg" alt="" class="w-3/4">
                        </div>
                        <div class="card-title text-center py-6 bg-blue-800 rounded-b-lg">
                            <h5 class="font-bold text-[25px] text-white">ข้อมูลตั้งค่า Metal Mask</h5>
                        </div>
                    </div>
                </div>
            </button>
        </div>

    </div>

    <div class="mt-3 flex justify-center items-center">

        <div class="card w-[50%] mb-3 border border-emerald-300 bg-white shadow-lg" v-if="settingModel">
            <div class="card-body">
                <div class="border-base-content/25 w-full overflow-x-auto border">
                    <div class="">
                        <table class="table">
                            <thead>
                                <tr class="bg-emerald-500 text-white">
                                    <th class="text-center text-lg font-semibold">Model เดิม</th>
                                    <th class="text-center text-lg font-semibold">Model ที่ต้องการเปลี่ยนแปลง</th>
                                    <th class="text-center text-lg font-semibold">PCB No.</th>
                                    <th class="text-center text-lg font-semibold">Process</th>
                                    <th class="text-center text-lg font-semibold">QR Code ID</th>
                                    <th class="text-center text-lg font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in DataModelChange" :key="item.MMCHANGE_ID">
                                    <td class="text-center text-lg font-semibold">{{ item.MMCHANGE_MDL }}</td>
                                    <td class="text-center text-lg font-semibold">{{ item.MMCHANGE_MDLCHN }}</td>
                                    <td class="text-center text-lg font-semibold">{{ item.MMCHANGE_PRCS }}</td>
                                    <td class="text-center text-lg font-semibold">{{ item.MMCHANGE_REFNO }}</td>
                                    <td class="text-center text-lg font-semibold">{{ item.MMCHANGE_BARCODE }}</td>
                                    <td class="text-center text-lg font-semibold">
                                        <button type="button" class="btn btn-success text-white text-xl"
                                            @click="PullData(item.MMCHANGE_BARCODE)"><span>&#128317;</span>ดึงข้อมูล
                                        </button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <h5 class="card-title mb-0 text-center bg-emerald-300 p-5 rounded-lg text-black font-bold text-2xl">
                    Setting Model Form</h5>

                <form @submit.prevent="SubmitChange">
                    <div class="grid grid-cols-2 mt-5">
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
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="ref"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">Ref.
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Reference Number..." v-model="formf.ref" />
                            </div>
                        </div>
                        <div class="flex flex-col col-span-2 w-full">
                            <div class="join mb-3">
                                <label for="qrid"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-center items-center">QR
                                    Code ID:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="QR Code Number..." v-model="formf.codeid" />

                            </div>
                        </div>

                    </div>
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


                <form>
                    <div class="grid grid-cols-2 mt-5">
                        <div class="flex flex-col col-span-2">
                            <div class="join mb-3">
                                <label for="qrid"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">QR
                                    Code ID:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="QR Code ID..." />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="listno"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">List
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="List Number Sequence..." />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="customer"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Customer:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Customer..." />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="pcbno"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">PCB
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="PCB Number..." />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="maskname"
                                    class="join-item rounded-s-lg bg-emerald-100 w-56 text-lg font-semibold flex justify-start items-center">Metal
                                    Mask Name:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Metal Mask Name..." />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="process"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Process:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Process..." />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="revision"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Revision:</label>
                                <input type="number" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Revision..." />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="ref"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Ref.
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Reference Number..." />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="productdate"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Product
                                    Date:</label>
                                <input type="date" class="input input-bordered join-item rounded-e-lg" />
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="vendor"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Vendor/Maker:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Vendor/Maker..." />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="remark"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-start items-center">Remark:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Remark..." />
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
                        :rowsPerPageOptions="[5, 10, 20, 50]">
                        <Column field="LISTMDL_MDLCD" header="Model Code"></Column>
                        <Column field="LISTMDL_GRPPCB" header="Group PCB"></Column>
                        <Column field="LISTMDL_PROCS" header="Process"></Column>
                        <Column field="LISTMDL_QRID" header="QR Code ID"></Column>
                        <Column field="LISTMDL_STD" header="Status"></Column>
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
import { ref, onMounted, reactive } from 'vue'
import axios from 'axios'


export default {
    name: 'SettingMaster',
    setup() {
        const settingModel = ref(false)
        const settingMsk = ref(false)
        const DataModelChange = ref([])
        const GetData = ref("")
        const formf = reactive({
            model: '',
            pcbno: '',
            procs: '',
            ref: '',
            codeid: '',
        })
        const Menu = ref(true)
        const btnback = ref(false)
        const reportSettingModels = ref(false)
        const listModels = ref([])
        const reportSettingMask = ref(false)
        const listMask = ref([])
        const searchModels = ref("")
        const searchMask = ref("")

        onMounted(() => {
            settingModel.value = false
            settingMsk.value = false
            reportSettingModels.value = false
            GetDataModelChange()
            GetlistModels()
            reportSettingMask.value = false
            GetlistMask()

        })

        function GetDataModelChange() {
            axios.get('/L_MetalMaskRecord/api/get-change-model')
                .then(res => {
                    DataModelChange.value = res.data
                    DataModelChange.value.map((g) => {
                        code_id = g.MMCHANGE_BARCODE
                    })

                })

        }

        function PullData(code) {
            axios.get('/L_MetalMaskRecord/api/get-pull-data', {
                params: {
                    code: code
                }
            }).then(res => {
                GetData.value = res.data
                GetData.value.map((data) => {
                    formf.model = data.MMCHANGE_MDL
                    formf.pcbno = data.MMST_PCBNO
                    formf.procs = data.MMST_PROCS
                    formf.ref = data.MMST_REFNO
                    formf.codeid = data.MMST_QRID
                })
            })

        }
        function SubmitChange() {
            console.log(formf)
        }
        function btnGoback() {
            settingModel.value = false
            settingMsk.value = false
            Menu.value = true
            btnback.value = false
            reportSettingModels.value = false
            reportSettingMask.value = false
        }

        function OpenMenuSettingModel() {
            settingModel.value = true
            settingMsk.value = false
            Menu.value = false
            btnback.value = true
            reportSettingModels.value = false
            reportSettingMask.value = false
        }
        function OpenMenuSettingMask() {
            settingModel.value = false
            settingMsk.value = true
            Menu.value = false
            btnback.value = true
            reportSettingModels.value = false
            reportSettingMask.value = false
        }

        function OpenMenulistModels() {
            settingModel.value = false
            settingMsk.value = false
            Menu.value = false
            btnback.value = true
            reportSettingModels.value = true
            reportSettingMask.value = false
        }

        function GetlistModels() {
            axios.get('/L_MetalMaskRecord/api/get-list-models')
                .then(res => {
                    // console.log(res.data)
                    listModels.value = res.data
                })
        }

        function OpenMenulistMask() {
            settingModel.value = false
            settingMsk.value = false
            Menu.value = false
            btnback.value = true
            reportSettingModels.value = false
            reportSettingMask.value = true
        }

        function GetlistMask() {
            axios.get('/L_MetalMaskRecord/api/get-list-mask')
                .then(res => {
                    // console.log(res.data)
                    listMask.value = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        }

        function SearchFilterModels() {
            const searchValue = searchModels.value;
            console.log(searchValue)
            if (searchValue == "") {
                GetlistModels()
                return
            } else {
                axios.post('/L_MetalMaskRecord/search-list-models', {

                    search: searchValue

                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(res => {
                    listModels.value = res.data
                    // console.log(res.data)
                })
                    .catch(err => {
                        console.log(err)
                    })
            }


        }

        function SearchFilterMask() {
            const searchValue = searchMask.value;
            console.log(searchValue)
            if (searchValue == "") {
                GetlistMask()
                return
            } else {
                axios.post('/L_MetalMaskRecord/search-list-masks', {
                    search: searchValue
                }).then(res => {
                    listMask.value = res.data
                    // console.log(res.data)
                })
                    .catch(err => {
                        console.log(err)
                    })
            }

        }

        return {
            settingModel,
            settingMsk,
            DataModelChange,
            PullData,
            formf,
            GetData,
            SubmitChange,
            Menu,
            OpenMenuSettingModel,
            OpenMenuSettingMask,
            btnback,
            btnGoback,
            reportSettingModels,
            OpenMenulistModels,
            listModels,
            GetlistModels,
            OpenMenulistMask,
            reportSettingMask,
            listMask,
            GetlistMask,
            searchModels,
            SearchFilterModels,
            searchMask,
            SearchFilterMask,

        }
    }
}
</script>
