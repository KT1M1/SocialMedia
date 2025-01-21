<template>
	<div>
		<!-- Display Comments -->
		<div v-for="comment in comments" :key="comment.id" class="comment">
			<!-- Main Comment -->
			<div class="comment-main">
				<strong class="username">{{ comment.user.username }}</strong>
				<span class="content">{{ comment.content }}</span>
				<div class="comment-actions">
					<span class="time">{{ formatTimestamp(comment.created_at) }}</span>
					<button class="reply-btn" @click="toggleReplyBox(comment.id)">Reply</button>
					<button v-if="comment.user_id === userId" class="delete-btn" @click="deleteComment(comment.id)">
						Delete
					</button>
					<button @click="toggleLike(comment)" class="like-btn">
						<img :src="comment.isLiked ? '/svg/heart.png' : '/svg/heart-outline.png'" alt="like"
							class="like-icon" />
						{{ comment.likes_count }}
					</button>
				</div>
			</div>

			<!-- Reply Input -->
			<div v-if="replyBoxes[comment.id]" class="reply-input">
				<textarea v-model="replies[comment.id]" class="form-control" placeholder="Write a reply..."></textarea>
				<button @click="addReply(comment.id)" class="btn btn-sm btn-primary">
					Post
				</button>
			</div>

			<!-- Replies -->
			<div v-if="comment.children?.length" class="replies">
				<div v-for="reply in comment.children" :key="reply.id" class="reply">
					<strong class="username">{{ reply.user.username }}</strong>
					<span class="content">{{ reply.content }}</span>
					<div class="comment-actions">
						<span class="time">{{ formatTimestamp(reply.created_at) }}</span>
						<!-- Allow delete and like actions for replies -->
						<button v-if="reply.user_id === userId" class="delete-btn" @click="deleteComment(reply.id)">
							Delete
						</button>
						<button @click="toggleLike(reply)" class="like-btn">
							<img :src="reply.isLiked ? '/svg/heart.png' : '/svg/heart-outline.png'" alt="like"
								class="like-icon" />
							{{ reply.likes_count }}
						</button>
					</div>
				</div>
			</div>
			<!-- Separator -->
			<hr />
		</div>

		<!-- Add a New Comment -->
		<textarea v-model="newComment" placeholder="Add a comment..." class="form-control mt-3"></textarea>
		<button @click="addComment" class="btn btn-primary mt-2">Post</button>
	</div>
</template>

<script>
export default {
	props: {
		postId: [String, Number],
		userId: Number,
	},
	data() {
		return {
			comments: [],
			newComment: '',
			replies: {},
			replyBoxes: {}, // Tracks open reply boxes
		};
	},
	created() {
		this.fetchComments();
	},
	methods: {
		fetchComments() {
			axios.get(`/p/${this.postId}/comments`).then((response) => {
				this.comments = response.data.map((comment) => ({
					...comment,
					isLiked: comment.likes?.includes(this.userId),
				}));
			});
		},
		addComment() {
			if (!this.newComment.trim()) return;

			axios.post(`/p/${this.postId}/comments`, { content: this.newComment }).then((response) => {
				const newComment = response.data;
				newComment.isLiked = false;
				this.comments.push(newComment);
				this.newComment = '';
			});
		},
		toggleReplyBox(commentId) {
			this.replyBoxes[commentId] = !this.replyBoxes[commentId];
		},
		addReply(parentId) {
			if (!this.replies[parentId]?.trim()) return;

			axios
				.post(`/p/${this.postId}/comments`, {
					content: this.replies[parentId],
					parent_id: parentId,
				})
				.then((response) => {
					const parentIndex = this.comments.findIndex((c) => c.id === parentId);
					if (parentIndex !== -1) {
						if (!this.comments[parentIndex].children) {
							this.comments[parentIndex].children = [];
						}
						this.comments[parentIndex].children.push(response.data);
					}
					this.replies[parentId] = '';
					this.replyBoxes[parentId] = false; // Close the reply box after posting
				});
		},
		toggleLike(comment) {
			axios.post(`/p/comments/${comment.id}/like`).then((response) => {
				comment.likes_count = response.data.likes_count;
				comment.isLiked = response.data.likes.includes(this.userId);
			});
		},
		deleteComment(commentId) {
			if (!confirm('Are you sure you want to delete this comment?')) {
				return;
			}

			axios.delete(`/p/comments/${commentId}`).then(() => {
				// Remove deleted comment from the comments array
				this.comments = this.comments.filter((comment) => comment.id !== commentId);

				// Also remove the comment from any children arrays
				this.comments.forEach((parent) => {
					if (parent.children) {
						parent.children = parent.children.filter((reply) => reply.id !== commentId);
					}
				});
			});
		},
		formatTimestamp(timestamp) {
			const date = new Date(timestamp);
			return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`;
		},
	},
};
</script>

<style scoped>
.comment {
	margin-bottom: 15px;
}

.comment-main {
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	flex-wrap: wrap;
}

.username {
	font-weight: bold;
	margin-right: 5px;
}

.content {
	margin-right: auto;
	word-wrap: break-word;
}

.comment-actions {
	display: flex;
	align-items: center;
	font-size: 12px;
	color: gray;
}

.comment-actions .reply-btn,
.comment-actions .delete-btn {
	margin-left: 10px;
	border: none;
	background: none;
	cursor: pointer;
	color: inherit;
}

.like-btn {
	margin-left: 10px;
	border: none;
	background: none;
	cursor: pointer;
}

.like-icon {
	width: 16px;
	height: 16px;
	vertical-align: middle;
}

textarea {
	width: 100%;
	resize: none;
}

.replies {
	margin-left: 20px;
	margin-top: 10px;
}

.reply-input {
	margin-top: 10px;
}

hr {
	border: 0;
	border-top: 1px solid #ddd;
	margin: 15px 0;
}

@media screen and (max-width: 768px) {
	.comment-main {
		flex-direction: column;
	}

	.comment-actions {
		margin-top: 5px;
	}
}
</style>
