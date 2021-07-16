<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            You're logged in!

            <div><button @click="createToken">Create token</button></div>
            <div><button @click="getToken">Get token</button></div>
            <div><button @click="getUser">Get user</button></div>
          </div>
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
  methods: {
    createToken() {
      axios.post("/api/tokens/create", { token_name: "api" }).then((res) => {
        console.log(res);
      });
    },
    getUser() {
      axios.get("/api/user");
    },
    getToken() {
      axios.get("/api/token");
    },
  },
};
</script>
