import { createRouter, createWebHistory } from "vue-router";
import ChangeForm from "./components/ChangeForm.vue";
import Report from "./components/ReportChangeModel.vue";
import RecordPR from "./components/RecordPR.vue";
import ReportMain from "./components/ReportMain.vue";

const routes = [
    {
        path: "/",
        name: "index",
        component: ChangeForm,
    },
    {
        path: "/reportChange",
        name: "report",
        component: Report,
    },
    {
        path: "/prmetalmask",
        name: "recordPR",
        component: RecordPR,
    },
    {
        path: "/reportMain",
        name: "reportMain",
        component: ReportMain,
    }

]

const router = createRouter({
    history: createWebHistory('/L_MetalMaskRecord'),
    routes,
})

export default router

