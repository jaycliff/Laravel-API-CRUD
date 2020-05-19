<template>
    <form @submit="addPost" class="base">
        <input placeholder="Post title" type="text" v-model="title" name="title" />
        <button type="submit">Add Post</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            title: ''
        };
    },
    methods: {
        addPost(event) {
            this.$emit('add-post', {
                id: 0,
                title: this.title,
                body: 'sexy',
                author: 'Jaycliff'
            });
            this.title = '';
            event.preventDefault();
            console.log(event);
        }
    }
}
</script>

<style scoped>
    .base {
        align-items: stretch;
        display: flex;
    }
</style>