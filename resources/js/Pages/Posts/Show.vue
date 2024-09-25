<template>
    <div>
        <h1>{{ post.title }}</h1>
        <p>Author: {{ post.user.name }}</p>
        <p>{{ post.content }}</p>
        <Link :href="route('posts.index')" class="btn btn-primary">Back to Posts</Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from 'vue'

const props = defineProps({
    post: Object
})

const post = ref(props.post)
</script>
