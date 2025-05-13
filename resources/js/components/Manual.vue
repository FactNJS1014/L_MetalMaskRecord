<template>
    <div class="flex justify-center items-center mt-3">
        <div class="card w-[60%] lg:w-[70%] bg-white shadow-xl border border-cyan-600">
            <div class="card-body">
                <div class="card-header bg-sky-300 text-black">
                    <h2 class="card-title">Welcome, {{ session.username }} &nbsp; {{ session.empno }}</h2>
                </div>
                <table class="table">
                    <tr class="border">
                        <th class="border text-xl">View PDF</th>
                        <td class="border"><button @click="openInNewTab" class="cursor-pointer btn btn-accent">
                                คู่มือการใช้งาน
                            </button></td>
                    </tr>
                    <tr class="border">
                        <th class="border text-xl">View Video <br> ( ตัวอย่างสาธิตการใช้งาน )</th>
                        <td class="border">
                            <VideoPlayer ref="player" class="video-js vjs-default-skin" :options="playerOptions"
                                @ready="onPlayerReady" style="width: 400px; height: 300px;" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import { VideoPlayer } from '@videojs-player/vue';
import 'video.js/dist/video-js.css';
export default {
    components: {
        VideoPlayer
    },
    data() {
        return {
            session: this.$session,
            src: window.documentPath,
            playerOptions: {
                autoplay: false,
                controls: true,
                responsive: true,
                fluid: true,
                width: 800,   // Set desired width
                height: 900,  // Set desired height
                sources: [
                    {
                        src: window.videoPath,
                        type: 'video/mp4'
                    }
                ]
            }
        };
    },
    methods: {
        openInNewTab() {
            const newTab = window.open(this.src, '_blank');
            if (newTab) {
                newTab.focus();
            } else {
                alert('Please allow pop-ups for this website.');
            }
        },
        onPlayerReady(player) {
            console.log('Video.js Player Ready', player);
            // You can store or control the player instance here
        }
    }
};
</script>
