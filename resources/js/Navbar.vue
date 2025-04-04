<template>
    <div class="flex justify-center">
        <ul class="space-x-10 menu lg:menu-horizontal menu-horizontal mt-3">
            <li>
                <router-link to="/" active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-1] size-8"></span>
                   Change Model Form

                </router-link>
            </li>
            <li>
                <router-link to="/prmetalmask" active-class="text-xl font-bold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-2-rounded] size-8"></span>

                    บันทึก Metal Mask
                </router-link>
            </li>
            <li>
                <router-link to="/reportChange" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-3] size-8"></span>

                    Report Change Model
                </router-link>

            </li>
            <li>
                <router-link to="/reportMain" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--counter-4-rounded] size-8"></span>

                    Report Metal Mask
                </router-link>

            </li>
        </ul>
    </div>
</template>
