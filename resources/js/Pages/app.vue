<template>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div>
            <Link :href="route('users.index')" class="btn btn-lg btn-white border rounded-pill px-5 mx-3">USER</Link>
            <Link :href="route('posts.index')" class="btn btn-lg btn-white border rounded-pill px-5 mx-3">POSTS</Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

</script>

<style scoped>
.btn-white {
    background-color: white;
    color: black;
    font-weight: bold;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow for aesthetics */
}
</style>
