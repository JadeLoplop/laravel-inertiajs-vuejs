<template>
    <div>
        <div class="d-flex flex-row gap-5 align-items-center">
        <h1>Users</h1>
            <Link class="btn btn-warning btn-sm text-white" :href="route('app')">Go Back</Link>
        </div>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <button @click="confirmDelete(user.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import {Link, useForm} from "@inertiajs/vue3"
import { ref } from 'vue'

const props = defineProps({
    users: Array
})

const users = ref(props.users)

const deleteForm = useForm({});
const confirmDelete = (id) => {
    if (confirm("Are you sure you want to delete this user? This will also remove their posts.")) {
        deleteForm.delete(route("users.destroy", id), {
            preserveScroll: true,
        });
    }
}
</script>

