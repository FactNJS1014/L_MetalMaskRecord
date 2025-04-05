<template>
    <div class="flex justify-center items-center mt-5 w-full">
        <div class="card w-[45%] lg:w-[50%] bg-base-100 shadow-xl">
            <div class="card-body ">
                <h5 class="card-title text-center font-bold text-2xl text-black bg-blue-300 p-3 rounded-lg"><span class="mr-3">&#128203;</span>Change Model Form</h5>
                <form @submit.prevent="handleSubmit">
                    <div class="grid grid-cols-2  gap-4 text-black">
                        <div class="flex flex-col col-span-2">
                            <label for="Barcode" class="text-xl font-bold">Barcode : <span>&#128292;</span></label>
                            <input type="text" class="input input-bordered mt-2" placeholder="Barcode" v-model="formChange.barcode" />
                        </div>
                        <div class="flex flex-col">
                            <label for="empID" class="text-xl font-bold">EmpID : <span>&#128292;</span></label>
                            <input type="text" class="input input-bordered mt-2" placeholder="Employee ID" v-model="formChange.empID" />
                        </div>
                        <div class="flex flex-col">
                            <label for="Line" class="text-xl font-bold">Line SMT : <span>&#128292;</span></label>
                            <select class="select select-bordered mt-2" v-model="formChange.line">
                                <option disabled selected>Choose Line</option>
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
                            <label for="customer" class="text-xl font-bold">Customer : <span>&#128292;</span></label>
                            <input type="text" class="input input-bordered mt-2" placeholder="Customer" v-model="formChange.customer" />
                        </div>
                        <div class="flex flex-col">
                            <label for="process" class="text-xl font-bold">Process : <span>&#128292;</span></label>
                            <input type="text" class="input input-bordered mt-2" placeholder="Process" v-model="formChange.process" />
                        </div>
                        <div class="flex flex-col col-span-2">
                            <label for="model" class="text-xl font-bold">Model : <span>&#128292;</span></label>
                            <input type="text" class="input input-bordered mt-2" placeholder="Model" v-model="formChange.model"/>
                        </div>
                        <div class="flex flex-col">
                            <label for="won" class="text-xl font-bold">Work Order No. : <span>&#128292;</span></label>
                            <input type="text" class="input input-bordered mt-2" placeholder="Won No." v-model="formChange.wonNo" />
                        </div>
                        <div class="flex flex-col">
                            <label for="shift" class="text-xl font-bold">Shift : <span>&#127747; or &#127751;</span></label>
                            <select class="select select-bordered mt-2" v-model="formChange.shift">
                                <option disabled selected>Choose Shift</option>
                                <option value="Day">Day</option>
                                <option value="Night">Night</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-actions mt-5 justify-between">
                        <button class="btn btn-success text-2xl h-12 font-bold hover:bg-white hover:text-success hover:border-0" type="submit"><i class="pi pi-save"></i> Save</button>
                        <!-- <button class="btn bg-teal-500 border-0 text-2xl h-12 font-bold text-black hover:bg-white hover:text-teal-500 hover:border-0" type="submit"><i class="pi pi-user-edit"></i> Change</button> -->

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <div class="card w-[95%] mt-3 ">
            <div class="card-body">
                <h5 class="card-title text-center font-bold text-2xl text-black bg-blue-300 p-3 rounded-lg"><span class="mr-3">&#128214;</span>Change Model History</h5>
                <table class="table w-full overflow-x-auto text-black ">
                    <thead>
                        <tr class="text-center text-xl bg-info text-white">
                            <th>Issue</th>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>Customer</th>
                            <th>Model</th>
                            <th>Process</th>
                            <th>Won No.</th>
                            <th>SMT</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Add your data rows here -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</template>
<script>
import 'primeicons/primeicons.css'
import {useVuelidate} from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import "vue3-toastify/dist/index.css"
import { toast } from "vue3-toastify";

export default {
    setup() {
        const v$ = useVuelidate()
        return {v$}
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
            }
        }
    },
    validations(){
        return {
            formChange: {
                barcode: {required},
                empID: {required},
                line: {required},
                customer: {required},
                process: {required},
                model: {required},
                wonNo: {required},
                shift: {required}
            }
        }
    },
    methods: {
        async handleSubmit() {
            // Handle form submission logic here
            console.log("Form submitted");
            const isValid = await this.v$.$validate()
            if (!isValid) {
                toast.error("Please fill in all required fields.",{
                    position: "top-center",
                    duration: 5000,
                    theme: "colored",
                    autoClose: 2000,

                })
            } else {
                toast.success("Change Model Success",{
                    position: "top-center",
                    duration: 5000,
                    theme: "colored",
                    autoClose: 2000,
                })
            }
        }
    }
}
</script>
