<template>
    <div class="flex items-center justify-center w-full">
        <div class="card w-[80%]">
            <div class="card-body">
                <h5 class="text-2xl font-bold text-blue-600">รายการ Metal Mask Support</h5>
                <div class="overflow-x-auto mt-6">
                    <table class="table table-bordered border">
                        <thead>
                            <tr class="text-lg bg-green-200 text-black font-bold">
                                <th>Work Order</th>
                                <th>Model Code</th>
                                <th>LINE</th>
                                <th>PROCESS</th>
                                <th>MASK NAME</th>
                                <th>REVISION</th>
                                <th>REFERENCE NUMBER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in lists" :key="index" class="text-lg text-black font-semibold">
                                <td>{{ item.MMCHANGE_WONNO }}</td>
                                <td>{{ item.MMCHANGE_MDLCHN }}</td>
                                <td>{{ item.MMCHANGE_LINE }}</td>
                                <td>{{ item.MMCHANGE_PRCS }}</td>
                                <td>{{ item.MMST_MSKNAME }}</td>
                                <td>{{ item.MMST_REVS }}</td>
                                <td>{{ item.MMST_REFNO }}</td>
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