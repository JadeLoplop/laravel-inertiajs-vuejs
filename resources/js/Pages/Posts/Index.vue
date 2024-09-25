<template>
    <div>
        <div class="d-flex flex-row gap-5 align-items-center">
            <h1>Posts</h1>
            <Link class="btn btn-warning btn-sm text-white" :href="route('app')">Go Back</Link>
        </div>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in posts" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.title }}</td>
                <td>{{ post.user.name }}</td>
                <td class="d-flex flex-row gap-2">
                    <Link
                        :href="route('posts.show', post.id)"
                        class="btn btn-info text-white"
                    >View
                    </Link>
                    <button @click="confirmDelete(post.id)" class="btn btn-outline-danger">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const deleteForm = useForm({});
const confirmDelete = (id) => {
    if (confirm("Are you sure you want to delete this post?")) {
        deleteForm.delete(route("posts.destroy", id), {
            preserveScroll: true,
        });
    }
}

const props = defineProps({
    posts: Array
})

</script>
