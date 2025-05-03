import { createRouter, createWebHistory } from "vue-router";
import ChangeForm from "./components/ChangeForm.vue";
import Report from "./components/ReportChangeModel.vue";
import RecordPR from "./components/RecordPR.vue";
import ReportMain from "./components/ReportMain.vue";
import Settingmaster from "./components/settingmaster.vue";
import DataChange from "./components/DataChange.vue";

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
    },
    {
        path: "/setting",
        name: "setting",
        component: Settingmaster,

    },
    {
        path: "/dataChange",
        name: "dataChange",
        component: DataChange,
    }

]

const router = createRouter({
    history: createWebHistory('/45_engmask'),
    routes,
})

export default router

