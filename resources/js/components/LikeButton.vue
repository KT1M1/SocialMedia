<template>
    <div>
        <button @click="toggleLike" class="btn btn-outline-danger">
            <img :src="icon" alt="Like Icon" width="20" height="20" />
            {{ likesCount }}
        </button>
    </div>
</template>

<script>
export default {
    props: ['postId', 'isLiked', 'initialLikesCount'],

    data() {
        return {
            liked: this.isLiked,
            likesCount: this.initialLikesCount,
        };
    },

    methods: {
        toggleLike() {
            axios.post(`/like/${this.postId}`)
                .then(response => {
                    this.liked = !this.liked;
                    this.likesCount = response.data.likes_count;
                })
                .catch(error => {
                    if (error.response && error.response.status === 401) {
                        window.location = '/login';
                    }
                });
        }
    },

    computed: {
        icon() {
            return this.liked ? '/svg/heart.png' : '/svg/heart-outline.png';
        }
    }
};
</script>
