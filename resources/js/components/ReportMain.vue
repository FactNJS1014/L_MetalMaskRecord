<template>
    <div class="p-4">
      <table class="min-w-full bg-white border border-gray-200">
        <thead>
          <tr class="bg-gray-100 text-xl">
            <th class="text-left py-2 px-4">ID <span></span></th>
            <th class="text-left py-2 px-4">ยอดรวม</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(total, id) in groupedTotals" :key="id">
            <td class="py-2 px-4">{{ id }}</td>
            <td class="py-2 px-4">{{ total }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script setup>
  import { onMounted, reactive } from 'vue'
  import { toast } from 'vue3-toastify'

  const data = [
    { id: 1, value: 4000 },
    { id: 1, value: 3000 },
    { id: 1, value: 2000 },  // รวม = 9000 → แสดง Toast
    { id: 2, value: 1500 },
    { id: 2, value: 3000 },
    { id: 2, value: 2000 },
  ]

  const groupedTotals = reactive({})

  const calculateTotals = () => {
    const runningSums = {}

    for (let item of data) {
      const { id, value } = item

      if (!groupedTotals[id]) {
        groupedTotals[id] = 0
        runningSums[id] = 0
      }

      if (runningSums[id] + value <= 9000) {
        runningSums[id] += value
        groupedTotals[id] = runningSums[id]

        // 🎉 แสดง toast เมื่อยอดรวมครบ 9000 พอดี
        if (runningSums[id] === 9000) {
          toast(`ID ${id} ครบยอด 9000 แล้ว! 🙂`,
            {
              "position": "top-center",
              "autoClose": 2000,
                "theme": "dark",
                "type": "warning",

            }
          )
        }
      }
    }
  }

  onMounted(() => {
    calculateTotals()
  })
  </script>
