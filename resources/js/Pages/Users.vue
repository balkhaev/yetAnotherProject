<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">Users</div>
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
    this.getItems();
  },
  methods: {
    async getItems() {
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
