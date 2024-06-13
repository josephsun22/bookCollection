<template>
  <div class="container">
    <h1>All Books</h1>
    <div class="book-list">
      <div v-for="book in books" :key="book.id" class="book-item">
        <router-link :to="{ name: 'BookDetail', params: { id: book.id } }" class="book-link">
          <span class="book-title">{{ book.title }}</span><br>
          <span class="book-author">by {{ book.author }}</span>
        </router-link>
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      books: []
    };
  },
  created() {
    this.fetchBooks();
  },
  methods: {
    fetchBooks() {
      axios.get('http://localhost:8888/book_collections/books')
        .then(response => {
          this.books = response.data;
        })
        .catch(error => {
          console.error('There was an error!', error);
        });
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  color: #333;
}

.book-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.book-item {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #fff;
  padding: 20px;
  margin: 10px;
  border: 2px solid #007bff;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, background-color 0.3s, color 0.3s;
  max-width: 300px;
  flex: 1 1 calc(20% - 40px); /* Adjust card width for 3 items per row */
  box-sizing: border-box;
  text-align: center;
}

.book-item:hover {
  transform: translateY(-2px);
  background-color: #007bff;
}

.book-item:hover .book-title, .book-item:hover .book-author {
  color: white;
}

.book-link {
  text-decoration: none;
  color: inherit;
}

.book-title {
  font-weight: bold;
  color: inherit;
  margin-bottom: 10px;
}

.book-author {
  font-style: italic;
  color: inherit;
}

@media (max-width: 768px) {
  .book-item {
    flex: 1 1 calc(50% - 40px); /* Adjust card width for 2 items per row */
  }
}

@media (max-width: 480px) {
  .container {
    padding: 10px;
  }

  .book-item {
    flex: 1 1 100%; /* Full width for single column layout */
    padding: 15px;
  }
}
</style>
