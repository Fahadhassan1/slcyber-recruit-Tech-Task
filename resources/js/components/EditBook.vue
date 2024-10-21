<template>
    <div>
        <div class="bg-gray-800 pt-8 pb-20">
            <div class="w-9/12 text-center mr-auto ml-auto -mt-0 mb-0">
            <h1 class="text-orange text-5xl p-10">Book Shop</h1>
            <p class="w-9/12 mr-auto ml-auto -mt-0 mb-0 text-white">Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. Soufflé macaroon liquorice chocolate tart I love.</p>
        </div>
    </div>
        <div class="w-1/5 text-left mr-auto ml-auto -mt-0 mb-0">
            <form @submit.prevent="submit">
                <div class="pt-10">
                    <h2 class="text-center text-3xl pb-10">Edit Book</h2>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Title: </label>
                        <input
                            v-model="book.title"
                            type="text"
                            placeholder="Title"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Author: </label>
                        <input
                            v-model="book.author"
                            type="text"
                            placeholder="Author"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Rating: </label>
                        <input
                            v-model="book.rating"
                            type="number"
                            placeholder="Rating"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                </div>
                <div class="text-center">
                    <button class="text-white bg-orange py-2 px-4 rounded" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'EditBook',
    data() {
        return {
            book: {
                title: '',
                author: '',
                rating: '',
            },
        };
    },
    computed: {
        bookId() {
            return this.$route.params.id;
        },
    },
    methods: {
        async fetchBook() {
            try {
                const response = await axios.get(`/api/books/${this.bookId}`);
                this.book = { ...response.data.data };

            } catch (error) {
                console.error('Error fetching the book data:', error);
            }
        },

        // Submit form and update the book
        async submit() {
            try {
                await axios.put(`/api/books/${this.bookId}`, this.book);
                alert('Book updated successfully!');
                await this.$router.push('/');
            } catch (error) {
                console.error('Error updating the book:', error);
                alert('Failed to update the book.');
            }
        },
    },
    mounted() {
        this.fetchBook();
    },
};
</script>
<style>

</style>
