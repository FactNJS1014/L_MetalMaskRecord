<template>
    <div class="flex justify-center ">
        <ul class="space-x-10 menu lg:menu-horizontal menu-horizontal mt-3 bg-gray-100 rounded-box shadow-lg">
            <li>
                <router-link to="/" active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <!-- <span class="icon-[material-symbols--counter-1] size-8"></span> -->
                    <span class="icon-[material-symbols--change-circle] size-8"></span>
                   เปลี่ยนโมเดล

                </router-link>
            </li>

            <li>
                <router-link to="/reportChange" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <!-- <span class="icon-[material-symbols--counter-2] size-8"></span> -->
                    <span class="icon-[material-symbols--circle-notifications-rounded] size-8"></span>
                   การแจ้งเปลี่ยนโมเดล
                </router-link>

            </li>
            <li>
                <router-link to="/prmetalmask" active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <!-- <span class="icon-[material-symbols--counter-3-rounded] size-8"></span> -->
                    <span class="icon-[material-symbols--edit-document] size-8"></span>
                    บันทึกการใช้งาน
                </router-link>
            </li>
            
            <li>
                <router-link to="/reportMain" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <!-- <span class="icon-[material-symbols--counter-4-rounded] size-8"></span> -->
                    <span class="icon-[material-symbols--pie-chart] size-8"></span>
                    รายงานประวัติการใช้งาน
                </router-link>

            </li>
            <li>
                <router-link to="/setting" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <!-- <span class="icon-[material-symbols--counter-5-rounded] size-8"></span> -->
                    <span class="icon-[material-symbols--settings-alert-rounded] size-8"></span>
                    ตั้งค่า Master ข้อมูล
                </router-link>

            </li>
            <!-- <p><strong>Username:</strong> {{ session.username }}</p> -->
        </ul>
    </div>
</template>
<script>
export default {
    data() {
        return {
            session: this.$session,
            permission: '',
        };
    },
    mounted() {
        this.permission = this.session.permission;
        console.log('permission:', this.permission);
    }
};
</script>

