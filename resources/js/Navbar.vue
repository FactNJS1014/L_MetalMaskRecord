<template>
    <div class="flex justify-center ">
        <ul class="space-x-10 menu lg:menu-horizontal menu-horizontal mt-3 bg-gray-100 rounded-box shadow-lg ">
            <li>
                <router-link to="/changeform"
                    active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500"
                    class="text-black hover:text-blue-500">
                    <!-- <span class="icon-[material-symbols--counter-1] size-8"></span> -->
                    <span class="icon-[material-symbols--change-circle] size-8"></span>
                    เปลี่ยนโมเดล

                </router-link>
            </li>

            <li>
                <a @click="navigateWithReload('/reportChange')" class="text-black hover:text-blue-500" :class="[
                    'text-black hover:text-blue-500 cursor-pointer',
                    currentRoute === '/reportChange' ? 'text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500' : ''
                ]">
                    <span class="icon-[material-symbols--circle-notifications-rounded] size-8"></span>
                    การแจ้งเปลี่ยนโมเดล
                </a>
            </li>
            <li>
                <router-link to="/prmetalmask"
                    active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500"
                    class="text-black hover:text-blue-500">
                    <!-- <span class="icon-[material-symbols--counter-3-rounded] size-8"></span> -->
                    <span class="icon-[material-symbols--edit-document] size-8"></span>
                    บันทึกการใช้งาน
                </router-link>
            </li>

            <li>
                <a @click.prevent="navigateWithReload('/reportMain')" :class="[
                    'text-black hover:text-blue-500 cursor-pointer',
                    currentRoute === '/reportMain' ? 'text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500' : ''
                ]">
                    <span class="icon-[material-symbols--pie-chart] size-8"></span>
                    รายงานประวัติการใช้งาน
                </a>
            </li>
            <li>
                <router-link to="/setting"
                    active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500"
                    class="text-black hover:text-blue-500" v-if="permission == 9">
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
            currentRoute: this.$route.path

        };
    },
    watch: {
        '$route.path'(newPath) {
            this.currentRoute = newPath;
        }
    },
    methods: {
        navigateWithReload(path) {
            if (this.$route.path !== path) {
                // เปลี่ยน path ปกติ ถ้ายังไม่อยู่หน้านั้น
                this.$router.push(path).then(() => {
                    window.location.reload()
                })
            } else {
                // ถ้าอยู่หน้าเดิมแล้ว ให้แค่ reload
                window.location.reload()
            }
        }

    },

    mounted() {
        this.permission = this.session.permission;
        console.log('permission:', this.permission);

        // const path = this.$route.path;
        // const protectedPaths = ['/reportChange', '/reportMain','/setting']; // ใส่เฉพาะหน้าที่ต้องการป้องกัน

        // if (this.permission !== 9 && protectedPaths.includes(path)) {
        //     this.$router.push('/');
        // }
    }


};
</script>
