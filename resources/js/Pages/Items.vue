<template>
  <breeze-authenticated-layout>
    <template #header>
      <div class="flex justify-between align-middle">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Предметы
        </h2>
        <form @submit.prevent="upload">
          <input
            id="file-input"
            type="file"
            @input="onInput($event)"
            class="hidden"
          />
          <label
            for="file-input"
            class="
              relative
              bg-blue-500
              text-white
              px-6
              py-2
              rounded
              overflow-hidden
              hover:bg-blue-800
            "
          >
            {{ form.progress ? form.progress.percentage + "%" : "Загрузить" }}
          </label>
        </form>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded">
          <table class="min-w-max w-full table-auto">
            <thead>
              <tr
                class="
                  bg-gray-200
                  text-gray-600
                  uppercase
                  text-sm
                  leading-normal
                "
              >
                <th class="py-3 px-6 text-left">IMG</th>
                <th class="py-3 px-6 text-left">Имя</th>
                <th class="py-3 px-6 text-left">Торговец</th>
                <th class="py-3 px-6 text-left">Цена (торг)</th>
                <th class="py-3 px-6 text-left">Цена (бара)</th>
                <th class="py-3 px-6 text-center">Слотов</th>
                <th class="py-3 px-6 text-center">Действия</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
              <tr
                class="border-b border-gray-200 hover:bg-gray-100"
                v-for="item in items"
                :key="item.id"
              >
                <td class="py-3 px-6 text-left">
                  <div class="flex items-center">
                    <div class="mr-2">
                      <img class="w-6 h-6" :src="item.img" />
                    </div>
                  </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                  <div class="flex items-center">
                    <a
                      class="font-medium"
                      :href="item.wikiLink"
                      target="_blank"
                    >
                      {{ item.shortName }}
                    </a>
                  </div>
                </td>
                <td class="py-3 px-6 text-left">
                  {{ item.traderName }}
                </td>
                <td class="py-3 px-6 text-left">
                  {{ toHumanInt(item.traderPrice) }} ₽
                </td>
                <td class="py-3 px-6 text-left">
                  {{ toHumanInt(item.price) }} ₽
                </td>
                <td class="py-3 px-6 text-center">
                  {{ item.slots }}
                </td>
                <td class="py-3 px-6 text-center">
                  <div class="flex item-center justify-center">
                    <div
                      class="
                        w-4
                        mr-2
                        transform
                        hover:text-purple-500
                        hover:scale-110
                      "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                      </svg>
                    </div>
                    <div
                      class="
                        w-4
                        mr-2
                        transform
                        hover:text-purple-500
                        hover:scale-110
                      "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                        />
                      </svg>
                    </div>
                    <div
                      class="
                        w-4
                        mr-2
                        transform
                        hover:text-purple-500
                        hover:scale-110
                      "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import axios from "axios";

export default {
  components: {
    BreezeAuthenticatedLayout,
  },
  data() {
    return {
      items: [],
      form: this.$inertia.form({
        name: "items",
        items: null,
      }),
    };
  },
  mounted() {
    this.getItems();
  },
  methods: {
    onInput($event) {
      this.form.items = $event.target.files[0];

      this.form.post("/api/items");
    },
    toHumanInt(num) {
      return num.toLocaleString();
    },
    async getItems() {
      const res = await axios.get("/api/items");

      this.items = res.data;
    },
    createToken() {
      axios.post("/api/items").then((res) => {
        const date = new Date();

        this.items.push({
          name: this.token_name,
          token: res.data.token,
          created_at: date,
          updated_at: date,
          abilities: `["*"]`,
          copyable: true,
        });
      });
    },
    copy() {
      let testingCodeToCopy = document.querySelector("#testing-code");
      testingCodeToCopy.setAttribute("type", "text");
      testingCodeToCopy.select();

      this.copyed = document.execCommand("copy");

      /* unselect the range */
      testingCodeToCopy.setAttribute("type", "hidden");
      window.getSelection().removeAllRanges();
    },
  },
};
</script>
