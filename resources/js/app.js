// Import Vue
import { createApp } from 'vue';
import FollowButton from './components/FollowButton.vue';
import LikeButton from './components/LikeButton.vue';
import SearchComponent from "./components/SearchComponent.vue";
import './bootstrap';

console.log('Vue app initialized');

// Create Vue app and register components
const app = createApp({});
app.component('follow-button', FollowButton);
app.component('like-button', LikeButton);
app.component("search-component", SearchComponent);

// Mount the app to a DOM element
app.mount('#app');