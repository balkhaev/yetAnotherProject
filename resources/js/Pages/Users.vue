<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Пользователи
      </h2>
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
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-center">Created</th>
                <th class="py-3 px-6 text-center">Updated</th>
                <th class="py-3 px-6 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
              <tr
                class="border-b border-gray-200 hover:bg-gray-100"
                v-for="user in users"
                :key="user.id"
              >
                <td class="py-3 px-6 text-left whitespace-nowrap">
                  <div class="flex items-center">
                    <span class="font-medium">{{ user.name }}</span>
                  </div>
                </td>
                <td class="py-3 px-6 text-left">
                  {{ user.email }}
                </td>
                <td class="py-3 px-6 text-center">
                  <div class="flex items-center justify-center">
                    {{ toHumanDate(user.created_at) }}
                  </div>
                </td>
                <td class="py-3 px-6 text-center">
                  <div class="flex items-center justify-center">
                    {{ toHumanDate(user.updated_at) }}
                  </div>
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
  data: () => {
    return {
      users: [],
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    toHumanDate(date) {
      return new Date(date).toLocaleString();
    },
    async getUsers() {
      const res = await axios.get("/api/users");

      this.users = res.data;
    },
    createToken() {
      axios.post("/api/items").then((res) => {
        const date = new Date();

        this.users.push({
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
