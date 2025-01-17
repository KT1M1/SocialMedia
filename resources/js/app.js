// Import Vue
import { createApp } from 'vue';
import FollowButton from './components/FollowButton.vue';
import LikeButton from './components/LikeButton.vue';
import './bootstrap';

console.log('Vue app initialized');

// Create Vue app and register components
const app = createApp({});
app.component('follow-button', FollowButton);
app.component('like-button', LikeButton);

// Mount the app to a DOM element
app.mount('#app');