<template>
  <div class="home">
    <AddPost v-on:add-post="addPost" />
    <ul>
      <li v-for="post in posts" v-bind:key="post.id">
        <span>
          [<span>{{ formatID(post.id) }}</span>] "{{ formatTitle(post.title) }}" by {{ formatTitle(post.author) }}
        </span>
        <span class="del" @click="deletePost(post.id, $event)" :data-id="post.id">x</span>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';
import AddPost from '@/components/AddPost';
var somevar;

export default {
  name: 'Home',
  components: {
    AddPost
  },
  created() {
    axios
      .get('http://localhost:3000/posts')
      .then(response => {
        let posts = response.data, id = 0;
        this.posts = posts;
        for (let k = 0, len = posts.length, post = null; k < len; k += 1) {
          post = posts[k];
          if (id < post.id) {
            id = post.id;
          }
        }
        this.nextID = id + 1;
        // alert(this.nextID);
      })
      .catch(error => console.log(error));
  },
  data() {
    return {
      nextID: 0,
      posts: []
    };
  },
  methods: {
    addPost(post) {
      post.id = this.nextID;
      this.posts = [...this.posts, post];
      this.nextID += 1;
    },
    deletePost(id, event) {
      this.posts = this.posts.filter(post => post.id !== id );
      console.log(event);
    },
    formatID(id) {
      id = Number(id);
      if (id < 10) {
        return '00' + id;
      }
      if (id < 100) {
        return '0' + id;
      }
      return id;
    },
    formatTitle(title) {
      return title.charAt(0).toUpperCase() + title.substring(1);
    }
  }
}
</script>

<style scoped>
  ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  ul > li {
    margin-top: 1em;
  }
  div.home {
    text-align: left;
  }
  span.del {
    background-color: red;
    border-radius: 100%;
    color: white;
    cursor: pointer;
    float: right;
    padding: 4px 8px;
  }
</style>