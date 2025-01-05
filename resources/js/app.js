// Import Vue
import { createApp } from 'vue';
import FollowButton from './components/FollowButton.vue';
import './bootstrap';

console.log('Vue app initialized');  // Debug log

// Create Vue app and register components
const app = createApp({});
app.component('follow-button', FollowButton);

// Mount the app to a DOM element
app.mount('#app');