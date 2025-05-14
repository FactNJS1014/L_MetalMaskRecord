<template>
    <div class="relative">
        <div class="flex justify-center items-center mt-5 w-full">
            <div class="card w-[45%] lg:w-[50%] bg-white shadow-xl border border-cyan-600">

                <div class="card-body ">
                    <h5 class="card-title text-center font-bold text-2xl text-black bg-fuchsia-500 p-3 rounded-lg"><span
                            class="mr-3">&#128203;</span>Change Model Form</h5>
                    <form @submit.prevent="handleSubmit">
                        <div class="grid grid-cols-2  gap-4 text-black">
                            <div class="flex flex-col col-span-2">
                                <label for="won" class="text-xl font-bold">Work Order No. :
                                    <span>&#128292;</span></label>
                                <AutoComplete v-model="formChange.wonNo" :suggestions="items" field="label"
                                    @complete="search" @change="checkModel" placeholder="Search WONO..."
                                    class="input input-bordered w-full mt-2 text-white" />

                            </div>
                            <div class="flex flex-col ">
                                <label for="model" class="text-xl font-bold">Model ที่ต้องการเปลี่ยน :
                                    <span>&#128292;</span></label>
                                <input type="text" class="input input-bordered mt-2"
                                    placeholder="ใส่ข้อมูล Model ที่ต้องการเปลี่ยน..." v-model="formChange.mdlch" />
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
                                    <option v-for="line in linelist" :key="line.LINE_ID" :value="line.LINE_NAME">
                                        {{ line.LINE_NAME }}</option>

                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="process" class="text-xl font-bold">Process <span class="text-sky-600">(Ex. RF1 or RF2)</span> : <span>&#128292;</span></label>
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
                                <input type="text" class="input input-bordered mt-2" v-model="formChange.shift"
                                    placeholder="Shift Day or Night">
                                <!-- <select class="select select-bordered mt-2" v-model="formChange.shift">
                                    <option value="" disabled selected>Choose Shift</option>
                                    <option value="Day">Day</option>
                                    <option value="Night">Night</option>
                                </select> -->
                            </div>
                        </div>
                        <div class="card-actions mt-5 justify-between">
                            <button
                                class="btn btn-success text-2xl h-12 font-bold hover:bg-white hover:text-success hover:border-0"
                                type="submit"><i class="pi pi-save"></i> Change</button>
                            <!-- <button class="btn bg-teal-500 border-0 text-2xl h-12 font-bold text-black hover:bg-white hover:text-teal-500 hover:border-0" type="submit"><i class="pi pi-user-edit"></i> Change</button> -->

                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="flex justify-center items-center">
            <div class="card w-[50%] mt-3 border border-cyan-600 absolute top-155 " v-if="isModalShow">
                <div class="card-body">
                    <h5 class="card-title bg-pink-200 p-5 rounded-lg text-2xl"><span class="mx-2">&#128204;</span>Input
                        Remark
                        for Submit Approve Change Model</h5>
                    <p class="text-xl font-bold">{{ mChangeQRID }}</p>
                    <form @submit.prevent="SubmitAprChange(mChangeID)">
                        <div class="grid grid-cols-1 mt-5">
                            <div class="flex flex-col">
                                <div class="join mb-3">
                                    <label for="model"
                                        class="join-item rounded-s-lg bg-pink-100 w-60 text-lg font-semibold flex justify-start items-center text-black">Employee
                                        ID:</label>
                                    <input type="text" class="input input-bordered join-item rounded-e-lg"
                                        placeholder="Input Employee ID..." v-model="apr.empid" />
                                </div>

                            </div>
                            <div class="flex flex-col">
                                <div class="join mb-3">
                                    <label for="model"
                                        class="join-item rounded-s-lg bg-pink-100 w-60 text-lg font-semibold flex justify-start items-center text-black">Remark
                                        for Approve:</label>
                                    <input type="text" class="input input-bordered join-item rounded-e-lg"
                                        placeholder="Input Remark for Approve..." v-model="apr.aprremark" />
                                </div>

                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <button class="btn btn-error h-12 text-lg mt-5" @click="CloseModal">Close</button>
                            <button class="btn btn-success h-12 text-lg mt-5">OK / Submit</button>
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

import AutoComplete from 'primevue/autocomplete';
import Swal from 'sweetalert2'
import axios from 'axios';
export default {
    name: "ChangeForm",
    components: {

        AutoComplete,
    },
    setup() {
        const v$ = useVuelidate()
        return { v$ }
    },
    data() {
        return {
            formChange: {
                empID: '',
                line: '',
                customer: '',
                process: '',
                wonNo: '',
                shift: '',
                mdlch: '',
            },

            items: [],
            mdlcode: "",
            linelist: [],
            session: this.$session,
            curtime: '',


        }
    },
    validations() {
        return {
            formChange: {
                empID: { required },
                line: { required },
                customer: { required },
                process: { required },
                wonNo: { required },
                shift: { required },
                mdlch: { required }
            },

        }
    },
    mounted() {
        this.GetDataChange(),
            this.GetSession(),
            this.GetTime()

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
                axios.post('/45_engmask/insert-change-model', {
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
                                empID: '',
                                line: '',
                                customer: '',
                                process: '',
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
        checkModel() {
            const won = this.formChange.wonNo;
            // console.log(this.mask.mdlcd)
            if (won.length >= 15) {
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
                            this.formChange.customer = item.BGCD;
                            this.formChange.mdlch = item.MDLCD;
                        }))
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

        },
        GetDataChange() {
            axios.get('/45_engmask/api/get-list-line')
                .then(res => {
                    this.linelist = res.data;
                    console.log(this.dataChange);
                })
                .catch(error => {
                    console.error('Error fetching change data:', error);
                });
        },
        GetSession() {
            this.formChange.empID = this.session.empno;
        },
        GetTime() {
            const now = new Date();
            const time = now.toLocaleTimeString();
            console.log(time);

            const shiftTime = new Date(
                now.getFullYear(),
                now.getMonth(),
                now.getDate(),
                19, 59, 59
            );

            if (now > shiftTime) {
                this.formChange.shift = 'Night';
            } else {
                this.formChange.shift = 'Day';
            }
        }




    },

}
</script>
