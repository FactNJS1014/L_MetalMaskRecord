<template>
    <div class="flex items-center justify-center w-full mt-5">
        <div class="card w-[80%]">            
            <div class="card-body">
                <table class="table text-xl font-medium border-2">
                    <tr class="border-2">
                        <td class="bg-cyan-300">Work Order</td>
                        <td>{{lists.MMCHANGE_WONNO}}</td>
                    </tr>
                    <tr class="border-2">
                        <td class="bg-cyan-300">Model</td>
                        <td>{{lists.MMCHANGE_MDLCHN}}</td>
                    </tr>
                    <tr class="border-2">
                        <td class="bg-cyan-300">Customer</td>
                        <td>{{lists.MMCHANGE_CUS}}</td>
                    </tr>
                    <tr class="border-2">
                        <td class="bg-cyan-300">Process</td>
                        <td>{{lists.MMCHANGE_PRCS}}</td>
                    </tr>
                    <tr class="border-2">
                        <td class="bg-cyan-300">LINE</td>
                        <td>{{lists.MMCHANGE_LINE}}</td>
                    </tr>
                </table>
            </div>
           
        </div>
    </div>
</template>

<script>
export default {
    props: {
        lists:{
            type:Object,
            default:()=>({})
        },
    }
}
</script>