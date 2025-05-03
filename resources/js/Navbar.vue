<template>
    <div class="flex justify-center ">
        <ul class="space-x-10 menu lg:menu-horizontal menu-horizontal mt-3 bg-gray-100 rounded-box shadow-lg">
            <li>
                <router-link to="/" active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-1] size-8"></span>
                   เปลี่ยนโมเดล

                </router-link>
            </li>
            <li>
                <router-link to="/reportChange" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-2] size-8"></span>

                   การแจ้งเปลี่ยนโมเดล
                </router-link>

            </li>
            <li>
                <router-link to="/prmetalmask" active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-3-rounded] size-8"></span>

                    บันทึกการใช้งาน
                </router-link>
            </li>
            
            <li>
                <router-link to="/reportMain" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-4-rounded] size-8"></span>

                    รายงานประวัติการใช้งาน
                </router-link>

            </li>
            <li>
                <router-link to="/setting" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-5-rounded] size-8"></span>

                    ตั้งค่า Master ข้อมูล
                </router-link>

            </li>
            <!-- <p><strong>Username:</strong> {{ session.username }}</p> -->
        </ul>
    </div>
</template>

// <script>
// import axios from 'axios';

// export default {
//     mounted() {
//         const params = new URLSearchParams(window.location.search);

//         const sessionData = {
//             username: params.get('username'),
//             empno: params.get('empno'),
//             department: params.get('department'),
//             USE_PERMISSION: params.get('USE_PERMISSION'),
//             sec: params.get('sec'),
//             MSECT_ID: params.get('MSECT_ID'),
//         };

//         if (sessionData.empno) {
//             this.setSession(sessionData);
//         }
       
//     },
//     methods: {
//         setSession(data) {
//             axios.post('/45_engmask/set-session', data)
//                 .then(() => {
//                     console.log('Session set successfully');
//                     // Optionally redirect or load data
//                 })
//                 .catch(err => {
//                     console.error('Session error:', err);
//                 });
//         }
//     }
// };
// </script>
