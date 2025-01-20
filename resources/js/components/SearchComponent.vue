<template>
	<div class="search-bar position-relative">
		<input type="text" class="form-control" placeholder="Search for users..." v-model="query"
			@input="fetchResults" />
		<div v-if="results.length > 0" class="dropdown-menu show w-100">
			<a v-for="result in results" :key="result.id" :href="`/profile/${result.id}`"
				class="dropdown-item d-flex align-items-center">
				<!-- User name and image -->
				<img v-if="result.image" :src="`/storage/${result.image}`" alt="Profile Image"
					class="rounded-circle me-2" style="width: 30px; height: 30px;" />
				<span>{{ result.name }} ({{ result.username }})</span>
			</a>
		</div>
	</div>
</template>

<script>
import axios from "axios";

export default {
	data() {
		return {
			query: "",
			results: [],
		};
	},
	methods: {
		fetchResults() {
			if (this.query.trim() === "") {
				this.results = [];
				return;
			}

			axios
				.get(`/search`, { params: { query: this.query } })
				.then((response) => {
					this.results = response.data.results;
				})
				.catch((error) => {
					console.error("Error:", error);
					this.results = [];
				});
		},
	},
};
</script>

<style>
.search-bar {
	margin: 0 auto;
}

.dropdown-menu {
	max-height: 300px;
	overflow-y: auto;
	z-index: 1050;
}
</style>
