<template>
    <div>
        <!-- Header Section -->
        <div class="bg-gray-800 pt-8 pb-20">
            <div class="w-9/12 text-center mr-auto ml-auto -mt-0 mb-0">
                <h1 class="text-orange text-5xl p-10">Book Shop</h1>
                <p class="w-9/12 mr-auto ml-auto -mt-0 mb-0 text-white">
                    Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. Soufflé macaroon liquorice chocolate tart I love.
                </p>
            </div>
        </div>

        <!-- Search Box -->
        <div class="w-1/2 text-left mr-auto ml-auto mt-5 mb-5">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search by book title ..."
                class="w-full p-2 border rounded"
            />
        </div>

        <!-- Table Section -->
        <div class="w-9/12 mr-auto ml-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-4">Title</th>
                    <th class="p-4">Author</th>
                    <th class="p-4">Rating</th>
                    <th class="p-4">Actions</th>
                </tr>
                </thead>
                <tbody>
                <!-- Render filteredBooks dynamically -->
                <tr v-for="(book, index) in filteredBooks" :key="index" class="border-b border-gray-300">
                    <td class="p-4">{{ book.title }}</td>
                    <td class="p-4">{{ book.author }}</td>
                    <td class="p-4">{{ book.rating }}</td>
                    <td class="p-4">
                        <button @click="editBook(index)" class="text-black-500 font-bold underline mr-4">Edit</button>
                        <button @click="deleteBook(index)" class="text-black-500 font-bold underline">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Fuse from 'fuse.js';


export default {
    name: 'BookListing',
    data() {
        return {
            searchQuery: '',
            books: [],
        };
    },
    computed: {
        filteredBooks() {
            const options = {
                keys: ['title'],
                threshold: 0.3,
            };
            const fuse = new Fuse(this.books, options);
            return this.searchQuery ? fuse.search(this.searchQuery).map(result => result.item) : this.books;
        },
    },
    methods: {
        async fetchBooks() {
            try {
                const response = await axios.get('/api/books');
                this.books = response.data.data;
            } catch (error) {
                console.error('Error fetching books:', error);
            }
        },
        editBook(index) {
            const book = this.books[index];
            this.$router.push({ name: 'EditBook', params: { id: book.id } });
        },
        async deleteBook(index) {
            try {
                await axios.delete(`/api/books/${this.books[index].id}`);
                alert(`Book Deleted Successfully.`);
                this.books.splice(index, 1);
            } catch (error) {
                console.error('Error deleting book:', error);
                alert('Failed to delete the book. Please try again.');
            }
        },
    },
    mounted() {
        this.fetchBooks();
    },
};
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    border-right: 1px solid #ddd;
}

th {
    background-color: #333;
    color: white;
}
</style>
