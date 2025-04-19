<template>
    <div class="mt-3 flex justify-center items-center">
        <div class="card w-[50%] mb-3 border border-emerald-300 bg-white shadow-lg" v-if="settingModel">
            <div class="card-body">
                <div class="border-base-content/25 w-full overflow-x-auto border">
                    <div class="">
                        <table class="table">
                            <thead>
                                <tr class="bg-emerald-500 text-white">
                                    <th class="text-center text-lg font-semibold">Model</th>
                                    <th class="text-center text-lg font-semibold">PCB No.</th>
                                    <th class="text-center text-lg font-semibold">Process</th>
                                    <th class="text-center text-lg font-semibold">Ref. No.</th>
                                    <th class="text-center text-lg font-semibold">QR Code ID</th>
                                    <th class="text-center text-lg font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center text-lg font-semibold">Model 1</td>
                                    <td class="text-center text-lg font-semibold">PCB No. 1</td>
                                    <td class="text-center text-lg font-semibold">Process 1</td>
                                    <td class="text-center text-lg font-semibold">Ref. No. 1</td>
                                    <td class="text-center text-lg font-semibold">QR Code ID 1</td>
                                    <td class="text-center text-lg font-semibold">
                                        <button type="button" class="btn btn-success btn-sm rounded-full ">
                                            &#10004;</button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <h5 class="card-title mb-0 text-center bg-emerald-300 p-5 rounded-lg text-black font-bold text-2xl">
                    Setting Model Form</h5>

                <form>
                    <div class="grid grid-cols-2 mt-5">
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="model"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">Model:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Model..." />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="pcbno"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">PCB
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="PCB Number..." />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="join mb-3">
                                <label for="process"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">Process:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Process..." />
                            </div>

                        </div>
                        <div class="flex flex-col ms-2">
                            <div class="join mb-3">
                                <label for="ref"
                                    class="join-item rounded-s-lg bg-emerald-100 w-24 text-lg font-semibold flex justify-center items-center">Ref.
                                    No.</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="Reference Number..." />
                            </div>
                        </div>
                        <div class="flex flex-col col-span-2 w-full">
                            <div class="join mb-3">
                                <label for="qrid"
                                    class="join-item rounded-s-lg bg-emerald-100 w-44 text-lg font-semibold flex justify-center items-center">QR
                                    Code ID:</label>
                                <input type="text" class="input input-bordered join-item rounded-e-lg"
                                    placeholder="QR Code Number..." />

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
    </div>
</template>
<script>
import { ref, onMounted } from 'vue'

export default {
    name: 'SettingMaster',
    setup() {
        const settingModel = ref(false)
        const settingMsk = ref(false)

        onMounted(() => {
            settingModel.value = true
            settingMsk.value = false
        })

        return {
            settingModel,
            settingMsk
        }
    }
}
</script>
