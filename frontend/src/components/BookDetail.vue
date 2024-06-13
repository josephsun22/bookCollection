<template>
    <div class="container">
      <h1>View & Edit Book</h1>
      <div class="cards">
        <div class="card">
          <h2>Book Details</h2>
          <p><strong>Title:</strong> {{ book.title }}</p>
          <p><strong>Author:</strong> {{ book.author }}</p>
          <p><strong>Genre:</strong> {{ book.genre }}</p>
          <p><strong>Published Year:</strong> {{ book.published_year }}</p>
          <p><strong>Description:</strong> {{ book.description }}</p>
        </div>
        <div class="card">
          <form @submit.prevent="validateForm">
            <div class="form-group">
              <label for="title">Title</label>
              <input
                type="text"
                id="title"
                v-model="book.title"
                :class="['form-control', { 'is-invalid': !book.title || titleError }]"
              />
            </div>
            <div class="form-group">
              <label for="author">Author</label>
              <input
                type="text"
                id="author"
                v-model="book.author"
                :class="['form-control', { 'is-invalid': !book.author || authorError }]"
                @blur="validateAuthor"
              />
              <span v-if="authorError" class="error-message">{{ authorError }}</span>
            </div>
            <div class="form-group">
              <label for="genre">Genre</label>
              <input
                type="text"
                id="genre"
                v-model="book.genre"
                :class="['form-control', { 'is-invalid': !book.genre }]"
              />
            </div>
            <div class="form-group">
              <label for="published_year">Published Year</label>
              <input
                type="text"
                id="published_year"
                v-model="book.published_year"
                :class="['form-control', { 'is-invalid': !book.published_year }]"
              />
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea
                id="description"
                v-model="book.description"
                :class="['form-control', { 'is-invalid': !book.description || descriptionError }]"
                @blur="validateDescription"
              ></textarea>
              <span v-if="descriptionError" class="error-message">{{ descriptionError }}</span>
            </div>
            <div class="button-group">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" @click="deleteBook()" class="btn btn-danger">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  
  <script>
  export default {
    props: ['id'], // Receives the id as a prop
    data() {
      return {
        book: {
        id: this.id,
        title: '',
        author: '',
        genre: '',
        published_year: '',
        description: ''
      },
        titleError: false,
        authorError: '',
        descriptionError: ''
      };
    },
    created() {
      if (this.id) {
        this.fetchBook(this.id);
      }
    },
    methods: {
      fetchBook(bookId) {
        fetch(`http://localhost:8888/book_collections/books/${bookId}`)
          .then(response => response.json())
          .then(data => {
            this.book = data;
          })
          .catch(error => {
            console.error('Error fetching book:', error);
          });
      },
      updateBook() {
        fetch(`http://localhost:8888/book_collections/books/${this.book.id}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(this.book),
        })
          .then(response => response.json())
          .then(data => {
            console.log(data);
            alert('Book updated successfully');
            this.$router.push('/'); // Redirect to book list
          })
          .catch(error => {
            console.error('Error updating book:', error);
          });
      },
      deleteBook() {
        fetch(`http://localhost:8888/book_collections/books/delete/${this.book.id}`, {
          method: 'DELETE',
        })
          .then(() => {
            alert('Book deleted successfully');
            this.$router.push('/'); // Redirect to book list
          })
          .catch(error => {
            console.error('Error deleting book:', error);
          });
      },
      validateAuthor() {
        const authorRegex = /^[a-zA-Z]+ [a-zA-Z]+$/;
        if (!authorRegex.test(this.book.author)) {
          this.authorError = 'Author must be a first name and last name';
        } else {
          this.authorError = '';
        }
      },
      validateDescription() {
        if (this.book.description.length < 100) {
          this.descriptionError = 'Description must be at least 100 characters';
        } else {
          this.descriptionError = '';
        }
      },
      validateForm() {
        this.titleError = !this.book.title;
        this.validateAuthor();
        this.validateDescription();
        if (!this.titleError && !this.authorError && !this.descriptionError) {
          this.updateBook();
        }
      },
    },
  };
  </script>
  
  <style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 20px;
}

.card {
  flex: 1 1 calc(50% - 10px);
  background-color: #fff;
  padding: 20px;
  margin: 10px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.card h2 {
  margin-bottom: 15px;
  color: #007bff;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
  border-color: #007bff;
  outline: none;
}

.is-invalid {
  border-color: red;
}

.error-message {
  color: red;
  font-size: 0.875em;
}

.button-group {
  display: flex;
  justify-content: space-between;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
}

.btn-danger:hover {
  background-color: #c82333;
}

@media (max-width: 768px) {
  .card {
    flex: 1 1 100%;
  }
}
</style>
