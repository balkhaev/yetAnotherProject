<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Токены</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="mt-1 relative rounded-md shadow-sm">
              <input
                type="text"
                id="token_name"
                v-model="token_name"
                class="
                  focus:ring-indigo-500
                  focus:border-indigo-500
                  block
                  w-full
                  pl-2
                  pr-12
                  sm:text-sm
                  border-gray-300
                  rounded-md
                "
                placeholder="Имя токена"
              />
              <div class="absolute inset-y-0 right-0 flex items-center">
                <button
                  class="
                    flex
                    h-full
                    py-0
                    pl-4
                    pr-4
                    border-transparent
                    bg-transparent
                    text-gray-500
                    sm:text-sm
                    rounded-md
                    items-center
                    justify-center
                    px-4
                    py-2
                    shadow-sm
                    font-medium
                    text-indigo-600
                    hover:bg-indigo-50
                  "
                  @click="createToken"
                >
                  Добавить
                </button>
              </div>
            </div>
          </div>
        </div>

        <div
          class="
            shadow
            overflow-hidden
            border-b border-gray-200
            sm:rounded-lg
            mt-12
          "
        >
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Имя
                </th>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Создан
                </th>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Использован
                </th>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Возможности
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Copy</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="token in tokens" :key="token.name">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="text-sm font-medium text-gray-900">
                      {{ token.name }}
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ toHumanDate(token.created_at) }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ toHumanDate(token.last_used_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ token.abilities }}
                </td>
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-right text-sm
                    font-medium
                  "
                  v-if="token.copyable"
                >
                  <a
                    @click="copy(token.token)"
                    class="
                      text-indigo-600
                      hover:text-indigo-900
                      hover:bg-indigo-50
                      px-4
                      py-2
                    "
                    >{{ copyed ? "Copyed" : "Copy" }}</a
                  >
                  <input type="hidden" id="testing-code" :value="token.token" />
                </td>
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-right text-sm
                    font-medium
                  "
                  v-else
                >
                  <a
                    @click="deleteToken(token.id)"
                    class="
                      text-indigo-600
                      hover:text-indigo-900
                      hover:bg-indigo-50
                      px-4
                      py-2
                    "
                    >Delete</a
                  >
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
      token_name: "",
      tokens: [],
      copyed: false,
    };
  },
  mounted() {
    this.getTokens();
  },
  methods: {
    toHumanDate(date) {
      return new Date(date).toLocaleString();
    },
    async getTokens() {
      const res = await axios.get("/api/tokens");

      this.tokens = res.data;
    },
    createToken() {
      axios
        .post("/api/tokens/create", { token_name: this.token_name })
        .then((res) => {
          const date = new Date();

          this.tokens.push({
            name: this.token_name,
            token: res.data.token,
            created_at: date,
            updated_at: date,
            abilities: `["*"]`,
            copyable: true,
          });
        });
    },
    deleteToken(tokenId) {
      axios.delete(`/api/tokens/${tokenId}`);

      const tokenIndex = this.tokens.findIndex((token) => token.id === tokenId);

      this.tokens.splice(tokenIndex, 1);
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
