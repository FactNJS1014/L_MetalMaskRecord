<template>
    <div class="flex items-center justify-center w-full">
        <div class="card w-[80%]">
            <div class="card-body">
                <h5 class="text-2xl font-bold text-blue-600 text-center">รายการ Metal Mask Support</h5>
                <div class="overflow-x-auto mt-6">
                    <table class="table table-bordered border">
                        <thead>
                            <tr class="text-lg bg-green-300 text-black font-bold text-center">
                                
                                <th rowspan="2" class="border">Model Code</th>
                                
                                <th rowspan="2" class="border">PROCESS</th>
                                <th colspan="4" class="border">MASK NO.</th>
                                
                            </tr>
                            <tr class="bg-sky-200 text-lg">
                                <th class="border">1</th>
                                <th class="border">2</th>
                                <th class="border">3</th>
                                <th class="border">4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in lists" :key="index" class="text-lg text-black font-semibold">
                               <td class="border">{{ item.MMCHANGE_MDLCHN }}</td>
                               <td class="border">{{ item.MMCHANGE_PRCS }}</td>
                               <td class="border">{{ item.LISTMDL_MSKNO1 }}</td>
                               <td class="border">{{ item.LISTMDL_MSKNO2 }}</td>
                               <td class="border">{{ item.LISTMDL_MSKNO3 }}</td>
                               <td class="border">{{ item.LISTMDL_MSKNO4 }}</td>
                               
                            </tr>
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    props: {
        lists: {
            type: Object,
            default: () => []
        },
    }
}
</script>