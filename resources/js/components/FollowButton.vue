<template>
    <div>
        <button class="btn btn-primary" @click="followUser" v-text="buttonText" style="margin-left: 10px"></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows'],

        mounted() {
            console.log('FollowButton component mounted');
        },

        data: function() {
            return {
                status: this.follows,
            }
        },
        
        methods: {
            followUser(){
                axios.post('/follow/' + this.userId)
                .then(response => {
                    this.status = ! this.status;

                    console.log(response.data);
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                });
            }
        },

        computed: {
            buttonText() {
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }

    }
</script>
